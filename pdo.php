<!DOCTYPE html>
<html lang="en">     
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <?php
                
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
        $mySQL = 'SELECT Nom, TempPreparation, SUM(INGREDIENTS.Prix * PREPARATION.quantite) AS Prix_Recette
        FROM RECETTE 
        INNER JOIN PREPARATION ON RECETTE.id_recette = PREPARATION.id_recette
        INNER JOIN INGREDIENTS  ON PREPARATION.id_ingredients = INGREDIENTS.id_ingredients
        GROUP BY RECETTE.id_recette
        ORDER BY Prix_Recette DESC';

        $recetteStatement = $mysqlClient->prepare($mySQL);
        $recetteStatement->execute();
        $recettes = $recetteStatement->fetchAll();

        
        echo "<table>
        <tr>
            <th>Nom</th>
        </tr>";      
        
        foreach($recettes as $recette) {
            echo "<tr><td><a href='liste.php?id'>".$recette['Nom']."</a></td></tr>";
            
        }
        var_dump($recettes);
        echo "</table>";

        ?>


</body>
</html>


<!-- Dans la liste de tes recettes, 
     transformer le nom de la recette en lien <a>
     Au clic sur la recette, on affiche son détail 
     (nom, durée, description + liste des ingrédients) -->


<!-- L'objectif dans un 1er temps sera de réussir à afficher la liste des recettes (nom de la recette + temps de préparation) dans un tableau HTML classées de la recette la plus coûteuse à la moins coûteuse  -->








