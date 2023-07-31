<?php

include("database/connection.php");
include("database/functions.php");

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Move uploaded file to desired location
    $file = $_FILES['csv_file']['tmp_name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES['csv_file']['name']);
    move_uploaded_file($file, $target_file);

    // Open the uploaded CSV file
    if (($handle = fopen($target_file, "r")) !== FALSE) {
        // Flag variable to skip the first row
        $firstRow = true;

        // Read the CSV file row by row
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Skip the first row
            if ($firstRow) {
                $firstRow = false;
                continue;
            }

            // Prepare the INSERT statement
            $sql = "INSERT INTO prediksi (MinTemp, MaxTemp, Rainfall, Evaporation, Sunshine, WindGustDir, WindGustSpeed, WindDir9am, WindDir3pm, WindSpeed9am, WindSpeed3pm, Humidity9am, Humidity3pm, Pressure9am, Pressure3pm, Cloud9am, Cloud3pm, Temp9am, Temp3pm, RainToday, RISK_MM, RainTomorrow) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Bind the CSV data to the prepared statement parameters
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssssssssssssssss", ...$data);
            $stmt->execute();
        }

        // Close the CSV file
        fclose($handle);

        // Close the database connection
        $conn->close();

        // Redirect back to the prediksi.php after successful data insertion
        header("Location: prediksi.php");
        exit();
    } else {
        // Display error message if unable to open the CSV file
        echo "Error opening the CSV file!";
    }
}
?>
