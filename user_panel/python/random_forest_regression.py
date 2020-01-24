# Random Forest Regression

# Importing the libraries

import sys
import numpy as np
import matplotlib.pyplot as plt
import pandas as pd
import json

"""# Importing the dataset
dataset = pd.read_csv('Position_Salaries.csv')
X = dataset.iloc[:, 1:2].values
y = dataset.iloc[:, 2].values
"""

stock = sys.argv[1]

stock_name = "python/datasets/"+stock + ".csv"

dataset = pd.read_csv(stock_name)

#dataset = dataset.drop(['No.of Shares', 'No. of Trades', 'Total Turnover (Rs.)','Deliverable Quantity','% Deli. Qty to Traded Qty','Spread Close-Open','Spread High-Low'], axis=1)

dataset = dataset.iloc[::-1]

X = dataset.iloc[:, [1,2,3,4]].values
y = dataset.iloc[:,5].values
"""X = dataset.iloc[:,1:-1].values
y = dataset.iloc[:,5].values"""
date = dataset.iloc[:,0].values

"""
# Splitting the dataset into the Training set and Test set
from sklearn.model_selection import train_test_split
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size = 0.2, random_state = 0)
"""
# Feature Scaling
"""from sklearn.preprocessing import StandardScaler
sc_X = StandardScaler()
X_train = sc_X.fit_transform(X_train)
X_test = sc_X.transform(X_test)
sc_y = StandardScaler()
y_train = sc_y.fit_transform(y_train)"""

# Fitting Random Forest Regression to the dataset
from sklearn.ensemble import RandomForestRegressor
regressor = RandomForestRegressor(n_estimators = 500, random_state = 0)
regressor.fit(X, y)

# Predicting a new result
wap_pred = regressor.predict(X)

#wap_pred = y_pred[:,0] 

print(type(wap_pred[0]))

#highest_high = max(y_pred[:,1])

#print(highest_high)

data = {}  
data['coordinates'] = []
i = 0

while i < len(wap_pred):
	data['coordinates'].append({  
    'date': date[i],
    'point': wap_pred[i]
	})
	i=i+1


with open('python/data.JSON', 'w') as outfile:  
    json.dump(data, outfile)

"""
# Visualising the Random Forest Regression results (higher resolution)
X_grid = np.arange(min(X), max(X), 0.01)
X_grid = X_grid.reshape((len(X_grid), 1))
plt.scatter(X, y, color = 'red')
plt.plot(X_grid, regressor.predict(X_grid), color = 'blue')
plt.title('Truth or Bluff (Random Forest Regression)')
plt.xlabel('Position level')
plt.ylabel('Salary')
plt.show()
"""
