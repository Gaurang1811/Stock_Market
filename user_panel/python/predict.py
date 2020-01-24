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
import csv
import datetime
from sklearn.externals import joblib


# Importing the dataset

stock = sys.argv[1]
stock_name = "datasets/"+stock + ".csv"
dataset = pd.read_csv(stock_name)
epoch = 30
i=0
while(i<1):
    i=i+1
    dataset = dataset.iloc[:,[0,1,2,3,4,5]]
    
    dataset = dataset.iloc[::-1]

    y_wap = dataset.iloc[:,5]


    #dataset = pd.read_csv('500325.csv')
    X_close = dataset.iloc[:-1,4].values
    y_open = dataset.iloc[1:,1].values

    X_test = dataset.iloc[-1:,4].values

    X_close = X_close.reshape(-1,1)
    X_test = X_test.reshape(-1,1)

    #y_open = y_open.reshape(-1,1)
    date_array = dataset.iloc[:,0].values

    # Encoding categorical data
    """from sklearn.preprocessing import LabelEncoder, OneHotEncoder
    labelencoder_X_1 = LabelEncoder()
    X[:, 1] = labelencoder_X_1.fit_transform(X[:, 1])
    labelencoder_X_2 = LabelEncoder()
    X[:, 2] = labelencoder_X_2.fit_transform(X[:, 2])
    onehotencoder = OneHotEncoder(categorical_features = [1])
    X = onehotencoder.fit_transform(X).toarray()
    X = X[:, 1:]"""
    """
    # Splitting the dataset into the Training set and Test set
    from sklearn.model_selection import train_test_split
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size = 0.2, random_state = 0)
    """
    """
    # Feature Scaling
    from sklearn.preprocessing import StandardScaler
    sc = StandardScaler()
    X_train = sc.fit_transform(X_train)
    X_test = sc.transform(X_test)

    from sklearn.ensemble import RandomForestRegressor
    regressor = RandomForestRegressor(n_estimators = 1000, random_state = 0)
    regressor.fit(X_close, y_open)

    y_pred = regressor.predict(X_test)
    """

    import keras
    from keras.models import Sequential
    from keras.layers import Dense

    # Initialising the ANN
    model = Sequential()

    # Adding the input layer and the first hidden layer
    model.add(Dense(32, activation = 'relu', input_dim = 1))

    # Adding the second hidden layer
    model.add(Dense(units = 32, activation = 'relu'))

    # Adding the third hidden layer
    model.add(Dense(units = 32, activation = 'relu'))

    # Adding the output layer
    model.add(Dense(units = 1))

    # Compiling the ANN
    model.compile(optimizer = 'adam',loss = 'mean_squared_error')

    # Fitting ANN to the training set
    model.fit(X_close, y_open, batch_size = 10, epochs = epoch)

    # save the model to disk
    filename = 'joblibs/model_a.sav'
    joblib.dump(model, filename)

    # Part 3 - Making the predictions and evaluating the model

    # Predicting the Test set results
    y_pred_open = model.predict(X_test)
    #print(y_pred_open)

    # Predicting High
    X_open = dataset.iloc[:,1].values
    y_high = dataset.iloc[:,2].values

    X_open = X_open.reshape(-1,1)

    model.fit(X_open, y_high, batch_size = 10, epochs = epoch)

    # save the model to disk
    filename = 'joblibs/model_b.sav'
    joblib.dump(model, filename)

    y_pred_high = model.predict(y_pred_open)
    #print(y_pred_high)

    #pred low
    X_open_high = dataset.iloc[:,[1,2]].values
    y_low = dataset.iloc[:,3].values

    #X_open_high = X_open_high.reshape(-1,1)

    data = {'y_pred_open':[y_pred_open],
    'y_pred_high':[y_pred_high]}

    # Create DataFrame
    df = pd.DataFrame(data)

    # Initialising the ANN
    model1 = Sequential()

    # Adding the input layer and the first hidden layer
    model1.add(Dense(32, activation = 'relu', input_dim = 2))

    # Adding the second hidden layer
    model1.add(Dense(units = 32, activation = 'relu'))

    # Adding the third hidden layer
    model1.add(Dense(units = 32, activation = 'relu'))

    # Adding the output layer
    model1.add(Dense(units = 1))

    # Compiling the ANN
    model1.compile(optimizer = 'adam',loss = 'mean_squared_error')

    # Fitting ANN to the training set
    model1.fit(X_open_high, y_low, batch_size = 10, epochs = epoch)

    # save the model to disk
    filename = 'joblibs/model1.sav'
    joblib.dump(model1, filename)



    X_test1 = df.iloc[:,:].values


    # Part 3 - Making the predictions and evaluating the model

    # Predicting the Test set results
    y_pred_low = model1.predict(X_test1)
    #print(y_pred_low)


    # Predict Close
    X_open_high_low = dataset.iloc[:,[1,2,3]].values
    y_close = dataset.iloc[:,4].values

    #X_open_high = X_open_high.reshape(-1,1)

    data1 = {'y_pred_open':[y_pred_open],
    'y_pred_high':[y_pred_high],
    'y_pred_low':[y_pred_low]}

    # Create DataFrame
    df1 = pd.DataFrame(data1)

    # Initialising the ANN
    model2 = Sequential()

    # Adding the input layer and the first hidden layer
    model2.add(Dense(32, activation = 'relu', input_dim = 3))

    # Adding the second hidden layer
    model2.add(Dense(units = 32, activation = 'relu'))

    # Adding the third hidden layer
    model2.add(Dense(units = 32, activation = 'relu'))

    # Adding the output layer
    model2.add(Dense(units = 1))

    # Compiling the ANN
    model2.compile(optimizer = 'adam',loss = 'mean_squared_error')

    # Fitting ANN to the training set
    model2.fit(X_open_high_low, y_close, batch_size = 10, epochs = epoch)

    # save the model to disk
    filename = 'joblibs/model2.sav'
    joblib.dump(model2, filename)


    # Part 3 - Making the predictions and evaluating the model

    # Predicting the Test set results
    y_pred_close = model2.predict(df1.iloc[:,:].values)
    #print(y_pred_close)


    # Pred WAP
    X_open_high_low_close = dataset.iloc[:,[1,2,3,4]].values
    y_wap = dataset.iloc[:,5].values

    #X_open_high = X_open_high.reshape(-1,1)

    data2 = {'y_pred_open':[y_pred_open],
    'y_pred_high':[y_pred_high],
    'y_pred_low':[y_pred_low],
    'y_pred_close':[y_pred_close]}

    # Create DataFrame
    df2 = pd.DataFrame(data2)

    # Initialising the ANN
    model3 = Sequential()

    # Adding the input layer and the first hidden layer
    model3.add(Dense(32, activation = 'relu', input_dim = 4))

    # Adding the second hidden layer
    model3.add(Dense(units = 32, activation = 'relu'))

    # Adding the third hidden layer
    model3.add(Dense(units = 32, activation = 'relu'))

    # Adding the output layer
    model3.add(Dense(units = 1))

    # Compiling the ANN
    model3.compile(optimizer = 'adam',loss = 'mean_squared_error')

    # Fitting ANN to the training set
    model3.fit(X_open_high_low_close, y_wap, batch_size = 10, epochs = epoch)

    # save the model to disk
    filename = 'joblibs/model3.sav'
    joblib.dump(model3, filename)


    # Part 3 - Making the predictions and evaluating the model

    # Predicting the Test set results
    y_pred_wap = model3.predict(df2.iloc[:,:].values)
    #print(y_pred_wap[0,0])


    #------------------------INCREMENTING THE DATE----------------------------------

    dataset = dataset.iloc[::-1]

    dataset = dataset.iloc[:,[0,1,2,3,4,5]]

    date_array = dataset.iloc[:,0].values

    date = datetime.datetime.strptime(date_array[0],'%d-%B-%Y').date()

    date_day = int(date.day)
    date_month = int(date.month)
    date_year = int(date.year)

    future_date = datetime.date(date.year,date.month,date.day) + datetime.timedelta(days=1)

    future_date_in_string = future_date.strftime('%d-%B-%Y')

    if future_date.strftime('%A') == 'Saturday':
        future_date = datetime.date(date.year,date.month,date.day) + datetime.timedelta(days=3)
    elif future_date.strftime('%A') == 'Sunday':
        future_date = datetime.date(date.year,date.month,date.day) + datetime.timedelta(days=3)

    future_date_in_string = future_date.strftime('%d-%B-%Y')

    #-------------------ADD THE NEW ROW TO THE CSV FILE-----------------------------

    predicted_dataset = pd.read_csv("datasets/" + stock + "_predicted.csv")
    data3 = {'Date':future_date_in_string,
    'Open Price':[y_pred_open[0,0]],
    'High Price':[y_pred_high[0,0]],
    'Low Price':[y_pred_low[0,0]],
    'Close Price':[y_pred_close[0,0]],
    'WAP':[y_pred_wap[0,0]]}
    df3 = pd.DataFrame(data3 , index = [0])
    predicted_dataset.to_csv('datasets/' + stock + '_predicted.csv', index=False)
    dataset.to_csv('datasets/' + stock + '.csv', index=False)




#writing y_pred and y_test to JSON file
data = {}
data['coordinates'] = []
dataset = pd.read_csv(stock_name)
y_wap = dataset.iloc[:,5]
date_array_json = dataset.iloc[:,0]
i = 0
while i < len(y_wap):
	data['coordinates'].append({
    'date': date_array_json[i],
    'y_wap': y_wap[i],
    'y_test':y_test[i]
	})
	i=i+1
with open('json/ann_data.JSON', 'w') as outfile:
    json.dump(data, outfile)
    """
    # Plotting predicted and actual value
    plt.plot(y_test, color = 'red', label = 'Real data')
    plt.plot(y_pred, color = 'blue', label = 'Predicted data')
    plt.title('Prediction')
    plt.legend()
    plt.show()
    """
