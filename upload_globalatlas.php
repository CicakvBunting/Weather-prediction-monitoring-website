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

            // Extract the data from the respective columns of the CSV row
            $datetime = $data[0];
            $solarirradiance = $data[1];
            $relativetemperature = $data[2];
            $relativehumidity = $data[3];
            $windspeed = $data[4];
            $surfacetemperaturearray = $data[5];
            $surfacetemperatureweather = $data[6];

            // Prepare the INSERT statement
            $sql = "CREATE TABLE IF NOT EXISTS data_global_atlas (
                datetime DATETIME,
                solarirradiance FLOAT,
                relativetemperature FLOAT,
                relativehumidity FLOAT,
                windspeed FLOAT,
                surfacetemperaturearray FLOAT,
                surfacetemperatureweather FLOAT
            )";
            mysqli_query($conn, $sql);

            // Prepare the INSERT statement
            $sql = "INSERT INTO data_baru (datetime, solarirradiance, relativetemperature, relativehumidity, windspeed, surfacetemperaturearray, surfacetemperatureweather) VALUES (?, ?, ?, ?, ?, ?, ?)";

            // Bind the data to the prepared statement parameters
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $datetime, $solarirradiance, $relativetemperature, $relativehumidity, $windspeed, $surfacetemperaturearray, $surfacetemperatureweather);
            $stmt->execute();
        }

        // Close the CSV file
        fclose($handle);

        // Close the database connection
        $conn->close();

        // Redirect back to the prediksi.php after successful data insertion
        header("Location: index.php");
        exit();
    } else {
        // Display error message if unable to open the CSV file
        echo "Error opening the CSV file!";
    }
}
?>
