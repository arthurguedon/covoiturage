<?php
    
/*INCLURE LA CONNECTION A LA BASE DE DONNEE*/ 
include("connection_bd.php");

/* DEMARAGE DE LA SESSION */
session_start();


if (isset ($_POST["id"])){
    if (empty ($_POST["id"])){
        echo " id non valide : vide ";
    }
    elseif (empty ($_POST["mdp"])){
        echo "mot de passe non valide : vide";
    }else{
        
        /* recuperation du id egual  */
        $requete="SELECT id FROM UTILISATEUR WHERE `id` = '".$_POST['id']."'";
        $resultat=  mysqli_query($database, $requete);       
        if($resultat){  
            echo "OK, requete correct <br>";
            while($ligne=  mysqli_fetch_array($resultat,MYSQLI_ASSOC)){
                $tableau_id[]= $ligne["id"];
            }            
        }else{
            echo "KO, requete incorrect<br>";
            echo(mysqli_error($database));
        }
        
        /* recuperation du mot de passe egual  */
        $requete="SELECT mdp FROM UTILISATEUR WHERE `mdp` = '".$_POST['mdp']."'";
        $resultat=  mysqli_query($database, $requete);       
        if($resultat){  
            echo "OK, requete correct <br>";
            while($ligne=  mysqli_fetch_array($resultat,MYSQLI_ASSOC)){
                $tableau_mdp[]= $ligne["mdp"];
            }            
        }else{
            echo "KO, requete incorrect<br>";
            echo(mysqli_error($database));
        }
        
        //if (isset($tableau_id) && isset($tableau_mdp)){
            if (!empty($tableau_id) && !empty($tableau_mdp)){
                $_SESSION["id"]=$_POST["id"];
                $_SESSION["mdp"]=$_POST["mdp"];
                echo "<br>".$_SESSION["id"];
                echo "<br>".$_SESSION["mdp"];
                echo "<script type='text/javascript'>document.location.replace('page_acceuil.php');</script>";
            }else {
                echo "identifiant ou mot de passe invalide ";
            }
        //}else {
           // echo "les tableau n'existe pas";
        //}
        
        
        
    }
    
}

?>

