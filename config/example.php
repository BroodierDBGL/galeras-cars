<?php
    //Tjs is a line comment
    /*
        This is block comment
        Developer: Joan C. Ayala
    */
        


    echo "Hello world. We're here"; //hace print
    $num1 = 20;
    $num2 = 10;
    $add = $num1+$num2;
    echo "<br>";
    echo  "<font color ='red'><b>The adittion is:</b></font> ". $add;
    if($num1 > $num2){
        echo "<br>You win";
    }else {
        echo "<br>You lose";
    }
?>