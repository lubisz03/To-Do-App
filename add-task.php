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

    if (isset($_POST["submit"])) {
        if ( !isset($_POST['title']) ) {
            exit('Please fill the task title field!');
        }
    }

    if ($stmt = $con->prepare('INSERT INTO tasks (title, user_id) VALUES(?, ?)')) {
        $stmt->bind_param('si', $_POST['title'], $_SESSION['id']);

        if ($stmt->execute()) {
            header('Location: home.php');
        } else {
            echo 'Action failed! Please try again';
        }
    
        $stmt->close();
    }

    header('Location: home.php');
?>
