<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'db_connect.php'; // Ensure this points to your database connection script

// Determine if an ID has been provided
$id = $_GET['id'] ?? $_POST['id'] ?? null;

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'], $id)) {
    $sql = "UPDATE events SET name = ?, description = ?, date = ? WHERE id = ?";
    
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("sssi", $_POST['name'], $_POST['description'], $_POST['date'], $id);

        if ($stmt->execute()) {
            // Close the statement and connection before redirecting
            $stmt->close();
            $mysqli->close();
            // Redirect to home.php with a query parameter indicating success
            header("Location: home.php?update=success");
            exit();
        } else {
            // It's also possible to redirect with an error message, but you must ensure the stmt and mysqli are closed
            $stmt->close();
            $mysqli->close();
            header("Location: home.php?update=error");
            exit();
        }
    } else {
        // Error preparing statement, redirect with error. Ensure mysqli is closed.
        $mysqli->close();
        header("Location: home.php?update=error");
        exit();
    }
}

// If the page is accessed with a GET request to edit an event, fetch the event's data if an ID is provided
if ($id && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $sql = "SELECT * FROM events WHERE id = ?";
    
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $event = $result->fetch_assoc();
        $stmt->close();
        
        if (!$event) {
            // If no event is found, redirect to home with an error message
            $mysqli->close();
            header("Location: home.php?find=error");
            exit();
        }
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Event</title>
</head>
<body>
    <?php if (isset($event)): ?>
    <h1>Update Event</h1>
    <form action="update_event.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($event['id']); ?>">
        <label for="name">Event Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($event['name']); ?>"><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description"><?php echo htmlspecialchars($event['description']); ?></textarea><br>
        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($event['date']); ?>"><br><br>
        <input type="submit" name="update" value="Update Event">
    </form>
    <?php else: ?>
    <p>Please specify an event to update.</p>
    <?php endif; ?>
</body>
</html>
