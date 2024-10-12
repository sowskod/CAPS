# Python script to train the model (train_model.py)
import pandas as pd
from sklearn.linear_model import LogisticRegression
from sklearn.model_selection import train_test_split
from sklearn.externals import joblib

# Example DataFrame: columns=['total_activities', 'absences', 'low_scores', 'high_scores', 'at_risk']
data = pd.read_csv('student_data.csv')

X = data[['total_activities', 'absences', 'low_scores', 'high_scores']]
y = data['at_risk']  # Binary classification: 1 = "at risk", 0 = "not at risk"

X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2)

model = LogisticRegression()
model.fit(X_train, y_train)

# Save the trained model to a file
joblib.dump(model, 'risk_model.pkl')
