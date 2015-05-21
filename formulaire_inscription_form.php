<?php  
include('formulaire_inscription_action.php');
?>

<html>
    <head>       
        <meta charset="UTF-8"> 
            <?php /* penser à Bien completer le HEAD à chaque fois */ ?>
    </head>
    <body>
           <h1>INSCRIPTION</h1>
           
           <form method="post" action="formulaire_inscription_form.php" enctype="multipart/form-data">
            
               
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
            <input type ='text' name="id" value="" />
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
