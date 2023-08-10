<?php
    session_start();

    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'to-do';

    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if ( mysqli_connect_errno() ) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    if ( !isset($_POST['username'], $_POST['password']) ) {
        exit('Please fill both the username and password fields!');
    }

    if ($stmt = $con->prepare('INSERT INTO accounts (username, password) VALUES(?, ?)')) {
        $stmt->bind_param('ss', $_POST['username'], password_hash($_POST["password"], PASSWORD_DEFAULT));

        if ($stmt->execute()) {
            header('Location: index.html');
        } else {
            echo 'Sign-up failed! Try using different username';
        }
    
    } else {
        echo 'Sign-up failed! Try using different username';
    }

    $stmt->close();
 ?>