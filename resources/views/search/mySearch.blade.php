

{{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}}


{{ auth()->user()->email}}



<?php

$q=Request('q');

echo "<br>";


if (Auth::check()) {
    echo "trial page for search history";//


    
}


      /*
/DB::table('messages')->insert(
                ['message' => $msg]
            );
            

            @foreach ($users as $user)

        {{ $user->name }} 
        <br>
@endforeach




      
    
?>


