<?php

// Get JSON data from the AJAX request
$jsonData = $_POST['jsonData'];

// Path to your JSON file
$jsonFilePath = 'data.json';

// Output received JSON data for debugging
//file_put_contents('received_data_debug.txt', $jsonData);

// Check if the received JSON data is valid
if ($jsonData && json_decode($jsonData) !== null) {
    // Read the existing JSON data from the file
    $existingData = file_get_contents($jsonFilePath);

    // Decode the existing JSON data into a PHP array
    $existingArray = json_decode($existingData, true);

    // Decode the new JSON data into a PHP array
    $newArray = json_decode($jsonData, true);

    // Log information for debugging
    file_put_contents('debug_info.txt', print_r($newArray, true));

    // Ensure the "id" field exists in the new data
    if (isset($newArray['myObject']['id'])) {
        // Use the unique identifier as the key for the new record
        $existingArray[$newArray['myObject']['id']] = $newArray['myObject'];

        // Encode the updated data back to JSON
        $updatedJsonData = json_encode($existingArray, JSON_PRETTY_PRINT);

        // Write the updated JSON data back to the file
        file_put_contents($jsonFilePath, $updatedJsonData);

        echo "JSON file updated successfully with a new record";
    } else {
        echo "Missing 'id' field in the received data";
    }
} else {
    echo "Invalid JSON data received";
}


