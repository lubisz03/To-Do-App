<?php 
    include('./db/dbconfig.php');
    include('./db/dbconnection.php');

    session_start();

    $db = (new DB($db_config))->getConnection();

    if (isset($_POST["submit"])) {
        if ( !isset($_POST['title']) ) {
            exit('Please fill the task title field!');
        }
    }

    if ($stmt = $db->prepare('INSERT INTO tasks (title, user_id) VALUES(?, ?)')) {
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
