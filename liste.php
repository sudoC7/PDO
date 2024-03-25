<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php

        $id = (isset($_GET['id'])) ? ($_GET['id']) : null;
                
        try
        {
            // On se connecte à MySQL
            $mysqlClient = new PDO('mysql:host=localhost;dbname=Recettes1;charset=utf8', 'root', 'root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
        );
        }
        catch (Exception $e)
        {   
            // En cas d'erreur, on affiche un message et on arrête tout 
            die('Erreur : ' . $e->getMessage());
        }
        // Si tout va bien, on peut continuer

        // On récupère tout le contenu de la table RECETTE
        $mySQL = 'SELECT Nom, TempPreparation, Instructions, INGREDIENTS.NomIngredient
        FROM RECETTE 
        INNER JOIN PREPARATION ON RECETTE.id_recette = PREPARATION.id_recette
        INNER JOIN INGREDIENTS ON PREPARATION.id_ingredients = INGREDIENTS.id_ingredients
        WHERE Nom = "" LIMIT 1';

        $recetteStatement = $mysqlClient->prepare($mySQL);
        $recetteStatement->execute();
        $recettes = $recetteStatement->fetchAll();

        echo "<table>
        <tr>
            <th>Nom</th>
            <th>TempPreparation</th>
            <th>Instructions</th>
            <th>NomIngredient</th>
         </tr>";      

        foreach($recettes as $recette) {
            echo "<tr><td><a href='liste.php?Nom'>".$recette['Nom']."</a></td></tr>";
            echo "<tr><td><a href='liste.php'>".$recette['TempPreparation']."</a></td></tr>";
            echo "<tr><td><a href='liste.php'>".$recette['Instructions']."</a></td></tr>";
            echo "<tr><td><a href='liste.php'>".$recette['NomIngredient']."</a></td></tr>";
        }
        echo "</table>";

    ?>
    
</body>
</html>