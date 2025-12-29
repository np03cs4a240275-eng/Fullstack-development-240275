<?php
require 'db.php';

if($_SERVER['REQUEST_METHOD']==="POST"&& isset($_POST['add_student'])){
    try{
	    $name = $_POST['name']??'';
		$email = $_POST['email']??'';
		$course = $_POST['course']??'';


		$sql = "INSERT INTO students (name, email, course)
		       VALUES(?,?,?)";

		$stmt= $pdo->prepare($sql);

		$stmt->execute([$name, $email, $course]);

		echo "Student added successfully!";
	
		header("Location: index.php");

    }
    catch(PDOException $e){
    	die("Unable to Insert Student".$e->getMessage());
    }

}



?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Student Database</title>
	<style>
		input{
			display:block;
			margin-bottom: 2rem;
		}
	</style>
</head>
<body>
<h1>Insert Student Credentials!</h1>
<form method="POST">
	Name: <input type="text" name="name" required><br>
	Email: <input type="email" name="email" required><br>
	Course: <input type="text" name="course"><br>
	<button type="submit" name="add_student">Add Student</button>
</form>
</body>
</html>