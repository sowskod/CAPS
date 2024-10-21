import pandas as pd

# Load the dataset
file_path = 'sdata.csv'  # Update the file path as necessary
data = pd.read_csv(file_path)

# Define a function to calculate the risk index based on the rule-based approach
def calculate_risk_index(row):
    # Risk from absences
    if row['absences'] >= 5:
        absence_risk = 3
    elif 2 <= row['absences'] <= 4:
        absence_risk = 2
    else:
        absence_risk = 1

    # Risk from low_scores
    if row['low_scores'] >= 4:
        low_score_risk = 3
    elif 2 <= row['low_scores'] <= 3:
        low_score_risk = 2
    else:
        low_score_risk = 1

    # Risk from high_scores (inverse relationship)
    if row['high_scores'] <= 2:
        high_score_risk = 3
    elif 3 <= row['high_scores'] <= 5:
        high_score_risk = 2
    else:
        high_score_risk = 1

    # Risk from total_activities
    if row['total_activities'] <= 5:
        activity_risk = 3
    else:
        activity_risk = 1

    # Sum all risks to get the final risk_index
    return absence_risk + low_score_risk + high_score_risk + activity_risk

# Function to calculate the risk percentage based on the risk index
def calculate_risk_percentage(risk_index):
    # Map the risk index (4 to 12) to a percentage (0% to 100%)
    return ((risk_index - 4) / (12 - 4)) * 100

# Apply the rule-based risk index calculation
data['risk_index'] = data.apply(calculate_risk_index, axis=1)

# Convert the risk index to percentage
data['risk_percentage'] = data['risk_index'].apply(calculate_risk_percentage)

# Save the updated data to a new file
data.to_csv('sdata_with_risk_percentage.csv', index=False)

print("Risk percentage calculation completed and saved to 'sdata_with_risk_percentage.csv'.")
