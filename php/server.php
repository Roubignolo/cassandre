<?php 
	session_start();

	$servername = "localhost";
	$username = "jerome";
	$password = "Mari1664";
	$dbname = "cass_db";

	//$db = mysqli_connect($servername, $username, $password, $dbname);

	$db = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($db->connect_error) {
		die("Erreur de connexion MySQL: " . $conn->connect_error);
	}
	
	$db->set_charset("utf8");
	
	// initialize variables
	$nom = "";
	$actif = "";
	$logo = "";
	$id = "";
	$update = false;

	if (isset($_POST['save'])) {
		$nom = $_POST['nom'];
		$actif = $_POST['actif'];
		$logo = $_POST['logo'];

		mysqli_query($db, "INSERT INTO agences (nom, actif, logo) VALUES ('$nom', '$actif', '$logo')"); 
		$_SESSION['message'] = "Sauvegarde effectuée"; 
		header('location: index.php');
	}
	
	if (isset($_POST['update'])) {
	$id = $_POST['id'];
	$nom = $_POST['nom'];
	$actif = $_POST['actif'];
	$logo = $_POST['logo'];

	mysqli_query($db, "UPDATE info SET nom='$nom', actif='$actif', logo='$logo' WHERE id=$id");
	$_SESSION['message'] = "Mise à jour effectuée"; 
	header('location: index.php');
	}
	
	if (isset($_GET['del'])) {
	$id = $_GET['del'];
	mysqli_query($db, "DELETE FROM info WHERE id=$id");
	$_SESSION['message'] = "Address deleted!"; 
	header('location: index.php');
	}
		
	$conn->close();
?>
