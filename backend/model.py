from PIL import Image, ImageDraw, ImageFont

from keras.models import load_model
import numpy as np
from flask import Flask, jsonify
import tensorflow as tf


CROP_SIZE = 100
TARGET_SIZE = (224, 224)
SMOKE_THRESHOLD = 0.3


model = load_model('./models/ResNet50_scenario4.h5')
global graph
graph = tf.get_default_graph() 

app = Flask(__name__)


@app.route('/getNumberPatches')
def get_number_of_patches():
    test_image = Image.open('./images/test_image.jpg')
    number_patches = 0

    with graph.as_default():
        for x_index in range(test_image.size[0] // CROP_SIZE):
            for y_index in range(test_image.size[1] // CROP_SIZE):
                x_start = x_index * CROP_SIZE
                y_start = y_index * CROP_SIZE
                x_finish = x_index * CROP_SIZE + CROP_SIZE
                y_finish = y_index * CROP_SIZE + CROP_SIZE
                crop_check = test_image.crop((x_start, y_start, x_finish, y_finish)).resize(TARGET_SIZE)
                
                test_example = np.expand_dims(np.asarray(crop_check), 0)
                
                prediction = model.predict(test_example)[0]

                if prediction[1] >= SMOKE_THRESHOLD:
                    number_patches += 1

    return jsonify({'status': 'ok', 'number_smoke_patches': number_patches})
