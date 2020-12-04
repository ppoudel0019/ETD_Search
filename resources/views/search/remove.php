<?php


$id=Request('id');






$mysqli = new mysqli("127.0.0.1", "admin", "monarchs", "SearchEngine");

$link = mysqli_connect("127.0.0.1", "admin", "monarchs", "SearchEngine");

$sql = "DELETE FROM histories WHERE id=$id";
if(mysqli_query($link, $sql)){
    echo "Removed";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
?>





    