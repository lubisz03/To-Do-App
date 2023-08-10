<?php
    session_start();

    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.html');
        exit;
    } else {
        $DATABASE_HOST = 'localhost';
        $DATABASE_USER = 'root';
        $DATABASE_PASS = '';
        $DATABASE_NAME = 'to-do';

        $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

        if ( mysqli_connect_errno() ) {
            exit('Failed to connect to MySQL: ' . mysqli_connect_error());
        }

        if ($stmt = $con->prepare('SELECT id, title FROM tasks WHERE user_id = ?')) {
            $stmt->bind_param('i', $_SESSION["id"]);
            $stmt->execute();
        
            $result = $stmt->get_result();

            $tasks = array();

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    array_push($tasks, array("id" => $row["id"], "title" => $row["title"]));
                }

                $_SESSION["tasks"] = $tasks;

            } else {
                $_SESSION["tasks"] = 'No tasks';
            }
        
            $stmt->close();
        } else {
            $_SESSION["tasks"] = 'No tasks';
        }
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link href="./style.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>To-Do App</h1>
				<a href="add-task.html"><i class="fas fa-add"></i>Add task</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Welcome back, <?=$_SESSION['name']?>!</h2>
			<h3>Yor tasks:</h3>
            <?php 
                if (is_array($_SESSION["tasks"])) {
                    echo "<ul>";
                    foreach ($_SESSION["tasks"] as $task) {
                        echo "<li>";
                        echo $task["title"];
                        echo "<button onClick='removeTask($task[id])'>";
                        echo '<i class="fa-solid fa-trash"></i>';
                        echo "</button>";
                        echo "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<h3>";
                    echo $_SESSION["tasks"];
                    echo "</h3>";
                }
            ?>
		</div>
	</body>
</html>