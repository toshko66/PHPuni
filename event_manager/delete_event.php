<?php
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $event_id = $_GET['id'];

    require 'db_connect.php';

    // Prepare a delete statement
    $sql = "DELETE FROM events WHERE id = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $event_id);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            header("Location: home.php?status=deletesuccess");
        } else {
            header("Location: home.php?status=deleteerror");
        }

        $stmt->close();
    } else {
        header("Location: home.php?status=deleteerror");
    }

    $mysqli->close();
} else {
    // Redirect if the id parameter is not set or is not valid
    header("Location: home.php");
}
exit();
?>
