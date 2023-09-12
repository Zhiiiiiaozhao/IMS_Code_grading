<html>

<!-- Style of the table, CSS type -->
<head>
   <!-- Link your php/css file -->
   <link rel="stylesheet" href="style.css" media="screen">

</head>
</html>

<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "films";

// Create connection
$link = mysqli_connect($servername, $username, $password, $dbname); 

if (mysqli_connect_error()) { 
    die("Connection failed: " . mysqli_connect_error());  
}

echo '<table><tr><th>ID</th><th>name</th><th>year</th><th>genre</th><th>rating</th></tr>';

// Use an SQL JOIN to combine data from "movies" and "genres" tables
//$sql = "SELECT * FROM `movies`";
$sql = "SELECT movies.ID, movies.name, movies.year, genres.genre, movies.rating
        FROM movies
        JOIN genres ON movies.genreID = genres.genreID";
$result = $link->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr> <td>" . $row["ID"] . "</td><td>" . $row["name"] . "</td><td>" . $row["year"] . "</td><td>" . $row["genre"] ."</td><td>" . $row["rating"]. "</td></tr>";
    }
} else {
    echo "0 results";
}

echo '</table>';
?>