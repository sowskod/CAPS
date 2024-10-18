import sys
import joblib
import numpy as np

def main():
    # Load the trained model
    model_filename = 'C:\\xampp\\htdocs\\idrop\\student_risk_model.joblib'
    model = joblib.load(model_filename)

    # Check if the correct number of arguments is provided
    if len(sys.argv) != 5:
        print("Usage: python predict_risk.py <total_activities> <low_scores> <absences> <high_scores>")
        sys.exit(1)

    # Parse input arguments
    total_activities = float(sys.argv[1])
    low_scores = float(sys.argv[2])
    absences = float(sys.argv[3])
    high_scores = float(sys.argv[4])

    # Prepare the input data for prediction
    input_data = np.array([[total_activities, absences, low_scores, high_scores]])

    # Make a prediction
    prediction = model.predict(input_data)

    # Clip the prediction to ensure it's within the range [0, 100]
    risk_index = np.clip(prediction[0], 0, 100)

    # Print the risk index
    print(risk_index)

if __name__ == "__main__":
    main()
