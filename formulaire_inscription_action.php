<?php

/*INCLURE LA CONNECTION A LA BASE DE DONNEE*/ 
include("connection_bd.php");
 
/* ON TEST SI LE FORMULAIRE A BIEN ETE TRANSMIS */
if (isset ($_POST["id"])){ 
        $utilisateurValide=true;
        
        /* recuperer la liste des id d'utilisateur deja existant pour tester que l'id n'existe pas deja*/
        $requete="SELECT id FROM UTILISATEUR";
        $resultat=  mysqli_query($database, $requete);
              
        if($resultat){  
            echo "OK, requete correct <br>";

            while($ligne=  mysqli_fetch_array($resultat,MYSQLI_ASSOC)){
                $tableau_id[]= $ligne["id"];
            }
            
            if (empty($tableau_id)){
                echo"la base de donne est vide<br>";
            }else{
                print_r($tableau_id); echo"<br>";
            }
            
        }else{
            echo "KO, requete incorrect<br>";
            echo(mysqli_error($database));
        }
        
        /* VERIFICATION DE LA JUSTESSE DE CHAQUE ELEMENT DU FORMULAIRE */
        /* - si vide 
         * - si cohérent 
         * - ne pas interpréter les balises et caractere speciaux */
        
        if (empty($_POST["id"]) ){
            $utilisateurValide=false;
            echo"l'id est non valide : vide <br>";              
        }elseif (!empty($tableau_id)){ // verifier cas ou $tableau_id est vide
            if(in_array($_POST["id"],$tableau_id)){
            $utilisateurValide=false;
            echo"l'id est non valide : id deja existant <br>";
            }           
        }else {
            echo "id valide<br>";
            $id=  filter_var($_POST["id"],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        

        if (empty($_POST["nom"]) ){
            $utilisateurValide=false;
            echo"le nom est non valide : vide <br>";
        } else {
            echo "nom valide <br>";
            $nom=  filter_var($_POST["nom"],FILTER_SANITIZE_SPECIAL_CHARS);
        }
        
        
        if (empty($_POST["prenom"]) ){
            $utilisateurValide=false;
            echo"le prenom est non valide : vide <br>";
        } else {
            echo "prenom valide <br>";
            $prenom=  filter_var($_POST["prenom"],FILTER_SANITIZE_SPECIAL_CHARS);
        }
        
        
        if (empty($_POST["mdp"]) ){           
            $utilisateurValide=false;
            echo"le mdp est non valide : vide <br>";
        }elseif(strlen($_POST["mdp"])<5) {
            $utilisateurValide=false;
            echo"le mdp est non valide : minimum 5 caracteres <br>";
        } else {
            echo "mdp valide <br>";
            $mdp=  filter_var($_POST["mdp"],FILTER_SANITIZE_SPECIAL_CHARS);
        }
        
        if (empty($_POST["annee_naissance"])) {
            $utilisateurValide=false;
            echo"l'annee est non valide : vide<br>";
        if (!is_int(intval($_POST["annee_naissance"]))){
            $utilisateurValide=false;
            echo"l'annee est non valide : ce n'est pas un nombre entier<br>";
        }
         
        /* }elseif(filter_var($_GET["annee"], FILTER_VALIDATE_INT) !== true){
            $avionValide=false;
            echo"l'annee est non valide : ce n'est pas un nombre<br>";*/
        }elseif (intval($_POST["annee_naissance"]) > ((date('Y'))-18) || intval($_POST["annee_naissance"]) < ((date('Y'))-100) ) {
            $utilisateuValide=false;
            echo"l'annee est non valide : date impossible doit etre comprise entre 1915 et l'annee actuel<br>";
        }    
        else{
            echo "annee valide<br>";
            $annee_naissance=intval($_POST["annee_naissance"]);
        }
        
        /* -------------------------------------------------------------------------------------*/
        /* gestion du cas de l'avatar si tout est valide pour l'instant (cela evite l'upload de l'avatar dans le cas contraire)*/
        /* -------------------------------------------------------------------------------------*/
    if ($utilisateurValide==true){
        $extension_valable = array("jpg", "gif", "jpeg", "png");         
        $dossier_destination = './image/'; // à adapter selon position du fichier php
        
        // verification sur la taille !!!!!!!!!!!!!!!!!
        if (isset($_FILES['image'])) {
            if (empty($_FILES['image']["type"])) {
                echo "/!\ avatar non valide : vous n'avez pas selectionne de fichier <br><br>";
                $utilisateurValide=false;
            } else {
                $extension = pathinfo($_FILES['image']["name"], PATHINFO_EXTENSION);
                echo ("extension du fichier : " . $extension . "<br>");
                if (in_array($extension, $extension_valable)) {
                    //on done un nom unique à l'image
                    $_FILES['image']["name"] = uniqid('avatar_') . "." . $extension;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $dossier_destination . $_FILES['image']["name"])) {
                        echo "l'avatar est valide<br>" ;
                        echo "l'avatar a bien ete uploade dans le dossier du serveur<br> <br>";
                                                
                        $image= $_FILES['image']["name"]; // nom de l'image avec l'extension
                        
                        echo ('<img src=' . $dossier_destination . $_FILES['image']['name'] . ' " height="50" width="100" ">' );
                        echo "<br><br>";
                    } else {
                        echo "/!\ erreur : l'image de l'avatar n a pas pu etre deplacee sur le serveur <br>";
                        $utilisateurValide=false;
                    }
                } else {
                    echo "/!\ avatar non valide : extension non valide <br>";
                    $utilisateurValide=false;
                }
            }
        } else {
            echo "/!\ erreur : les variables n'existe pas <br>";
            $utilisateurValide=false;
        }
    }
    
    $cagnote=0;
    
    if ($utilisateurValide==true){
            $requete="insert into UTILISATEUR values (\"$nom\", \"$prenom\",$annee_naissance, \"$id\",\"$mdp\",\"$image\", $cagnote)";
            $resultat=  mysqli_query($database, $requete);
            if ($resultat){
                echo"OK, inclusion dans la base de donnee<br>";
            }else{
                echo"KO, erreur<br>";
                echo(mysqli_error($database));
            }
    }
} else {

}        
?>

<html>
    <head>       
        <meta charset="UTF-8"> 
            <?php /* penser à Bien completer le HEAD à chaque fois */ ?>
    </head>
    <body>
           <h1>INSCRIPTION</h1>
           
           <form method="post" action="formulaire_inscription.php" enctype="multipart/form-data">
            
               
            <label> nom :</label>
            <input type ='text' name="nom" value=""/>
            <p/>
            
            <label> prenom :</label>
            <input type ='text' name="prenom" value=""/>
            <p/>
            
            <label> annee de naissance :</label>
            <input type ='text' name="annee_naissance" value=""/>
            <p/>
            
            <label> identifiant :</label>
            <input type ='text' name="id" value=""/>
            <p/>
            
            <label> mot de passe :</label>
            <input type ='password' name="mdp" value=""/>
            <p/>
            
            <label> Choisissez un avatar : </label>
            <input type="file" name="image" >             
            <p/>
            
              <input type="submit" value ="soumettre"/>
              <input type="reset" value="annuler"/>
           </form>
           <p> <a href="../tp02/tp02_exo2.html"> retour à l'acceuil </a> </p>
    </body>
</html>


