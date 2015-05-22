<?php  
include('page_authentification_action.php');
?>

<html>
    <head>       
        <meta charset="UTF-8"> 
            <?php /* penser à Bien completer le HEAD à chaque fois */ ?>
    </head>
    <body>
           <h1>AUTHENTIFICATION</h1>
           
           <form method="post" action="page_authentification_form.php" >
            
            
            <label> identifiant :</label>
            <input type ='text' name="id" value="" />
            <p/>
            
            <label> mot de passe :</label>
            <input type ='password' name="mdp" value=""/>
            <p/>
            
              <input type="submit" value ="soumettre"/>
              <input type="reset" value="annuler"/>
           </form>
           <p> <a href="formulaire_inscription_form.php"> inscription </a> </p>
    </body>
</html>

