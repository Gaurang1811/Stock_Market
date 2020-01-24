# Artificial Neural Network

# Installing Theano
# pip install --upgrade --no-deps git+git://github.com/Theano/Theano.git

# Installing Tensorflow
# Install Tensorflow from the website: https://www.tensorflow.org/versions/r0.12/get_started/os_setup.html

# Installing Keras
# pip install --upgrade keras

# Part 1 - Data Preprocessing

# Importing the libraries
import sys
import json
import numpy as np
import matplotlib.pyplot as plt
import pandas as pd

# Importing the dataset

stock = sys.argv[1]
stock_name = "datasets/"+stock + ".csv"
dataset = pd.read_csv(stock_name)
epoch = 30

#dataset = pd.read_csv('500325.csv')
X = dataset.iloc[:, [1,2,3,4]].values
y = dataset.iloc[:,5].values

date = dataset.iloc[:,0].values

# Encoding categorical data
"""from sklearn.preprocessing import LabelEncoder, OneHotEncoder
labelencoder_X_1 = LabelEncoder()
X[:, 1] = labelencoder_X_1.fit_transform(X[:, 1])
labelencoder_X_2 = LabelEncoder()
X[:, 2] = labelencoder_X_2.fit_transform(X[:, 2])
onehotencoder = OneHotEncoder(categorical_features = [1])
X = onehotencoder.fit_transform(X).toarray()
X = X[:, 1:]"""

# Splitting the dataset into the Training set and Test set
from sklearn.model_selection import train_test_split
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size = 0.15, random_state = 0)

# Feature Scaling
from sklearn.preprocessing import StandardScaler
sc = StandardScaler()
X_train = sc.fit_transform(X_train)
X_test = sc.transform(X_test)

# Part 2 - Now let's make the ANN!

# Importing the Keras libraries and packages
import keras
from keras.models import Sequential
from keras.layers import Dense

# Initialising the ANN
model = Sequential()

# Adding the input layer and the first hidden layer
model.add(Dense(32, activation = 'relu', input_dim = 4))

# Adding the second hidden layer
model.add(Dense(units = 32, activation = 'relu'))

# Adding the third hidden layer
model.add(Dense(units = 32, activation = 'relu'))

# Adding the output layer
model.add(Dense(units = 1))

# Compiling the ANN
model.compile(optimizer = 'adam',loss = 'mean_squared_error')

# Fitting ANN to the training set
model.fit(X_train, y_train, batch_size = 6, epochs = epoch)

# Part 3 - Making the predictions and evaluating the model

# Predicting the Test set results
y_pred = model.predict(X_test)


#------------------------WRITING Y_PRED TO JSON FILE----------------------------



y_pred = y_pred[:,0] #'ndarray' is not JSON serializable
y_pred = y_pred.astype(float) #converting y_pred from float32 to float64 (float32 is not JSON serializable)
#writing y_pred and y_test to JSON file
data = {}
data['coordinates'] = []
i = 0
while i < len(y_pred):
	data['coordinates'].append({
    'date': date[i],
    'y_test': y_test[i],
    'y_pred': y_pred[i]

	})
	i=i+1

with open('json/ann_data.JSON', 'w') as outfile:
    json.dump(data, outfile)

"""
#---------------PLOTTING ACTUAL AND PREDICTED VALUE----------------------------

plt.plot(y_test, color = 'red', label = 'Real data')
plt.plot(y_pred, color = 'blue', label = 'Predicted data')
plt.title('Prediction')
plt.legend()
plt.show()
"""
