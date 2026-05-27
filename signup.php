<?php
    //1. recibe metodo de envio por post
    include('config/database.php');

    //2. Get data
    $f_name  = $_POST ['fname'];
    $l_name  = $_POST ['lname'];
    $e_mail  = $_POST ['email'];
    $m_phone = $_POST ['mphone'];
    $p_sswd  = $_POST ['psswd'];
    $enc_pass = md5($p_sswd);

    // FEATURE 1: Validar unicidad del email
    $email_check = pg_query($local_conn, "SELECT id FROM users WHERE email = '$e_mail'");

    if (pg_num_rows($email_check) > 0) {
        echo "Error: El correo '$e_mail' ya esta registrado. Use un correo diferente.";
        exit();
    }
    
    // FEATURE 2: Validar unicidad del celular
    $phone_check = pg_query($local_conn, "SELECT id FROM users WHERE mobile_phone = '$m_phone'");

    if (pg_num_rows($phone_check) > 0) {
        echo "Error: El celular '$m_phone' ya esta registrado. Use un numero diferente.";
        exit();
    }

    // FEATURE 3: Registro atomico en Local y Supabase
    pg_query($local_conn, "BEGIN");
    pg_query($supa_conn,  "BEGIN");

    // FEATURE 4: Hasheo seguro con bcrypt en lugar de MD5
    //$enc_pass = password_hash($p_sswd, PASSWORD_BCRYPT);

    //Query to insert into SQL
    $sql = "INSERT INTO users (firstname, lastname, email, mobile_phone, psswd, url_photo)
               
               values('$f_name', '$l_name', '$e_mail','$m_phone','$enc_pass','profile_photos/user_default_2.png')";  //values('Pablo', 'Tomson', 'tom@mail.com','300777000','123')";
               

    //Execute query
    /*
    $result = pg_query($local_conn, $sql);

    if(!$result){
        echo "Error al conectar con la BD";
    }else{
        //echo "Registrado Exitosamente!";
        echo "<script>alert('Listo. Usuario registrado')</script>";
        header('refresh:0;url=signin.html');
    }*/

    $local_result = pg_query($local_conn, $sql);
    $supa_result  = pg_query($supa_conn,  $sql);

    if ($local_result && $supa_result) {
        pg_query($local_conn, "COMMIT");
        pg_query($supa_conn,  "COMMIT");
        //echo "Registrado Exitosamente en ambas bases de datos!";
        echo "<script>alert('Listo. Usuario registrado')</script>";
        header('refresh:0;url=login.php');

    } else {
        pg_query($local_conn, "ROLLBACK");
        pg_query($supa_conn,  "ROLLBACK");
        echo "Error: El registro fallo. Se deshicieron los cambios en ambas bases de datos.";
    }

    //Para comprobar se usa postman

    /*
    ###Endpoint
    http://127.0.0.1:8080/app-beta-u/src/signup.php → se inserta en la barra (aparece a plena vista) 
    //                                                        de insert de postman y se despliega GET y
    //                                                        selecciona POST
    */
?>