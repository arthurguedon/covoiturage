<?php
include('tableaux_generique.php');
include('formulaire_dynamique.php');
?>

<html>
    <head>
        <title>Formulaire de proposition de trajets</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <form method="post" action="proposer_trajet_form.php">
            <h1>Formulaire</h1>

            <label> Ville de depart :</label>
            <input type ='text' name="ville_depart" value="" placeholder="Entrer une ville de depart"/>
            <p/>
            <label> Ville d'arrivee :</label>
            <input type ='text' name="ville_arrivee" value="" />
            <p/>
            <label> Date :</label>
            <?php
            select_dynamique("jour", listeJours());
            select_dynamique("mois", listeMois());
            select_dynamique("annee", listeAnnees());
            ?>
            <p/>
            <p/>
            <label> Heure :</label>
            <?php
            select_dynamique("heure", listeHeures()); echo ' h ';
            select_dynamique("minute", listeMinutes()); echo' min';
            ?>
            <p/>
            <label> Nombre de passagers :</label>
            <input type ='number' name="nb_place" value=""/>
            <p/>
            <label> Prix demandé par passager :</label>
            <input type ='number' name="prix" value=""/>
            <p/>
            <input type="submit" value ="Proposer trajet"/>
            <input type="reset" value="annuler"/>
        </form>
    </body>
</html>

<?php include('proposer_trajet_action.php');
?>
