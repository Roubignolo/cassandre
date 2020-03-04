<?php  include('server.php'); ?>
<?php 
	if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$update = true;
		$record = mysqli_query($db, "SELECT * FROM info WHERE id=$id");

		if (count($record) == 1 ) {
			$n = mysqli_fetch_array($record);
			$nom = $n['nom'];
			$actif = $n['actif'];
			$logo = $n['logo'];
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Cassandre - Administration</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php if (isset($_SESSION['message'])): ?>
		<div class="msg">
			<?php 
				echo $_SESSION['message']; 
				unset($_SESSION['message']);
			?>
		</div>
	<?php endif ?>
	<h2>Créer une nouvelle agence</h2>
	<?php $results = mysqli_query($db, "SELECT * FROM info"); ?>

	<table>
		<thead>
			<tr>
				<th>Nom</th>
				<th>Actif</th>
				<th>Logo</th>
				<th colspan="2">Action</th>
			</tr>
		</thead>
		
		<?php while ($row = mysqli_fetch_array($results)) { ?>
			<tr>
				<td><?php echo $row['nom']; ?></td>
				<td><?php echo $row['actif']; ?></td>
				<td><?php echo $row['logo']; ?></td>
				<td>
					<a href="index.php?edit=<?php echo $row['id']; ?>" class="edit_btn" >Modifier</a>
				</td>
				<td>
					<a href="server.php?del=<?php echo $row['id']; ?>" class="del_btn">Supprimer</a>
				</td>
			</tr>
		<?php } ?>
	</table>

	<form method="post" action="server.php" >
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<div class="input-group">
			<label>Nom</label>
			<input type="text" name="Nom" value="<?php echo $nom; ?>">
		</div>
		<div class="input-group">
			<label>Actif</label>
			<input type="text" name="Actif" value="<?php echo $actif; ?>">
		</div>
		<div class="input-group">
			<label>Logo</label>
			<input type="text" name="Logo" value="<?php echo $logo; ?>">
		</div>
		<div class="input-group">
			<?php if ($update == true): ?>
				<button class="btn" type="submit" name="update" style="background: #556B2F;" >Modifier</button>
			<?php else: ?>
				<button class="btn" type="submit" name="save" >Sauvegarde}r</button>
			<?php endif ?>
		</div>
	</form>
</body>
</html>