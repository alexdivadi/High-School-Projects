import numpy as np
import librosa
from sklearn.preprocessing import LabelEncoder
from sklearn.model_selection import train_test_split 
from keras.utils import to_categorical
from sklearn.preprocessing import scale

def min_max_value(data):
    x = 0
    y = 0
    for array in data:
        for item in array:
            if x < item:
                x = item
            if y > item:
                y = item
    return [x, y]

path = '/home/david/Sounds/'
X = np.genfromtxt(path + 'X.csv', delimiter=',')
y = np.genfromtxt(path + 'y.csv', delimiter=',')

extremes = min_max_value(X)

print('Extremes: ', extremes)

audio, sr = librosa.load(path+'5instruments/2676d124.wav', res_type='kaiser_fast')
mfccs = librosa.feature.mfcc(y = audio, sr=sr, n_mfcc=40)
print(mfccs.shape)


"""
# Encode the classification labels
le = LabelEncoder()
yy = to_categorical(le.fit_transform(y)) 

# split the dataset 
x_train, x_test, y_train, y_test = train_test_split(X, yy, test_size=0.2, random_state = 42)

num_rows = 40
num_columns = 954
num_channels = 1

x_train = x_train.reshape(x_train.shape[0], num_rows, num_channels)

print("X shape: ", x_train.shape)
print(yy)
"""