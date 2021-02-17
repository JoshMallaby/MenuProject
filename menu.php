<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "idea";

$conn = @mysqli_connect($host, $user, $password, $database);
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
  }
$query = "SELECT * from menu";
$result = mysqli_query($conn, $query);

if(!$result)
{
    echo"<p>Unable to execute the query.</p>" . "<p>Error code " . mysqli_errno($conn) . ": " . mysqli_error($conn) . "</p>";
}
else
{
    $arr = [];
    while ($row = mysqli_fetch_assoc($result))
    {
        array_push($arr, $row);
    }
    foreach($arr as $value){
        /*foreach($value as $item){
            echo $item;
        }*/
        echo "<br><label>$value[itemName]</label>";
        echo "<br><input type='number'>";
        echo"<br><img src='IMMC.PNG' alt='Menu Item'>";
        
        
        
    }
}

mysqli_close($conn);

?>