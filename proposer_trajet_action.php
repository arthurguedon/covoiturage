<?php

if (isset($_POST["ville_depart"])) {
    $trajetValide = true;

    //HEURE ET DATE
    echo 'Date et Heure:';
    $heureValide = true;
    if (checkdate($_POST["mois"], $_POST["jour"], $_POST["annee"])) {
        if (($_POST["annee"] - date('Y')) > 0) {
            //on fait rien
        } elseif (($_POST["annee"] - date('Y')) < 0) {
            $heureValide = false;
            $trajetValide = false;
            echo'probleme';
        } elseif (($_POST["annee"] - date('Y')) == 0) {
            if (($_POST["mois"] - date('m')) > 0) {
                //on fait rien
            } elseif (($_POST["mois"] - date('m')) < 0) {
                $heureValide = false;
                $trajetValide = false;
                echo'probleme';
            } elseif (($_POST["mois"] - date('m')) == 0) {
                if (($_POST["jour"] - date('d')) > 0) {
                    //on fait rien
                } elseif (($_POST["jour"] - date('d')) < 0) {
                    $heureValide = false;
                    $trajetValide = false;
                    echo'probleme';
                } elseif (($_POST["jour"] - date('d')) == 0) {
                    if (($_POST["heure"] - date('H')) > 0) {
                        //on fait rien
                    } elseif (($_POST["heure"] - date('h')) < 0) {
                        $heureValide = false;
                        $trajetValide = false;
                        echo'probleme';
                    } elseif (($_POST["heure"] - date('h')) == 0) {
                        echo 'tu te fou de ma gueule';
                    }
                }
            }
        }
    } else {
        $heureValide = false;
    }

    if ($heureValide == true) {
        $date = $_POST["jour"] . "/" . $_POST["mois"] . "/" . $_POST["annee"];
        $heure = $_POST["heure"] . ":" . $_POST["minute"];
        echo $heure . "<br>";
        echo $date . "<br>";
    }



//PASSAGER
    echo 'Passager:';
    $nb_place_max = 5;
    if (!empty($_POST["nb_place"])) {
        if (is_numeric($_POST["nb_place"])) {
            if (intval($_POST["nb_place"]) <= $nb_place_max) {
                if (intval($_POST["nb_place"]) >= 0) {

                    echo $_POST["nb_place"] . "<br>";
                    $nb_place=  filter_var($_POST["nb_place"],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                } else {
                    echo 'non valide, nombre de place nulle ou inferieur a zero  <br>';
                    $trajetValide = false;
                }
            } else {
                echo 'non valide, nombre de place maximum depassé  <br>';
                $trajetValide = false;
            }
        } else {
            echo 'non valide, vous n avez pas entre un entier  <br>';
            $trajetValide = false;
        }
    } else {
        echo 'non valide, vous n avez pas rempli le champ  <br>';
        $trajetValide = false;
    }


    //PRIX PAR PASSAGER
    echo 'Prix :';
    if (!empty($_POST["prix"])) {
        if (is_numeric($_POST["prix"])) {

            echo $_POST["prix"] . "<br>";
            $prix=  filter_var($_POST["prix"],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        } else {
            echo 'non valide, vous n avez pas entre un entier  <br>';
            $trajetValide = false;
        }
    } else {
        echo 'non valide, vous n avez pas rempli le champ  <br>';
        $trajetValide = false;
    }


    //VILLE DE DEPART
    echo 'Ville de départ :';
    include("connection_bd.php");
    /* recuperer la liste des id d'utilisateur deja existant pour tester que l'id n'existe pas deja */
    $requete = "SELECT `ville_nom` FROM `villes_france_free` WHERE `ville_nom`='" . $_POST["ville_depart"] . "'";
    $resultat = mysqli_query($database, $requete);
    if ($resultat) {
        echo "OK, requete correct <br>";
        while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
            $tableau_ville_depart[] = $ligne["ville_nom"];
        }
    } else {
        echo "KO, requete incorrect<br>";
        echo(mysqli_error($database));
    }
    if (!empty($tableau_ville_depart)) {
        echo $_POST["ville_depart"] . "<br>";
        $ville_depart=  filter_var($_POST["ville_depart"],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    } else {
        echo 'non valide, votre ville n existe pas en france <br>';
        $trajetValide = false;
    }

    //VILLE D ARRIVEE
    echo 'Ville d arrivee :';
    /* recuperer la liste des id d'utilisateur deja existant pour tester que l'id n'existe pas deja */
    $requete = "SELECT `ville_nom` FROM `villes_france_free` WHERE `ville_nom`='" . $_POST["ville_arrivee"] . "'";
    $resultat = mysqli_query($database, $requete);
    if ($resultat) {
        echo "OK, requete correct <br>";
        while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
            $tableau_ville_arrivee[] = $ligne["ville_nom"];
        }
    } else {
        echo "KO, requete incorrect<br>";
        echo(mysqli_error($database));
    }
    if (!empty($tableau_ville_arrivee)) {
        echo $_POST["ville_arrivee"] . "<br>";
        $ville_arrivee=  filter_var($_POST["ville_arrivee"],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    } else {
        echo 'non valide, votre ville n existe pas en france <br>';
        $trajetValide = false;
    }


    //VERIFICATION GENERALE
    if ($trajetValide == true) {
        $sql = 'INSERT INTO trajet (id_conducteur,ville_depart,ville_arrivee,date,heure,prix,nb_place) VALUES ("abg", "' . $ville_depart . '","'
               . $ville_arrivee . '","' . $date . '","' . $heure . '",' . $prix . ',' . $nb_place . ')';
       //$sql=' INSERT INTO trajet (id_conducteur,ville_depart,ville_arrivee,date,heure,prix,nb_place) VALUES ("abg","Troyes","Reims","05/06/2015","20:10",10,2)';
// on insere le tuple (mysql_query) et au cas où, on écrira un petit message d'erreur si la requête ne se passe pas bien (or die)
        mysqli_query($database, $sql) or die('Erreur SQL !' . $sql . '<br />' . mysqli_error($database));
       
// on ferme la connexion à la base
        mysqli_close($database);

       echo $_POST["ville_depart"] . ' - '.$_POST["ville_arrivee"].' vient d etre insérer dans la base.';
    }
}
?>
