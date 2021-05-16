<?php
    include 'accessBDDPraticien.php';
?>
<html>
<head>
    <title>Messagerie</title>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">        
</head>
<form action="praticien.php" method="POST">
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
    
    <h4 class="mx-3"> Quelques chiffres :</h4><br>
    <div class="row">
        <div class="col-4">
        <!-- Pourcentage des praticiens n'ayant jamais été invité à une activité complémentaire -->          
            <?php 
                $lesPraticiens = count(getLesPraticiens());
                $lesPraticiensPasInvite = count(getPraticienPasInvite());
                $nbPraticienPasInvite = ($lesPraticiensPasInvite / $lesPraticiens * 100);
                echo "<p style='color:blue; font-size: 200%' align=center>".round($nbPraticienPasInvite, 2).' %'."</p>";
            ?>
            <p align='center' style='font-size: 125%'>De praticiens n’ayant jamais été invité à une activité complémentaire </p>            
        </div>
        <div class="col-4">
        <!-- Affiche le praticien qui possède le plus de spécialités -->
            <?php
                $nbPraParSpe = max(getNbPraticienParSpecialite());
                echo "<p style='color:blue; font-size: 200%' align=center>".$nbPraParSpe['PRA_NOM']." ".$nbPraParSpe['PRA_PRENOM']." possède ".$nbPraParSpe['COUNT(po.PRA_NUM)']." spécialités"."</p>";
            ?>
            <p align='center' style='font-size: 125%'>Praticien qui possède le plus de spécialités </p>
        </div>
        <div class="col-4">
        <!-- Affiche l'activité avec le moins de participant -->
            <?php
                $nbParticipantParActivite = min(getNbParticipantParActivite());
                echo "<p style='color:blue; font-size: 200%' align=center>".$nbParticipantParActivite['AC_LIEU']." possède ".$nbParticipantParActivite['count(i.AC_NUM)']." praticien"."</p>";
            ?>
            <p align='center' style='font-size: 125%'>L'activité avec le moins de participant </p>
        </div>
    </div>
</body>
</html>