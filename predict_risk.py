import sys
import json
import joblib

# Load the model
model = joblib.load('risk_model.pkl')

# Get student data from PHP
student_data = json.loads(sys.argv[1])

# Extract features
X = [[
    student_data['total_activities'],
    student_data['absences'],
    student_data['low_scores'],
    student_data['high_scores']
]]

# Predict the risk index
risk_prob = model.predict_proba(X)[0][1]  # Get probability of being "at risk"

print(risk_prob)
