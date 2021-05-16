<?php
function getLesPraticiens(){
    $bdd = new PDO('mysql:host=localhost;dbname=praticien; charset=utf8','root','')
        or die('Erreur connexion à la base de données');
    $requete = "select * from praticien";
    $resultat = $bdd->query($requete);
    return $resultat->fetchAll();
}

function getNbPraticienParSpecialite(){
    $bdd = new PDO('mysql:host=localhost;dbname=praticien','root','')
        or die('Erreur connexion à la base de données');
    $requete = "select COUNT(po.PRA_NUM), pr.PRA_NOM, pr.PRA_PRENOM from posseder po inner join praticien pr on po.PRA_NUM = pr.PRA_NUM GROUP BY po.PRA_NUM";
    $resultat = $bdd->query($requete);
    return $resultat->fetchAll();    
}

function getLesSpecialites(){
    $bdd = new PDO('mysql:host=localhost;dbname=praticien','root','')
        or die('Erreur connexion à la base de données');
    $requete = "select * from specialite";
    $resultat = $bdd->query($requete);
    return $resultat->fetchAll();
}

function getLesSpecialitesPossedees($num){
    $bdd = new PDO('mysql:host=localhost;dbname=praticien','root','')
        or die('Erreur connexion à la base de données');
    $requete = "select * from posseder p inner join specialite s on p.SPE_CODE = s.SPE_CODE where PRA_NUM = '$num'";
    $resultat = $bdd->query($requete);
    return $resultat->fetchAll();
}

function getNbParticipantParActivite(){
    $bdd = new PDO('mysql:host=localhost;dbname=praticien; charset=utf8','root','')
        or die('Erreur connexion à la base de données');
    $requete = "select count(i.AC_NUM), AC_THEME, AC_LIEU FROM inviter i RIGHT join activite_compl a on i.AC_NUM = a.AC_NUM group by i.AC_NUM";
    $resultat = $bdd->query($requete);
    return $resultat->fetchAll();    
}

function getPosseder($code){
    $bdd = new PDO('mysql:host=localhost;dbname=praticien','root','')
        or die('Erreur connexion à la base de données');
    $requete = "select * from posseder where SPE_CODE = '$code'";
    $resultat = $bdd->query($requete);
    return $resultat->fetchAll();
}

function getTypePraticien(){
    $bdd = new PDO('mysql:host=localhost;dbname=praticien; charset=utf8','root','')
        or die('Erreur connexion à la base de données');
    $requete = "select * from type_praticien";
    $resultat = $bdd->query($requete);
    return $resultat->fetchAll();
}

function getTypePraticienPossedee($num){
    $bdd = new PDO('mysql:host=localhost;dbname=praticien; charset=utf8','root','')
        or die('Erreur connexion à la base de données');
    $requete = "select * from type_praticien t inner join praticien p on t.TYP_CODE = p.TYP_CODE where PRA_NUM = '$num'";
    $resultat = $bdd->query($requete);
    return $resultat->fetchAll();
}

function getLesActivites(){
    $bdd = new PDO('mysql:host=localhost;dbname=praticien; charset=utf8','root','')
        or die('Erreur connexion à la base de données');
    $requete = "select * from activite_compl";
    $resultat = $bdd->query($requete);
    return $resultat->fetchAll();
}

function getLesActivitesDesPraticiens($num){
    $bdd = new PDO('mysql:host=localhost;dbname=praticien; charset=utf8','root','')
        or die('Erreur connexion à la base de données');
    $requete = "select * from inviter i inner join praticien p on i.PRA_NUM = p.PRA_NUM where AC_NUM = '$num'";
    $resultat = $bdd->query($requete);
    return $resultat->fetchAll();
}

function getPraticienPasInvite(){
    $bdd = new PDO('mysql:host=localhost;dbname=praticien; charset=utf8','root','')
        or die('Erreur connexion à la base de données');
    $requete = "select * from praticien where PRA_NUM NOT IN (select PRA_NUM from inviter)";
    $resultat = $bdd->query($requete);
    return $resultat->fetchAll();    
}

function deleteSpecialite($code){
    $bdd = new PDO('mysql:host=localhost;dbname=praticien','root','')
        or die('Erreur connexion à la base de données');
    $requete = "delete from specialite where SPE_CODE = '$code'";
    $bdd->exec($requete);
}

function deleteSpecialitePraticien($num, $code){
    $bdd = new PDO('mysql:host=localhost;dbname=praticien','root','')
        or die('Erreur connexion à la base de données');
    $requete = "delete from posseder where SPE_CODE = '$code' and PRA_NUM = '$num'";
    $bdd->exec($requete);
}

function insertSpecialite($code, $nom){
    $bdd = new PDO('mysql:host=localhost;dbname=praticien; charset=utf8','root','')
        or die('Erreur connexion à la base de données');
    $requete = $bdd->prepare("insert into specialite(SPE_CODE, SPE_LIBELLE) values (:code, :nom)");
    $requete->bindParam('code', $code, PDO::PARAM_INT);
    $requete->bindParam('nom', $nom, PDO::PARAM_STR);
    $requete->execute();
}

function insertPraticien($num, $nom, $prenom, $adresse, $cp, $ville, $coefNotoriete, $typeCode){
    $bdd = new PDO('mysql:host=localhost;dbname=praticien; charset=utf8','root','')
        or die('Erreur connexion à la base de données');
    $requete = $bdd->prepare("insert into praticien(PRA_NUM, PRA_NOM, PRA_PRENOM, PRA_ADRESSE, PRA_CP, PRA_VILLE, PRA_COEFNOTORIETE, TYP_CODE) values (:num, :nom, :prenom, :adresse, :cp, :ville, :coefNotoriete, '$typeCode')");
    $requete->bindParam('num', $num, PDO::PARAM_INT);
    $requete->bindParam('nom', $nom, PDO::PARAM_STR);
    $requete->bindParam('prenom', $prenom, PDO::PARAM_STR);
    $requete->bindParam('adresse', $adresse, PDO::PARAM_STR);
    $requete->bindParam('cp', $cp, PDO::PARAM_INT);
    $requete->bindParam('ville', $ville, PDO::PARAM_STR);
    $requete->bindParam('coefNotoriete', $coefNotoriete, PDO::PARAM_STR);   
    $requete->execute();
}

function insertActivite($num, $date, $lieu, $theme){
    $bdd = new PDO('mysql:host=localhost;dbname=praticien; charset=utf8','root','')
        or die('Erreur connexion à la base de données');
    $requete = $bdd->prepare("insert into activite_compl(AC_NUM, AC_DATE, AC_LIEU, AC_THEME) values (:num, '$date', :lieu, :theme)");
    $requete->bindParam('num', $num, PDO::PARAM_INT);
    $requete->bindParam('lieu', $lieu, PDO::PARAM_STR);
    $requete->bindParam('theme', $theme, PDO::PARAM_STR);
    $requete->execute();
}

function insertSpecialiteAPraticien($num, $code){
    $bdd = new PDO('mysql:host=localhost;dbname=praticien','root','')
        or die('Erreur connexion à la base de données');
    $requete = "insert into posseder(PRA_NUM, SPE_CODE) values ('$num', '$code')";
    $bdd->exec($requete);
}

function updateDateActivite($num, $date){
    $bdd = new PDO('mysql:host=localhost;dbname=praticien','root','')
        or die('Erreur connexion à la base de données');
    $requete = "update activite_compl set AC_DATE = '$date' where AC_NUM = '$num'";
    $bdd->exec($requete);
}

?>