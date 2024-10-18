import pickle
import pandas as pd

# Load the saved model
with open('decision_tree_model.pkl', 'rb') as f:
    model = pickle.load(f)

# Example new data (replace with actual input)
new_data = pd.DataFrame({
    'feature1': [value1],
    'feature2': [value2],
    'feature3': [value3],
    # Add more features as required
})

# Make predictions
predictions = model.predict(new_data)

print("Predicted class:", predictions[0])
