<!-- @ppoudel-->
<?php

$id=Request('id');
//connec to the database
$mysqli = new mysqli("127.0.0.1", "admin", "monarchs", "SearchEngine");

$link = mysqli_connect("127.0.0.1", "admin", "monarchs", "SearchEngine");

$sql = "DELETE FROM histories WHERE id=$id";
if(mysqli_query($link, $sql)){
    echo "<script>location.href = '/myhistory';</script>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
} 
// Close connection
mysqli_close($link);
?>





    