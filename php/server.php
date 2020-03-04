<?php

function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
} 
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
		$id = gen_uuid();
		$nom = $_POST['nom'];
		$actif = $_POST['actif'];
		$logo = $_POST['logo'];

		mysqli_query($db, "INSERT INTO agences (id, nom, actif, logo) VALUES ('$id', '$nom', '$actif', '$logo')"); 
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
