<!-- @ppoudel-->
<?php

$url = $_SERVER['HTTP_REFERER'];

$thisID= auth()->user()->id;

$title=Request('title');
$sourceURL=Request('sourceURL');
$description=Request('description');
$publisher=Request('publisher');


$mysqli = new mysqli("127.0.0.1", "admin", "monarchs", "SearchEngine");

$link = mysqli_connect("127.0.0.1", "admin", "monarchs", "SearchEngine");


$sql = "INSERT INTO histories (user_id, title, url, description_abstract, publisher) VALUES ('$thisID','$title','$sourceURL','$description','$publisher')";
if(mysqli_query($link, $sql)){
   // echo "Saved";
   echo "<script>location.href = '/myhistory';</script>";


    
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
?>





    