<?php
    //Star session
    session_start(); //Abre una sesion
    if(isset($_SESSION['user_id'])) {
        header('refresh:0;url=index.php');
    }


    //1. recibe metodo de envio por post
    //DATABASE CONNECTION
    require('config/database.php');

    //  GET DATA from LOGIN FORM
    $e_mail = $_POST['email'];
    $p_asswd = $_POST['pswd'];
    $enc_pass = md5($p_asswd); //  Para un ejercicio se comentaréo el metodo diferente a md5 y se usa md5
    
    //  Consulta (Query)
    $sql_login = "
        select u.id, u.email, u.firstname || ' ' || u.lastname as fullname from users u
        where u.email = '$e_mail' and
        u.psswd = '$enc_pass'
    ";

    //  Ejecutar consulta (execute query)
    $res = pg_query($sql_login); //el resultado de select se guarda en $res (osea por ejemplo las columnas qye se muestran en pgadmin)

    //  Revisar si query funciona
    if($res) {
        $num = pg_num_rows($res); //  Número de registros o usuarios 
        $row = pg_fetch_assoc($res);    //
        if($num > 0){
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_fullname'] = $row['fullname'];
            header('refresh:0;url=index.php'); //
        }else{
            echo "<script>alert('Email or password not found')</script>";
            header('refresh:0;url=index.html');
        }
    }else{
        echo "Query error !!!";
    }
?>