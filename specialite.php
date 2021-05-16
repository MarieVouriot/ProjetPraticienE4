<?php
    include 'accessBDDPraticien.php';

    // Supprimer une spécialité en fonction du code de la spécialité
    if(isset($_POST) && !empty($_POST["code"])) {
        deleteSpecialite($_POST["code"]);
    }

    // Ajouter une spécialité 
    if(isset($_POST['creer']) && !empty($_POST["txtNom"])) {
        $codeMaxSpecialite = max(getLesSpecialites()); 
        $_POST['txtCode'] = $codeMaxSpecialite['SPE_CODE'] + 1 ;
        insertSpecialite($_POST["txtCode"], $_POST["txtNom"]);
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

    <h4 class="mx-3">Listes des spécialités :</h4>
    <!-- Tableau qui affiche toutes les informations des spécilaités -->
    <table class="table table-bordered ">
        <thead >
            <tr class="table-primary mx">
                <th>Code </th>
                <th>Nom </th>
                <th>Supprimer </th>
                <th>Nombre de praticien qui posséde la spécialité</th>
            </tr>
        </thead>
        <tbody>
        <?php  
            $lesSpecialites = getLesSpecialites(); 
            foreach($lesSpecialites as $specialite){ ?>
                <tr>            
                    <td><?php echo $specialite['SPE_CODE']."<br>";?> </td>                    
                    <td><?php echo $specialite['SPE_LIBELLE']."<br>";?> </td>
                    <form method="POST">
                        <input type="hidden" name="code" value="<?= $specialite['SPE_CODE']?>">
                        <td><button class="btn btn-outline-secondary" type="submit">Supprimer</button></td>
                    </form>
                    <td> 
                    <?php // Foreach pour compter combien de praticiens possédent la spécialité 
                        $lesPosseder = getPosseder($specialite['SPE_CODE']);  
                        $nb = 0;       
                        foreach($lesPosseder as $posseder){                                       
                            $nb++;                        
                        }
                        echo $nb
                    ?> 
                    </td>
                </tr>
        <?php } ?>
        </tbody>        
    </table>
    <br>
    <h4 class="mx-2">Créer des specialités :</h4>
    <form method="POST"> <!-- Formulaire pour créer des spécialités -->
        <div class="mx-2">
            <div class="col-4">
            <h6> Code : </h6>
            <input type="text" class="form-control" name="txtCode" value="<?php $codeMaxSpecialite = max(getLesSpecialites()); echo $codeMaxSpecialite['SPE_CODE'] + 1 ?>"  disabled="disabled"> <br>
            </div>
            <div class="col-4">        
            <h6> Nom : </h6>
            <input type="text" required="true" class="form-control" name="txtNom"  placeholder="Nom">
            </div>
            <div class="col-2"> 
            <br>
            <button class="btn btn-outline-primary" type="submit" name="creer">Créer</button><br>
            </div>
        </div>
    </form>
</body>
</html>