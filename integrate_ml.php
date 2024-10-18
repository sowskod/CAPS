<?php
// Execute Python script to predict risk
$student_data = array(
    'feature1' => $value1,
    'feature2' => $value2,
    'feature3' => $value3,
    // Add more features as necessary
);

// Convert the data into a JSON string
$data_string = json_encode($student_data);

// Execute Python script for prediction
$command = escapeshellcmd('python3 predict.py ' . $data_string);
$output = shell_exec($command);

// Show the prediction result
echo "Prediction: " . $output;
?>
