<!DOCTYPE html>
<html>

<head>
    <title>Add Event</title>
    <link href="./css/index.css" rel="stylesheet" />

</head>

<body>

    <nav class="navbar">
        <div class="navbar-logo">
            <img src="./images/logo.png" alt="EducationM4">
            <p class=" nav-p">University of Plovdiv EVENTS</p>
        </div>
        <ul class="navbar-menu">
            <li><a href="#">Home</a></li>
            <li><a href="#">Organize Event</a></li>
            <li><a href="#">University</a></li>
            <li><a href="#" class="cta">Events</a></li>
        </ul>
    </nav>

    <div class="header-container">
        <div class="header-wrapper">
            <div class="text-wrapper">
                <h1 class="header-title">Oportunities in University of Plovdiv</h1>
                <p class="header-subtitle">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin tristique,
                    sem nec consectetur finibus, diam arcu laoreet massa, ac molestie justo orci vel lorem.
                </p>
                <button class="header-button" onclick="">Get Started</button>
            </div>
            <div class="image-wrapper">
                <img src="https://mobirise.com/extensions/teamm4/recruiting-agency/assets/images/features1.jpg" alt="">
            </div>
        </div>
    </div>

    <?php
    if (isset($_GET['status'])) {
        header("Refresh:2; url=home.php");

        if ($_GET['status'] == 'success') {
            echo "<p class='success-message'>Event added successfully!</p>";
        } elseif ($_GET['status'] == 'error') {
            echo "<p class='error-message'>Error adding event.</p>";
        }
    }
    ?>

    <div class="container">
        <div class="text">
            Add Event
        </div>
        <form action="add_event.php" method="post">
            <div class="form-row">
                <div class="input-data">
                    <input type="text" id="name" name="name" required>
                    <br>
                    <div class="underline"></div>
                    <label for="name">Event Name:</label><br>
                </div>
                <div class="input-data textarea">
                    <textarea type="textarea" id="description" name="description" required></textarea>
                    <div class="underline"></div>
                    <label for="description">Description:</label><br>
                </div>
            </div>
            <div class="form-row">
                <div class="input-data ">
                    <input type="date" id="date" name="date" required>
                    <br><br>
                    <div class="underline"></div>
                    <label for="date" id="date-for">Date:</label><br>
                </div>
            </div>
            <div class="form-row submit-btn">
                <div class="input-data">
                    <div class="inner"></div>
                    <input type="submit" name="submit" value="submit">
                </div>
            </div>
        </form>
    </div>
    <h2>EVENT LIST</h2>
    <?php
    require 'db_connect.php';
    // Attempt to select and display all events
    $sql = "SELECT * FROM events";
    if ($result = $mysqli->query($sql)) {
        if ($result->num_rows > 0) {
            echo "<div class='events-container'>"; // Container for all events, styled as cards
            while ($row = $result->fetch_assoc()) {
                echo "<div class='event-card'>";
                echo "<div class='event-header'>" . htmlspecialchars($row['name']) . "</div>";
                echo "<div class='event-image'>";
                echo "<img src='https://picsum.photos/300/300?random=" . $row['id'] . "' alt='Event Image' />";
                echo "</div>";
                echo "<div class='event-body'>";
                echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                echo "<p>Date: " . $row['date'] . "</p>";
                echo "</div>"; // Close event-body
                echo "<div class='event-footer'>";
                echo "<a href='delete_event.php?id=" . $row['id'] . "' class='btn delete-btn'>Delete</a>";
                echo "<a href='update_event.php?id=" . $row['id'] . "' class='btn update-btn'>Update</a>";
                echo "</div>"; // Close event-footer
                echo "</div>"; // Close event-card
            }
            echo "</div>"; // Close events-container
            $result->free();
        } else {
            echo "<p>No events found.</p>";
        }
    } else {
        echo "ERROR: Could not execute $sql. " . $mysqli->error;
    }
    $mysqli->close();
    ?>

    <footer>
        <div class="footer-content">
            <h2>STAY UP TO DATE</h2>
            <p>Sign up to get our newsletter for all the latest news, shows, and events</p>
            <form action="#" method="post">
                <input type="email" name="email" placeholder="Enter your email here">
                <button type="submit">Subscribe</button>
            </form>
        </div>
        <div class="footer-bottom">
            <p>© 2024 by me. Powered and secured by Todor Velichkov.</p>
        </div>
    </footer>
</body>

</html>