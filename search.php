<html>

<!-- Style of the table, CSS type -->
<head>
   <!-- Link your php/css file -->
   <link rel="stylesheet" type="text/css" href="style.css">

</head>

<!-- Form search -->
<body>  

<form action="search.php" method="POST">
<p style="color:#00008B; font-size:30px;">Search Movie:</p> <input type="text" name="search_query">
    <input type="submit" value="Search">
</form>

</body>
</html>  


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

// Check if the search_query key exists in the $_POST array
if (isset($_POST['search_query'])) {
    $searchQuery = $_POST['search_query'];

    // SQL query to search for movies based on the mname field
    $sql = "SELECT m.*, g.genre AS genre
            FROM movies m
            LEFT JOIN genres g ON m.genreID = g.genreID
            WHERE m.name LIKE '%$searchQuery%'";
} else {
    // If no search query provided, retrieve all movies
    $sql = "SELECT m.*, g.genre AS genre
            FROM movies m
            LEFT JOIN genres g ON m.genreID = g.genreID";
}

$result = $link->query($sql);
if ($result->num_rows > 0) {
    echo '<table><tr><th>ID</th><th>Movie Name</th><th>Movie Year</th><th>Movie Genre</th><th>Movie Rating</th></tr>';
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["name"] . "</td><td>" . $row["year"] . "</td><td>" . $row["genre"] . "</td><td>" . $row["rating"] . "</td></tr>";
    }
    echo '</table>';
} else {
    echo "No results found.";
}

// Close the database connection
$link->close();
?>



