from PIL import Image, ImageDraw, ImageFont

from keras.models import load_model
import numpy as np
from flask import Flask, jsonify
import tensorflow as tf


CROP_SIZE = 100
TARGET_SIZE = (224, 224)
SMOKE_THRESHOLD = 0.3


smoke_classifier = load_model('./models/ResNet50_scenario4.h5')
type_smoke_classifier = load_model('./models/black_white_smoke.h5')

global graph
graph = tf.get_default_graph() 

app = Flask(__name__)


@app.route('/retrieveImageFeatures')
def get_number_of_patches():
    test_image = Image.open('./images/test_image.jpg')

    with graph.as_default():
        densities = []
        found_coordinates = []

        for x_index in range(test_image.size[0] // CROP_SIZE):
            for y_index in range(test_image.size[1] // CROP_SIZE):

                coordinates = {
                                'x_index': x_index * CROP_SIZE, 
                                'y_index': y_index * CROP_SIZE
                              }
                sliding_example = retrieve_classification_example(test_image, coordinates)
                
                prediction = smoke_classifier.predict(sliding_example)[0]

                if prediction[1] >= SMOKE_THRESHOLD:
                    smoke_pred = type_smoke_classifier.predict(sliding_example)[0][1]
                    found_coordinates.append(coordinates)
                    densities.append(smoke_pred)
                    
    return jsonify({'status': 'ok', 
                    'dark_smoke': 1 if np.mean(densities) > 0.8 else 0,
                    'coordinates': found_coordinates, 
                    'fire': 1
                    })


def retrieve_classification_example(image, indices):
    x_finish = indices['x_index']  + CROP_SIZE
    y_finish = indices['y_index']  + CROP_SIZE

    crop = image.crop((indices['x_index'], indices['y_index'], x_finish, y_finish)).resize(TARGET_SIZE)
    crop_array = np.asarray(crop)

    return np.expand_dims(crop_array, axis=0)