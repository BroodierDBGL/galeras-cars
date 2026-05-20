<?php
    //1. recibe metodo de envio por post
    //DATABASE CONNECTION
    require('config/database.php');

    //  GET DATA from LOGIN FORM
    $e_mail = $_POST['email'];
    $p_asswd = $_POST['pswd'];
    $enc_pass = md5($p_asswd); //  Para un ejercicio se comentaréo el metodo diferente a md5 y se usa md5
    
    //  Consulta (Query)
    $sql_login = "
        select * from users u
        where u.email = '$e_mail' and
        u.psswd = '$enc_pass'
    ";

    //  Ejecutar consulta (execute query)
    $res = pg_query($sql_login);

    //  Revisar si query funciona
    if($res) {
        $num = pg_num_rows($res); //  Número de registros o usuarios 
        if($num > 0){
            header('refresh:0;url=home.php'); //
        }else{
            echo "<script>alert('Email or password not found')</script>";
            header('refresh:0;url=index.html');
        }
    }else{
        echo "Query error !!!";
    }
?>