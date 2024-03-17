<?php
// process_event.php

if (isset($_POST['submit'])) {
    // Connect to the database
  require 'db_connect.php';

    // Prepare an insert statement
    $sql = "INSERT INTO events (name, description, date) VALUES (?, ?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sss", $_POST['name'], $_POST['description'], $_POST['date']);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to 'create.php' with a success message
            header("Location: home.php?status=success");
            exit();
        } else {
            // Redirect to 'home.php' with an error message
            header("Location: home.php?status=error");
            exit();
        }

        $stmt->close();
    } else {
        // Redirect to 'home.php' with an error message
        header("Location: home.php?status=error");
        exit();
    }

    $mysqli->close();
} else {
    // Redirect to 'home.php' if this script is accessed without posting form data
    header("Location: home.php");
    exit();
}
?>
