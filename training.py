import pandas as pd
import numpy as np
from sklearn.model_selection import train_test_split
from sklearn.linear_model import LinearRegression  # or any other model
from sklearn.metrics import r2_score
import joblib  # Import joblib for saving the model

# Load your dataset
data = pd.read_csv('sdata.csv')

# Define features and target variable
X = data[['total_activities', 'absences', 'low_scores', 'high_scores']]
y = data['risk_index']

# Clip the target variable to be within the range [0, 100]
y_clipped = np.clip(y, 0, 100)

# Split the data
X_train, X_test, y_train, y_test = train_test_split(X, y_clipped, test_size=0.2, random_state=42)

# Create and train the model
model = LinearRegression()  # Replace with your chosen model
model.fit(X_train, y_train)

# Make predictions
predictions = model.predict(X_test)

# Clip the predictions to be within the range [0, 100]
clipped_predictions = np.clip(predictions, 0, 100)

# Evaluate the model
r2 = r2_score(y_test, clipped_predictions)

print(f'R^2 Score: {r2}')
print(f'Predictions: {clipped_predictions}')

# Save the trained model
model_filename = 'student_risk_model.joblib'
joblib.dump(model, model_filename)
print(f'Model saved to {model_filename}')
