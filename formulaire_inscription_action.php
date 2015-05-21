<?php

/*INCLURE LA CONNECTION A LA BASE DE DONNEE*/ 
include("connection_bd.php");
 
/* ON TEST SI LE FORMULAIRE A BIEN ETE TRANSMIS */
if (isset ($_POST["id"])){ 
        $utilisateurValide=true;
        
        
        /* recuperer l'id de de la base de donnee si on recupere rien 
         * - l'id n'existe pas dans la base => ok 
         * si on recupere quelque chose 
         * - l'id existe deja => probleme d'unicité */
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
        
        
        /* VERIFICATION DE LA JUSTESSE DE CHAQUE ELEMENT DU FORMULAIRE */
        /* - si vide 
         * - si cohérent 
         * - ne pas interpréter les balises et caractere speciaux */
        
        if (empty($_POST["id"]) ){
            $utilisateurValide=false; 
            echo"l'id est non valide : vide <br>";                
        }elseif(!empty($tableau_id)){
            $utilisateurValide=false;
            echo"l'id est non valide : id deja existant <br>";        
        }else {               
                echo "id valide<br>";
                $id =  filter_var($_POST["id"],FILTER_SANITIZE_SPECIAL_CHARS);
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
        }elseif (!is_int($_POST["annee_naissance"])){
            $utilisateurValide=false;
            echo"l'annee est non valide : ce n'est pas un nombre entier<br>";              
        }elseif (intval($_POST["annee_naissance"]) > ((date('Y'))-18) || intval($_POST["annee_naissance"]) < ((date('Y'))-100) ) {
            $utilisateurValide=false;
            echo"l'annee est non valide : date impossible doit etre comprise entre ". (date('Y')-100) ." et l'annee actuel<br>";
        }else{
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
                    if ($_FILES['image']['size'] < 100000){ //taille max en octets = 100 Ko
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
                    }else{
                        echo "/!\ avatar non valide : taille max 100 Ko depassé<br>";
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
    $id_voiture=null;
    
    if ($utilisateurValide==true){
            $requete="insert into UTILISATEUR values (\"$nom\", \"$prenom\",$annee_naissance, \"$id\",\"$mdp\",\"$image\", $cagnote, NULL)";
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

mysqli_close($database);

?>




