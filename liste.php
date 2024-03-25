<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php

        // $id = (isset($_GET['action'])) ? ($_GET['action']) : null;
        
        if(isset($_GET['id'])) {
            
            $id = $_GET['id'];

            try
            {
                // On se connecte à MySQL
                $mysqlClient = new PDO('mysql:host=localhost;dbname=Recettes1;charset=utf8', 'root', 'root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
            );
                $mysqlClient1 = new PDO('mysql:host=localhost;dbname=Recettes1;charset=utf8', 'root', 'root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
            );
            
            }
            catch (Exception $e)
            {   
                // En cas d'erreur, on affiche un message et on arrête tout 
                die('Erreur : ' . $e->getMessage());
            }

            $mySQL = 'SELECT Nom, TempPreparation, Instructions
            FROM RECETTE WHERE id_recette = :id';

            $recetteStatement = $mysqlClient->prepare($mySQL);
            $recetteStatement->execute(["id" => $id]);
            $recette = $recetteStatement->fetch();

            // 2e requete qui affiche les ingredients d'une recette (nom des ingredients + prix + quantité)
            // prepare / execute id => $id
            // fetchAll

            $mySQL1 = 'SELECT NomIngredient, Prix, PREPARATION.quantite
            FROM RECETTE 
            INNER JOIN PREPARATION ON RECETTE.id_recette = PREPARATION.id_recette
            INNER JOIN INGREDIENTS ON PREPARATION.id_ingredients = INGREDIENTS.id_ingredients
            WHERE id_recette = :id';    
            
            $recetteStatement1 = $mysqlClient1->prepare($mySQL1);
            $recetteStatement1->execute(["id" => $id]);
            $recette1 = $recetteStatement1->fetchAll();

            echo "<table>
                <tr>
                    <th>Nom</th>
                    <th>TempPreparation</th>
                    <th>Instructions</th>
                </tr>";      
            echo "<tr><td>".$recette['Nom']."</td></tr>",
                "<tr><td>".$recette['TempPreparation']."</td></tr>",
                "<tr><td>".$recette['Instructions']."</td></tr>";

            foreach ($recette1 as $recette) {
                echo "<tr><td>".$recette['NomIngredient']."</tr></td>",
                "<tr><td>".$recette['Prix']."</tr></td>",
                "<tr><td>".$recette['PREPARATION.quantite']."</tr></td>";
            }   

            echo "</table>";

        } else {
            echo "Pas de contenu\n";
        }

    ?>
    
<!-- 
    SELECT Nom, TempPreparation, Instructions, INGREDIENTS.NomIngredient
            FROM RECETTE 
            INNER JOIN PREPARATION ON RECETTE.id_recette = PREPARATION.id_recette
            INNER JOIN INGREDIENTS ON PREPARATION.id_ingredients = INGREDIENTS.id_ingredients
            WHERE id_recette LIMIT 1' -->
</body>
</html>