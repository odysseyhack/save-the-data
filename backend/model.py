from PIL import Image, ImageDraw, ImageFont

from keras.models import load_model
import numpy as np
from flask import Flask, jsonify, request
import tensorflow as tf
import cv2  


CROP_SIZE = 100
TARGET_SIZE = (224, 224)
SMOKE_THRESHOLD = 0.3
BRIGHTNESS_THRESHOLD = 200
MINIMUM_NUMBER_BRIGHT = 5000    


smoke_classifier = load_model('./models/ResNet50_scenario4.h5')
type_smoke_classifier = load_model('./models/black_white_smoke.h5')

global graph
graph = tf.get_default_graph() 

app = Flask(__name__)


@app.route('/retrieveImageFeatures')
def get_number_of_patches():
    """
    Main method for running the classification algorithm
    """
    filename = request.args.get('filename')

    test_image = Image.open('/srv/www/savethedata/project/api/public/images/{}'.format(filename)).resize((800, 600))
    with graph.as_default():
        densities = []
        found_coordinates = []

        for x_index in range(test_image.size[0] // CROP_SIZE):
            for y_index in range(test_image.size[1] // CROP_SIZE):
                cords = {
                            'x_index': x_index * CROP_SIZE, 
                            'y_index': y_index * CROP_SIZE,
                            'x_finish': x_index * CROP_SIZE + CROP_SIZE,
                            'y_finish': y_index * CROP_SIZE + CROP_SIZE
                        }

                sliding_example = retrieve_classification_example(test_image, cords)
                
                # Probability that an image patch is smoke
                prediction = smoke_classifier.predict(sliding_example)[0]

                if prediction[1] >= SMOKE_THRESHOLD:
                    # Probability that the smoke is black
                    smoke_pred = type_smoke_classifier.predict(sliding_example)[0][1]

                    # Add blackness to calculate the darkness of a cloud
                    densities.append(smoke_pred)

                    # Store where we found the smoke 
                    found_coordinates.append([cords['x_index'], cords['y_index'], cords['x_finish'], cords['y_finish']])

    image = np.asarray(Image.open('/srv/www/savethedata/project/api/public/images/{}'.format(filename)).resize((800, 600)))

    # If no smoke is found, we assume that there is no smoke
    if len(found_coordinates) == 0:
        high_brightness = 0
    else:
        # Store the smoke predictions
        store_smoke_predictions(Image.fromarray(image), densities, found_coordinates, filename)

        # Load the Hue Saturation Value for retrieving brightness
        hsv = Image.fromarray(cv2.cvtColor(image, cv2.COLOR_BGR2HSV))

        store_fire_prediction(image, np.asarray(found_coordinates), filename)

        high_brightness = retrieve_fire_roi(hsv, found_coordinates)

    return jsonify({'status': 'ok', 
                    'dark_smoke': 1 if np.mean(densities) > 0.8 else 0,
                    'high_brightness': int(high_brightness)
                    })


def retrieve_classification_example(image, cords):
    """
    Retrieves a crop from the target image and resizes it to the target size for the neural network.
    Return a (1, TARGET_SIZE) numpy array
    """
    crop = image.crop((cords['x_index'], cords['y_index'], cords['x_finish'], cords['y_finish'])).resize(TARGET_SIZE)
    crop_array = np.asarray(crop)

    return np.expand_dims(crop_array, axis=0)


def retrieve_fire_roi(hsv_image, num_found):
    """
        To retrieve the possible fire location we look at the bottom of the fire. The location of the fire is located
        by looking at the bottom of a smoke cluster. Subsequently we draw a box and retrieve the number of high brightness
        pixels (Value in HSV). Lastly the image is stored. 
    """
    lowest_indices = np.unique(np.where(np.array(num_found)[:, 3].astype(int) == np.max([x[3] for x in num_found]))[0])
    lowest_cells = np.array(num_found)[lowest_indices].astype(int)

    left = np.min([x[0] for x in lowest_cells]) - 50
    right = np.max([x[2] for x in lowest_cells]) + 50
    top = np.max([x[3] for x in lowest_cells])
    bottom = top + 100

    fire_roi = np.asarray(hsv_image.crop((left, top, right, bottom)))

    _, _, value = cv2.split(fire_roi)

    value = cv2.equalizeHist(value) # Perform histogram normalization on the value channel
    number_above_threshold = np.unique(value.flatten() > BRIGHTNESS_THRESHOLD, return_counts=True)[1][1]

    return number_above_threshold


def store_smoke_predictions(image, densities, coordinates, filename):
    """
      Draw rectangles around the image patches where we found smoke and store
    """

    draw_image = image
    draw = ImageDraw.Draw(draw_image)
    for index, coord in enumerate(coordinates):
        draw.rectangle([(coord[0], coord[1]), (coord[2], coord[3])], outline='red')
        draw.text((coord[0] + 10, coord[1] + 10), str(densities[index]))

    draw_image.save('/srv/www/savethedata/project/api/public/images/smoke_predictions/{}'.format(filename))


def store_fire_prediction(image, coordinates, filename):
    """
        Store the fire prediction
    """

    hsv = cv2.cvtColor(image, cv2.COLOR_BGR2HSV)

    lowest_indices = np.unique(np.where(np.array(coordinates)[:, 3].astype(int) == np.max([x[3] for x in coordinates]))[0])
    lowest_cells = np.array(coordinates)[lowest_indices].astype(int)

    left = np.min([x[0] for x in lowest_cells]) - 50
    right = np.max([x[2] for x in lowest_cells]) + 50
    top = np.max([x[3] for x in lowest_cells])
    bottom = top + 100

    hsv_box = Image.fromarray(hsv)
    draw = ImageDraw.Draw(hsv_box)
    draw.rectangle([(left, top), (right, bottom)], outline='white')

    hsv_box.save('/srv/www/savethedata/project/api/public/images/hsv/{}'.format(filename))
