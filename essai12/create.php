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
$nom = $actif = $image = "";
$nom_err = $actif_err = $image_err = "";
$date_ins = date('Y/m/d h:i:s a', time());
$new_uuid = gen_uuid();
//$date_ins= "1970-10-10 13:23:23"; 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
	// Validate nom
    $input_nom = trim($_POST["nom"]);
    if(empty($input_nom)){
        $nom_err = "Merci de renseigner un nom.";
    } elseif(!filter_var($input_nom, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nom_err = "Merci d'entrer un nom valide.";
    } else{
        $nom = $input_nom;
    }
    
    // Validate actif
    $input_actif = trim($_POST["actif"]);
    if(empty($input_actif)){
        $actif_err = "Merci de dire si l'agence est active (oui/non).";     
    } else{
        $actif = $input_actif;
    }
    
    // Validate image
    $input_image = trim($_POST["image"]);
    if(empty($input_image)){
        $image_err = "Merci de renseigner le nom du logo.";     
    } elseif(!filter_var($input_nom, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $image_err = "Merci de renseigner un nom de logo valide.";
    } else{
        $image = $input_image;
    }
    
    // Check input errors before inserting in database
    if(empty($nom_err) && empty($actif_err) && empty($image_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (id, nom, actif, image, created_at, created_at) VALUES ($new_uuid, ?, ?, ?, $date_ins, $date_ins)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $new_uuid, $param_nom, $param_actif, $param_image, $date_ins, $date_ins);
            
            // Set parameters
            $param_nom = $nom;
            $param_actif = $actif;
            $param_image = $image;
            
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
    <title>Nouvelle agence</title>
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
                        <h2>Créer une nouvelle agence</h2>
                    </div>
                    <p>Formulaire de création d'une nouvelle agence</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nom_err)) ? 'has-error' : ''; ?>">
                            <label>nom</label>
                            <input type="text" name="nom" class="form-control" value="<?php echo $nom; ?>">
                            <span class="help-block"><?php echo $nom_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($actif_err)) ? 'has-error' : ''; ?>">
                            <label>actif</label>
                            <select name="actif" class="form-control" value="<?php echo $actif; ?>">
								<option value="Oui">Active</option>
								<option value="Non">Non-active</option>
 							</select>
						<span class="help-block"><?php echo $actif_err;?></span>
						</div>
                        <div class="form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                            <label>image</label>
                            <input type="text" name="image" class="form-control" value="<?php echo $image; ?>">
                            <span class="help-block"><?php echo $image_err;?></span>
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