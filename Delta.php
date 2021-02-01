<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Zacks Delta</title>
  <head>
 <body>

<?php 

$ini_array = parse_ini_file("config.ini");
$host = $ini_array['host']; 
$user = $ini_array['user']; 
$pass = $ini_array['pass']; 
$db = $ini_array['db']; 

// Create connection
$conn = new mysqli($host, $user, $pass, $db);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM delta"; // where CURRENT_DATE = end_date";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<table class=\"table table-dark\"><thead><tr><th scope=\"col\">Previous Run</th><th scope=\"col\">Current Run</th><th style=\"color:green\" scope=\"col\">++Added</th><th style=\"color:red\" scope=\"col\">--Removed</th></tr><thead><tbody>";
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $newAdded = "";
    $added = $row["added"];
    $addedArray = explode(', ', $added);
    foreach ($addedArray as $value) {
        $newAdded .= "<a href=\"https://www.zacks.com/stock/quote/" . $value . "?q=" . $value . "\">" . $value . "</a>";
        if( $value !== end( $addedArray ) ) 
        {
            $newAdded .= ", ";
        } 
    }
    
    $newRemoved = "";
    $removed = $row["removed"];
    $removedArray = explode(', ', $removed);
    foreach ($removedArray as $value) {
        $newRemoved .= "<a href=\"https://www.zacks.com/stock/quote/" . $value . "?q=" . $value . "\">" . $value . "</a>";
        if( $value !== end( $removedArray ) ) 
        {
            $newRemoved .= ", ";
        }
    }
    
    echo "<tr><th scope=\"row\">".$row["start_date"]."</th><td>".$row["end_date"]."</td><td>". rtrim($newAdded, ',') ."</td><td>". rtrim($newRemoved, ',') ."</td></tr>";
  }
  echo "</tbody></table>";
} else {
  echo "0 results";
}
$conn->close();
   
?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 </body>
</html>
