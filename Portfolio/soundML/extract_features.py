# Load various imports 
import pandas as pd
import os
import librosa
import wave
import numpy as np
from keras.preprocessing.sequence import pad_sequences
#from sklearn.preprocessing import scale

'''def audio_norm(data):
    max_data = np.max(data)
    min_data = np.min(data)
    data = (data-min_data)/(max_data-min_data+1e-6)
    return data-0.5'''

def max_length(features):
    y = 0
    for clip in features:
        if y < len(clip):
            y = len(clip)
    return y

def extract_features(file_name, min_shape):
   
    try:
        audio, sample_rate = librosa.load(file_name, res_type='kaiser_fast') 
        mfccs = librosa.feature.mfcc(y=audio, sr=sample_rate, n_mfcc=40)
        mfccsscaled = np.mean(mfccs.T,axis=0)  
        print(mfccs.shape)
        if mfccs.shape[1] < min_shape[0]:
            min_shape[0] = mfccs.shape[1]

    except:
        print("Error encountered while parsing file: ", file_name)
        return None 
     
    return mfccsscaled
    
def print_features(fname):
    wav = wave.open(fname)
    print("Sampling (frame) rate = ", wav.getframerate())
    print("Total samples (frames) = ", wav.getnframes())
    print("Duration = ", wav.getnframes()/wav.getframerate())

# Set the path to the full Sound dataset 
path = '/home/david/Sounds/'
fulldatasetpath = path + '5instruments'

metadata = pd.read_csv(path + 'allFiveInstruments.csv')

features = []

print("Extracting data...")
m = [173]
# Iterate through each sound file and extract the features 
for index, row in metadata.iterrows():
    
    file_name = os.path.join(os.path.abspath(fulldatasetpath),row['fname'])
    
    label = row["label"]
    data = extract_features(file_name, m)
    #print_features(file_name)
    features.append([data, label])


# Convert into a Panda dataframe 
featuresdf = pd.DataFrame(features, columns=['feature','label'])

print('Finished feature extraction from ', len(featuresdf), ' files')


# Convert features and corresponding classification labels into numpy arrays
X = np.array(featuresdf.feature.tolist())
y = np.array(featuresdf.label.tolist())

print(m[0])
#X = X.astype(np.float)

#np.savetxt(path + "X.csv", X, delimiter=",")
#np.savetxt(path + "y.csv", y, fmt='%s', delimiter=",")

# Encode the classification labels
le = LabelEncoder()
yy = to_categorical(le.fit_transform(y))

### MAX FEATURE IS 3343
### MIN FEATURE IS 4

import numpy as np
from sklearn.preprocessing import LabelEncoder
from sklearn.model_selection import train_test_split 
from keras.utils import to_categorical
from keras.models import Sequential
import keras.backend as K
from keras.preprocessing.sequence import pad_sequences
from keras.layers import LSTM, Embedding, Dense, Dropout, Activation, Flatten, Input
from keras.layers import Convolution2D, Conv2D, MaxPooling2D, GlobalAveragePooling2D
from keras.optimizers import Adam
from keras.utils import np_utils
from sklearn import metrics 
from keras.callbacks import ModelCheckpoint 
from datetime import datetime 

#For when separated
#path = '/home/david/Sounds/'
#X = np.genfromtxt(path + 'X.csv', delimiter=',')



 

#yy = np.genfromtxt(path + 'y.csv', delimiter=',')

# split the dataset 
x_train, x_test, y_train, y_test = train_test_split(X, yy, test_size=0.2, random_state = 42)
 

num_rows = 40
num_columns = 1300
num_channels = 1


#x_train = x_train.reshape(x_train.shape[0], num_rows, num_columns, num_channels)
#x_test = x_test.reshape(x_test.shape[0], num_rows, num_columns, num_channels)

num_labels = yy.shape[1]
filter_size = 2
"""
# Construct model 
model = Sequential()
model.add(Conv2D(filters=16, kernel_size=2, input_shape=(num_rows, num_columns, num_channels), activation='relu'))
model.add(MaxPooling2D(pool_size=2))
model.add(Dropout(0.2))

model.add(Conv2D(filters=32, kernel_size=2, activation='relu'))
model.add(MaxPooling2D(pool_size=2))
model.add(Dropout(0.2))

model.add(Conv2D(filters=64, kernel_size=2, activation='relu'))
model.add(MaxPooling2D(pool_size=2))
model.add(Dropout(0.2))

model.add(Conv2D(filters=128, kernel_size=2, activation='relu'))
model.add(MaxPooling2D(pool_size=2))
model.add(Dropout(0.2))
model.add(GlobalAveragePooling2D())

model.add(Dense(num_labels, activation='softmax'))
"""

#I = Input(shape=(None, 40)) # unknown timespan, fixed feature size
#lstm = LSTM(20)
#f = K.function(inputs=[I], outputs=[lstm(I)])

#print (f([x_train])[0].shape)
# (1, 20)
#print (f([x_test])[0].shape)
# (1, 20)

model = Sequential()
#model.add(Embedding(input_length=(40)))
model.add(LSTM(10, shape=(None, 40)))
model.add(LSTM(10))
model.add(Dense(5, activation='softmax'))



# Compile the model
#model.compile(loss='categorical_crossentropy', metrics=['accuracy'], optimizer='adam')
model.compile(optimizer='adam', loss='mse')
# Display model architecture summary 
model.summary()

for seq in x_train['Sequence']:
    print("Length of training is {0}".format(len(seq[:-1])))
    print("Training set is {0}".format(seq[:-1]))
    model.fit(np.array([seq[:-1]]), [seq[-1]])

"""
# Calculate pre-training accuracy 
try:
    score = model.evaluate(x_test, y_test, verbose=1)
    accuracy = 100*score[1]

    print("Pre-training accuracy: %.4f%%" % accuracy) 
except:
    pass

num_epochs = 72
num_batch_size = 256

start = datetime.now()

model.fit(x_train, y_train, batch_size=num_batch_size, epochs=num_epochs, validation_data=(x_test, y_test), verbose=1)


duration = datetime.now() - start
print("Training completed in time: ", duration)

try:
    # Evaluating the model on the training and testing set
    score = model.evaluate(x_train, y_train, verbose=0)
    print("Training Accuracy: ", score[1])

    score = model.evaluate(x_test, y_test, verbose=0)
    print("Testing Accuracy: ", score[1])
except:
    pass
"""
