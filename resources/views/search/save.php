<?php



$thisID= auth()->user()->id;

$title=Request('title');
$sourceURL=Request('sourceURL');
$publisher=Request('publisher');


$mysqli = new mysqli("127.0.0.1", "admin", "monarchs", "SearchEngine");

$link = mysqli_connect("127.0.0.1", "admin", "monarchs", "SearchEngine");


$sql = "INSERT INTO histories (user_id, title, url, description_abstract ) VALUES ('$thisID','$title','$sourceURL','$publisher')";
if(mysqli_query($link, $sql)){
    echo "Saved";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
?>





    