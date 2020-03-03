<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap 4 Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h1>Administraion Cassand.re</h1>
  <h2>Gestion des agences</h2>
	<?php
		$servername = "localhost";
		$username = "jerome";
		$password = "Mari1664";
		$dbname = "cass_db";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$mysqli->set_charset("utf8");
		echo "<H2>Liste des agences</h2><BR>";
		$requete = 'SELECT * FROM agences';
		$resultat = $mysqli->query($requete);
		while ($ligne = $resultat->fetch_assoc()) {
			echo $ligne['nom'].' '.$ligne['actif'].' '.$ligne['image'].' ';
			echo $ligne['id'].' '.$ligne['created-at'].'<br>';
		}
		
		echo "<BR><H2>Liste des users</h2><BR>";
		$requete = 'SELECT * FROM users';
		$resultat = $mysqli->query($requete);
		while ($ligne = $resultat->fetch_assoc()) {
			echo $ligne['prenom'].' '.$ligne['nom'].' '.$ligne['societe'].' ';
			echo 'Actif: '+$ligne['actif'].' id: '.$ligne['id'].'<br>';
		}
		$mysqli->close();
	?>
		

  <h2>Gestion des admins</h2>
  <h2>Gestion des users</h2>
  <h2>Gestion des exercices</h2>
 
</div>

</body>
</html>