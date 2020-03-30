<?php
// Include config file
require_once "config.php";

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

	
// Define variables and initialize with empty values
$id_clients = $id_superusers = $nom = $date = "";
$id_clients_err = $id_superusers_err = $nom_err = $date_err = "";

$date_ins = date('Y/m/d h:i:s a', time());
$new_uuid = gen_uuid();
//$date_ins= "1970-10-10 13:23:23"; 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
	// Validate nom
    $input_id_clients = trim($_POST["id_clients"]);
    if(empty($input_id_clients)){
        $id_clients_err = "Merci de renseigner un client.";
    } elseif(!filter_var($input_id_clients, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $id_clients_err = "Merci d'entrer un client valide.";
    } else{
        $id_clients = $input_id_clients;
    }

	$input_id_superusers = trim($_POST["id_superusers"]);
    if(empty($input_id_superusers)){
        $id_superusers_err = "Merci de renseigner un utilisateur.";
    } elseif(!filter_var($input_id_superusers, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $id_superusers_err = "Merci d'entrer un utilisateur valide.";
    } else{
        $id_superusers = $input_id_superusers;
    }
	
    $input_nom = trim($_POST["nom"]);
    if(empty($input_nom)){
        $nom_err = "Merci de renseigner un nom.";
    } elseif(!filter_var($input_nom, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nom_err = "Merci d'entrer un nom valide.";
    } else{
        $nom = $input_nom;
    }
 
    $input_date = trim($_POST["date"]);
    if(empty($input_date)){
        $date_err = "Merci de renseigner une date pour l'exercice.";
    } elseif(!filter_var($input_date, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $date_err = "Merci d'entrer une date valide.";
    } else{
        $date = $input_date;
    }
	

    // Check input errors before inserting in database
    if(empty($id_clients_err) && empty($id_superusers_err) && empty($nom_err) && empty($date_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO exercices (id, id_clients, id_superusers, nom, date) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $new_uuid, $param_id_clients , $param_id_superusers ,$param_nom, $param_date);
            
            // Set parameters
			
            $param_id_clients = $id_clients;
            $param_id_superusers = $id_superusers;
            $param_nom = $nom;
            $param_date = date_format($date, 'Y-m-d H:i:s');

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Erreur. Veuillez réessayer ultérieurement.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvel exercice</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Créer un nouvel exercice</h2>
                    </div>
                    <p>Formulaire de création d'un nouvel exercice</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($id_clients_err)) ? 'has-error' : ''; ?>">
                            <label>Client</label>
                            <input type="text" name="id_clients" class="form-control" value="<?php echo $id_clients; ?>">
                            <span class="help-block"><?php echo $id_clients_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($id_superusers_err)) ? 'has-error' : ''; ?>">
                            <label>Créateur</label>
							<input type="text" name="id_superusers" class="form-control" value="<?php echo $id_superusers; ?>">
                            <span class="help-block"><?php echo $id_superusers_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($nom_err)) ? 'has-error' : ''; ?>">
                            <label>Nom</label>
                            <input type="text" name="nom" class="form-control" value="<?php echo $nom; ?>">
                            <span class="help-block"><?php echo $nom_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($date_err)) ? 'has-error' : ''; ?>">
                            <label>Date</label>
					        <input type="datetime-local" name="date" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($date);); ?>">
                            <span class="help-block"><?php echo $date_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Valider">
                        <a href="index.php" class="btn btn-default">Annuler</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>