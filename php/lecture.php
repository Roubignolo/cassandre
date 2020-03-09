<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<?php
		$servername = "localhost";
		$username = "jerome";
		$password = "Mari1664";
		$dbname = "cass_db";

		// Create connection
		$mysqli = new mysqli($servername, $username, $password, $dbname);
		// Check connection
	
		
		if ($mysqli->connect_error) {
			die("Erreur de connexion : " . $conn->connect_error);
		}
	
		$mysqli->set_charset("utf8");
		
		$requete = 'SELECT * FROM agences';
		$resultat = $mysqli->query($requete);
		while ($ligne = $resultat->fetch_assoc()) {
			echo $ligne['id'].' '.$ligne['nom'].' '.$ligne['actif'].' ';
			echo $ligne['image'].' '.$ligne['created_at'].'<br>';
		}
		$mysqli->close();
		?>
	</body> 
</html>