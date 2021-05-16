<?php
    include 'accessBDDPraticien.php';

    // Ajouter une activité en fonction des informations du formulaire
    if(isset($_POST['creer']) && !empty($_POST["txtDate"]) && !empty($_POST["txtLieu"]) && !empty($_POST["txtTheme"])) {
        $leNumMaxActivite = max(getLesActivites()); 
        $_POST["txtNum"] = $leNumMaxActivite['AC_NUM'] + 1 ;
        insertActivite($_POST["txtNum"], $_POST["txtDate"], $_POST["txtLieu"], $_POST["txtTheme"]);
    }

    // Modifie la date de l'activité sélectionnée 
    if(isset($_POST['update']) && !empty($_POST["lstActivites"]) && !empty($_POST["txtDate"])){
        updateDateActivite($_POST['lstActivites'], $_POST["txtDate"]);
    }
?>
<html>
<head>
    <title>Activités</title>
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

    <h4 class="mx-3">Listes des activités :</h4>
    <!-- Tableau qui affiche toutes les informations des activités -->
    <table class="table table-bordered">
        <thead >
            <tr class="table-primary">
                <th scope="col">Num </th>
                <th scope="col">Date </th>
                <th scope="col">Lieu </th>
                <th scope="col">Thème</th>
                <th scope="col">Praticiens qui participent à une activité</th>
            </tr>
        </thead>
        <tbody>
        <?php $lesActivites = getLesActivites();        
        foreach($lesActivites as $activite){ ?>
            <tr>          
                <td><?php echo $activite['AC_NUM']."<br>";?> </td>                    
                <td><?php echo $activite['AC_DATE']."<br>";?> </td>
                <td><?php echo $activite['AC_LIEU']."<br>";?></td>                
                <td><?php echo $activite['AC_THEME']."<br>";?></td>
                <td> <!-- Affiche tous les praticiens qui participent à l'activité -->
                    <?php $lesActivitesDesPraticiens = getLesActivitesDesPraticiens($activite['AC_NUM']);
                    foreach($lesActivitesDesPraticiens as $activitePraticien){
                        echo $activitePraticien['PRA_NOM']." ";
                        echo $activitePraticien['PRA_PRENOM']."<br>";
                    }
                    ?>                    
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-4">
            <form method="POST"> <!-- Formulaire pour créer des activités -->
                <h4 class="mx-2">Créer des activités :</h4> <br>
                <div class="col-8">
                    <h6> Num : </h6>
                    <?php $leNumMaxActivite = max(getLesActivites()); ?>
                    <input type="text" class="form-control" name="txtNum" value="<?php echo $leNumMaxActivite['AC_NUM'] + 1 ?>" disabled="disabled" > <br>
                </div>
                <div class="col-8">
                    <h6> Date : </h6>
                    <input type="date" required="true" class="form-control" name="txtDate"> <br>
                </div>
                <div class="col-8">        
                    <h6> Lieu : </h6>
                    <input type="text" required="true" class="form-control" name="txtLieu" placeholder="Lieu"><br>
                </div>
                <div class="col-8">
                    <h6> Thème : </h6>
                    <input type="text" required="true" class="form-control" name="txtTheme" placeholder="Thème" > <br>
                </div>
                <div class="col-4"> <br>
                    <button class="btn btn-outline-primary" type="submit" name="creer">Créer</button><br>
                </div>
            </form> 
        </div>    
        <div class="col-4">
            <form method="POST"> <!-- Formulaire pour modifier la date des activités -->
                <h4 class="mx-2">Modifier la date des activités :</h4> <br>
                <div class="col-8">
                <h6> Choix de l'activité : </h6>
                    <select name='lstActivites' class="form-control">
                    <?php $lesActivites = getLesActivites(); 
                    foreach($lesActivites as $activite){ ?>
                        <option value="<?php echo $activite['AC_NUM'] ?>"> <?php echo $activite['AC_NUM']." ".$activite['AC_LIEU']." - ".$activite['AC_THEME']?> </option>
                    <?php } ?>
                    </select>
                </div>
                <div class="col-8">
                    <h6> Date : </h6>
                    <input type="date" required="true" class="form-control" name="txtDate"> <br>
                </div>                
                <div class="col-8"> <br>
                    <button class="btn btn-outline-primary" type="submit" name="update">Modifier la date</button><br>
                </div>
            </form> 
        </div>
    </div>
</body>
</html>