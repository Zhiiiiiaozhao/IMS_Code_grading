<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "films";

// Create connection
$link = mysqli_connect($servername, $username, $password, $dbname);

// Check if connection is established
if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data from POST request
$name = $_POST['name'];
$year = $_POST['year'];
$genre = $_POST['genre'];
$rating = $_POST['rating'];

// Initialize genreID
$genreID = null;

// Retrieve genreID (gid) based on the selected genre name from genres table
$sqlGenreID = "SELECT genreID FROM genres WHERE genre = ?";
$stmtGenreID = $link->prepare($sqlGenreID);
$stmtGenreID->bind_param("s", $genre);

if ($stmtGenreID->execute()) {
    $stmtGenreID->bind_result($genreID);
    $stmtGenreID->fetch();
    $stmtGenreID->close(); // Close the statement after fetching

    // Insert into movies table with the retrieved genreID
    $sqlInsertMovie = "INSERT INTO movies (name, year, genreID, rating) VALUES (?, ?, ?, ?)";
    $stmtInsertMovie = $link->prepare($sqlInsertMovie);

    if ($stmtInsertMovie) {
        $stmtInsertMovie->bind_param("ssii", $name, $year, $genreID, $rating);

        if ($stmtInsertMovie->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmtInsertMovie->error;
        }
        
        $stmtInsertMovie->close(); // Close the insert statement
    } else {
        echo "Error: " . $link->error;
    }
} else {
    echo "Error: " . $stmtGenreID->error;
}

// Close the database connection
$link->close();
?>
