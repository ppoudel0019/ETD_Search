
<?php

$thisID= auth()->user()->id;

 

$mysqli = new mysqli("127.0.0.1", "admin", "monarchs", "SearchEngine");

$link = mysqli_connect("127.0.0.1", "admin", "monarchs", "SearchEngine");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Attempt select query execution
$sql = "SELECT * FROM histories WHERE user_id=$thisID";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        echo "<table>";
        echo "<br";
            echo "<tr>";
                
                echo "<th>Saved Items</th>";
                
                
               
            echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                $url=$row['url'];
                $id=$row['id'];
                
                echo "<br>";
                echo "<td> <a href='$url'><br>".$row['title'] ."</a><br>".$row['description_abstract'];
                
?>
                <form method="POST" action="/remove" >
                @csrf
                <input type="hidden" name="id" value="<? echo $id?>" />  

        <x-jet-button class="ml-4">
                     {{ __('Remove') }}
                    </x-jet-button>
                    </form>






<?php



            echo "</td></tr>";
        }
        echo "</table>";
        // Close result set
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);





















/*

{{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}}




<br>
{{ auth()->user()->email}}
<br>
























?>





