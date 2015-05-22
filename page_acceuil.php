<?php
/*INCLURE LA CONNECTION A LA BASE DE DONNEE*/ 
include("connection_bd.php");

/* DEMARAGE DE LA SESSION */
session_start();

/* TEST SI L'ID ET LE MDP SONT VALIDE */
if (isset($_SESSION["id"])){
        echo "<br>".$_SESSION["id"];
        echo "<br>".$_SESSION["mdp"];
        
        /* recuperation de l'id egual */
        $requete="SELECT id FROM UTILISATEUR WHERE `id` = '".$_SESSION["id"]."'";
        $resultat=  mysqli_query($database, $requete);       
        if($resultat){  
            echo "OK, requete correct <br>";
            while($ligne=  mysqli_fetch_array($resultat,MYSQLI_ASSOC)){
                $tableau_id[]= $ligne["id"];               
            }
            //print_r($tableau_id);
/* !!!!!!! */if (empty($tableau_id)){
                echo "<script type='text/javascript'>document.location.replace('page_authentification_form.php');</script>";
            }
        }else{
            echo "KO, requete incorrect<br>";
            echo(mysqli_error($database));
        }
        
        /* recuperation du mot de passe egual  */
        $requete="SELECT mdp FROM UTILISATEUR WHERE `mdp` = '".$_SESSION["mdp"]."'";
        $resultat=  mysqli_query($database, $requete);       
        if($resultat){  
            echo "OK, requete correct <br>";
            while($ligne=  mysqli_fetch_array($resultat,MYSQLI_ASSOC)){
                $tableau_mdp[]= $ligne["mdp"];
            }  
            //print_r($tableau_mdp);
            if (empty($tableau_mdp)){
               echo "<script type='text/javascript'>document.location.replace('page_authentification_form.php');</script>";
            }
        }else{
            echo "KO, requete incorrect<br>";
            echo(mysqli_error($database));
        }

}else{
    echo "<script type='text/javascript'>document.location.replace('page_authentification_form.php');</script>";
}


echo "<h1> PAGE ACCEUIL<h1>";

?>
