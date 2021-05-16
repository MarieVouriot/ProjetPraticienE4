<?php
    include 'accessBDDPraticien.php';

    // Ajoute un praticien lorsque les informations du formulaire sont toutes remplis
    if(isset($_POST['creer']) && !empty($_POST["txtNom"]) && !empty($_POST["txtPrenom"]) && !empty($_POST["txtAdresse"]) && !empty($_POST["txtCp"]) && !empty($_POST["txtVille"]) && !empty($_POST["txtCoef"]) && !empty($_POST["lstTypePraticiens"]) ) {
        $leNumMaxPraticien = max(getLesPraticiens()); 
        $_POST['txtNum'] = $leNumMaxPraticien['PRA_NUM'] + 1 ;
        insertPraticien($_POST["txtNum"], $_POST["txtNom"], $_POST["txtPrenom"], $_POST["txtAdresse"], $_POST["txtCp"], $_POST["txtVille"], $_POST["txtCoef"], $_POST["lstTypePraticiens"]);
    }

    // Ajoute une spécilaté à un praticien en sélectionnant les informations dans le select
    if(isset($_POST['ajouter']) && !empty($_POST["lstNoms"]) && !empty($_POST["lstSpecialites"])){
        insertSpecialiteAPraticien($_POST["lstNoms"], $_POST["lstSpecialites"]);
    }

    // Supprime une spécilaité à un praticien en sélectionnant les informations dans le select
    if(isset($_POST['supprimer']) && !empty($_POST["lstNomsSupp"]) && !empty($_POST["lstSpecialitesSupp"])){
        deleteSpecialitePraticien($_POST["lstNomsSupp"], $_POST["lstSpecialitesSupp"]);
    }
    
?>
<html>
<head>
    <title>Praticien</title>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">        
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-primary">
    <a class="navbar-brand" href="index.php">Accueil</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample03">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
            <a class="nav-link" href="praticien.php">Praticiens<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="specialite.php">Spécialités</a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="activite.php" tabindex="-1" aria-disabled="true">Activités</a>
        </li>        
        </ul>
        <!-- <a class="navbar-brand" >
            <img src="logo.PNG" width="40" height="40" alt="">
        </a> -->
    </div>
    </nav>

    <h4 class="mx-3">Listes des praticiens</h4>
    <!-- Tableau qui affiche toutes les informations des praticiens -->
    <table class="table table-bordered">
        <thead >
            <tr class="table-primary">
                <th scope="col">Nom </th>
                <th scope="col">Prenom </th>
                <th scope="col">Adresse </th>
                <th scope="col">Code Postal </th>
                <th scope="col">Ville </th>
                <th scope="col">Coefficient notoriété</th>
                <th scope="col">Spécialités</th>
                <th scope="col">Type de Praticien</th>
            </tr>
        </thead>
        <tbody>
        <?php $lesPraticiens = getLesPraticiens();        
        foreach($lesPraticiens as $praticien){            
            ?>
            <tr>          
                <td><?php echo $praticien['PRA_NOM']."<br>";?> </td>
                <td><?php echo $praticien['PRA_PRENOM']."<br>";?> </td>
                <td><?php echo $praticien['PRA_ADRESSE']."<br>";?> </td>
                <td><?php echo $praticien['PRA_CP']."<br>";?> </td>
                <td><?php echo $praticien['PRA_VILLE']."<br>";?> </td>
                <td><?php echo $praticien['PRA_COEFNOTORIETE']."<br>";?></td>
                <td> <!-- Affiche les spécialités possédées par le praticien -->
                    <?php $lesSpecialitesPossedees = getLesSpecialitesPossedees($praticien['PRA_NUM']);
                    foreach($lesSpecialitesPossedees as $specialitePossedee){
                        echo $specialitePossedee['SPE_LIBELLE']."<br>";
                    }?>
                </td>
                <td> <!-- Affiche le type de praticien -->
                    <?php $lesTypesPraticiensPossedees = getTypePraticienPossedee($praticien['PRA_NUM']);
                    foreach($lesTypesPraticiensPossedees as $leTypePraticienpossedee){
                        echo $leTypePraticienpossedee['TYP_LIBELLE']."<br>";
                    }?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table><br>
    <div class="row">       
        <div class="col-4">
            <form method="POST"> <!-- Formulaire pour créer des praticiens -->
                <h4 class="mx-2">Créer des praticiens :</h4> <br>
                <div class="col-8">
                    <h6> Num : </h6>
                    <?php $leNumMaxPraticien = max(getLesPraticiens()); ?>
                    <input type="text" class="form-control" name="txtNum" value="<?php echo $leNumMaxPraticien['PRA_NUM'] + 1 ?>" disabled="disabled" > <br>
                </div>
                <div class="col-8">
                    <h6> Nom : </h6>
                    <input type="text" required="true" class="form-control" name="txtNom" placeholder="Nom"> <br>
                </div>
                <div class="col-8">        
                    <h6> Prenom : </h6>
                    <input type="text" required="true" class="form-control" name="txtPrenom" placeholder="Prenom"><br>
                </div>
                <div class="col-8">
                    <h6> Adresse : </h6>
                    <input type="text" required="true" class="form-control" name="txtAdresse" placeholder="Adresse" > <br>
                </div>
                <div class="col-8">
                    <h6> Code postal : </h6>
                    <input type="text" required="true" class="form-control" name="txtCp" placeholder="Code postal"> <br>
                </div>
                <div class="col-8">        
                    <h6> Ville : </h6>
                    <input type="text" required="true" class="form-control" name="txtVille" placeholder="Ville"><br>
                </div>
                <div class="col-8">        
                    <h6> Coefficient notoriété : </h6>
                    <input type="text" required="true" class="form-control" name="txtCoef" placeholder="Coefficient notoriété"><br>
                </div>                
                <div class="col-8">        
                    <h6> Type de praticien : </h6>
                    <select name='lstTypePraticiens' class="form-control">
                    <?php $lesTypesPraticiens = getTypePraticien(); 
                    foreach($lesTypesPraticiens as $typePraticien){ ?>
                        <option value="<?php echo $typePraticien['TYP_CODE'] ?>"> <?php echo $typePraticien['TYP_LIBELLE'] ?> </option>
                    <?php } ?>
                    </select>
                </div>
                <div class="col-4"> <br>
                    <button class="btn btn-outline-primary" type="submit" name="creer">Créer</button><br>
                </div>
            </form> 
        </div>               
        <div class="col-4"> 
            <form method="POST"> <!-- Formulaire pour ajouter une spécialité à un praticien -->           
                <h4 class="mx-2">Ajouter une spécialité à un praticien :</h4> <br>
                <div class="col-8">
                    <h6>Nom : </h6>
                    <select name="lstNoms" class="form-control"> <!-- Liste de praticien -->
                    <?php $lesPraticiens = getLesPraticiens();        
                    foreach($lesPraticiens as $praticien){ ?>
                        <option value="<?php echo $praticien['PRA_NUM'] ?>"> <?php echo $praticien['PRA_NOM'] ?> </option>
                    <?php } ?>
                    </select><br>
                </div>
                <div class="col-8">        
                    <h6> Spécialités : </h6>
                    <select name="lstSpecialites" class="form-control"> <!-- Liste de spécilaité -->
                    <?php $lesSpecialites = getLesSpecialites(); 
                    foreach($lesSpecialites as $specialite){ ?>
                        <option value="<?php echo $specialite['SPE_CODE'] ?>"> <?php echo $specialite['SPE_LIBELLE'] ?> </option>
                        <?php } ?>
                    </select><br>
                </div> 
                <div class="col-4"> <br>
                    <button class="btn btn-outline-primary" type="submit" name="ajouter">Ajouter</button><br>
                </div>
            </form>
        </div>
        <div class="col-4">
            <form method="POST"> <!-- Formulaire pour supprimer une spécialité à un praticien -->        
                <h4 class="mx-2">Supprimer une spécialité à un praticien :</h4> <br>
                <div class="col-8">
                    <h6>Nom : </h6>
                    <select name="lstNomsSupp" class="form-control"> <!-- Liste de praticien -->
                    <?php $lesPraticiens = getLesPraticiens();        
                    foreach($lesPraticiens as $praticien){ ?>
                        <option value="<?php echo $praticien['PRA_NUM'] ?>"> <?php echo $praticien['PRA_NOM'] ?> </option>
                    <?php } ?>
                    </select><br>
                </div>
                <div class="col-8">        
                    <h6> Spécialités : </h6>
                    <select name="lstSpecialitesSupp" class="form-control"> <!-- Liste de spécilaité -->
                    <?php $lesSpecialites = getLesSpecialites(); 
                    foreach($lesSpecialites as $specialite){ ?>
                        <option value="<?php echo $specialite['SPE_CODE'] ?>"> <?php echo $specialite['SPE_LIBELLE'] ?> </option>
                    <?php } ?>
                    </select><br>
                </div> 
                <div class="col-4"> <br>
                    <button class="btn btn-outline-primary" type="submit" name="supprimer">Supprimer</button><br>
                </div>
            </form>
        </div>
    </div> 
</body>
</html>