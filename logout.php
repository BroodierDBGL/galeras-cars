<?php
    session_start();
    session_destroy();  //Destruye la sesion
    header('refresh:0;url=login.php');
?>