# load the model from disk
import sys
import json
import numpy as np
import matplotlib.pyplot as plt
import pandas as pd
import csv
import datetime
from sklearn.externals import joblib
import keras
from keras.models import Sequential
from keras.layers import Dense

stock = sys.argv[1]
stock_name = "datasets/"+stock + ".csv"
dataset = pd.read_csv(stock_name)

count = 0
while (count < 10):
    count = count + 1
    model = joblib.load('joblibs/model_a.sav')
    X_test = dataset.iloc[-1:,4].values
    y_pred_open = model.predict(X_test)

    model = joblib.load('joblibs/model_b.sav')
    y_pred_high = model.predict(y_pred_open)

    model1 = joblib.load('joblibs/model1.sav')
    data = {'y_pred_open':[y_pred_open],
    'y_pred_high':[y_pred_high]}
    df = pd.DataFrame(data)
    X_test1 = df.iloc[:,:].values
    y_pred_low = model1.predict(X_test1)

    model2 = joblib.load('joblibs/model2.sav')
    data1 = {'y_pred_open':[y_pred_open],
    'y_pred_high':[y_pred_high],
    'y_pred_low':[y_pred_low]}
    df1 = pd.DataFrame(data1)
    y_pred_close = model2.predict(df1.iloc[:,:].values)

    model3 = joblib.load('joblibs/model3.sav')
    data2 = {'y_pred_open':[y_pred_open],
    'y_pred_high':[y_pred_high],
    'y_pred_low':[y_pred_low],
    'y_pred_close':[y_pred_close]}
    df2 = pd.DataFrame(data2)
    y_pred_wap = model3.predict(df2.iloc[:,:].values)

#------------------------INCREMENTING THE DATE----------------------------------

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
    predicted_dataset = pd.concat([df3, predicted_dataset]).reset_index(drop = True)
    predicted_dataset.to_csv('datasets/500325_predicted.csv', index=False)
    dataset = pd.concat([df3, dataset]).reset_index(drop = True)
    dataset.to_csv('datasets/500325.csv', index=False)
