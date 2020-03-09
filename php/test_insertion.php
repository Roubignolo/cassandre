<?php
//https://codewithawa.com/posts/php-crud-create,-edit,-update-and-delete-posts-with-mysql-database
	session_start();

	$servername = "localhost";
	$username = "jerome";
	$password = "Mari1664";
	$dbname = "cass_db";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	
	echo $conn;
	
	if ($conn->connect_error) {
		die("Erreur de connexion : " . $conn->connect_error);
	}
	
	$conn->set_charset("utf8");

	// initialize variables agences
	$nom = "tata";
	$actif = "oui";
	$image = "chemin";
	$id = "eee";
	$date = date('m/d/Y h:i:s a', time());
	
	mysqli_query($db, "INSERT INTO agences (id, nom, actif, image, created_at, updated_at) VALUES ('$id', '$nom', '$actif', '$image','$date','$date')"); 

	$conn->close();
?>