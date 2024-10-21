# risk_regression.py
import numpy as np
import pandas as pd
from sklearn.linear_model import LinearRegression
import json

# Load the student data from the JSON file
with open('student_data.json') as f:
    data = json.load(f)

# Convert data to a DataFrame
df = pd.DataFrame(data)

# Features: absences, low_scores
X = df[['absences', 'low_scores']]

# Target variable: risk index (just an example; adjust based on your risk calculation)
# Here, we assume a linear relation between absences, low_scores, and risk index
# You can modify this as per your requirement
y = np.random.rand(len(df))  # Dummy risk values, replace with actual target variable

# Create and train the regression model
model = LinearRegression()
model.fit(X, y)

# Predict risk index for students
predicted_risk = model.predict(X)

# Save the predicted risk values back to JSON
df['predicted_risk'] = predicted_risk
df.to_json('predicted_risk.json', orient='records')
