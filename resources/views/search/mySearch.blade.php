
<div style="margin-left:10%;margin-top:1%;">
@if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('user/profile') }}" class="text-sm text-gray-700 underline">Profile</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endif
                </div>
        

            @endif
            <a href="index.php">SEARCH</a>


            </div>






<?php

$thisID= auth()->user()->id;

 

$mysqli = new mysqli("127.0.0.1", "admin", "monarchs", "SearchEngine");

$link = mysqli_connect("127.0.0.1", "admin", "monarchs", "SearchEngine");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

function limit($string, $limit) {
    if (strlen($string) < $limit) {
        $result = substr($string, 0, $limit);
    }
    else
        $result =  substr($string, 0, $limit) . '...';
    return $result;
}




 
// Attempt select query execution
$sql = "SELECT * FROM histories WHERE user_id=$thisID";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        echo'<div style="margin-left:10%;margin-right:10%;">';
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
                echo "<td> <a href='$url'><br>".$row['title'] ."</a><br>".$row['publisher']."<br>".limit($row['description_abstract'],500);
                
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
        echo "<br>";
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









?>






































