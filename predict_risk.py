import sys
import pandas as pd
import pickle

# Load the model from the file
with open('risk_model.pkl', 'rb') as file:
    model = pickle.load(file)

# Get inputs from command line arguments
total_activities = int(sys.argv[1])
absences = int(sys.argv[2])
low_scores = int(sys.argv[3])

# Create a dataframe with the input values
input_data = pd.DataFrame([[total_activities, absences, low_scores]], columns=['total_activities', 'absences', 'low_scores'])

# Make a prediction
risk_index = model.predict(input_data)[0]

# Print the result (this will be captured by PHP)
print(risk_index)
