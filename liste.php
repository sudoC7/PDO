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
                // L'objet PDO 
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
            // 1e requête pour afficher le nom temps et instructions du tableau 
            $mySQL = 'SELECT Nom, TempPreparation, Instructions
            FROM RECETTE WHERE id_recette = :id';   // id => $id : contient les id_recette

            $recetteStatement = $mysqlClient->prepare($mySQL); 
            $recetteStatement->execute(["id" => $id]);
            $recette = $recetteStatement->fetch();
            //La méthode fetch() simple est utilisé pour récuperer la prochaine ligne de résultats d'une requête 

            // 2e requete qui affiche les ingredients d'une recette (nom des ingredients + prix + quantité)
            // prepare / execute id => $id
            // fetchAll

            // 2e requete pour afficher les ingredients, prix u tableau INGREDIENT + prix du tableau PREPARATION daans le tableau RECETTE
            $mySQL1 = 'SELECT NomIngredient, Prix, PREPARATION.quantite
            FROM RECETTE 
            INNER JOIN PREPARATION ON RECETTE.id_recette = PREPARATION.id_recette
            INNER JOIN INGREDIENTS ON PREPARATION.id_ingredients = INGREDIENTS.id_ingredients
            WHERE RECETTE.id_recette = :id'; // id => $id : contient de même les id_recette   
            

            //La méthode prepare() prendre en 'paramètre' et 'prépare' la variable '$mySQL1' dans le quel on a stocké la 'requête'
            $recetteStatement1 = $mysqlClient1->prepare($mySQL1); // une requete préparé avec la méthode prepare() de l'objet mysqlClient1, cet objet de requête est stocké dans la variable $recetteStatement1 
            $recetteStatement1->execute(["id" => $id]); // Cette ligne exécute la requête préparée avec les valeurs spécifiées en paramètres, dans ce cas elle remplace :id par $id 
            $recette1 = $recetteStatement1->fetchAll(); // Cette ligne récupère toutes les lignes de résultats de la requête dans la variable $recette1
            //la methode fetchAll() récupère toutes les lignes de résultats 
            echo "<table>
                <tr>
                    <th>Nom</th>
                    <th>TempPreparation</th>
                    <th>Instructions</th>
                    <th>NomIgredient</th>
                    <th>Prix</th>
                    <th>Quantite</th>

                </tr>";     
            echo "<tr><td>".$recette['Nom']."</td>",
                "<td>".$recette['TempPreparation']."</td>",
                "<td>".$recette['Instructions']."</td>";

            foreach ($recette1 as $recette) { // Va parcourir tout le tableau et afficher le produit au quel correpond l'id_recette $recette1 
                echo "<td>".$recette['NomIngredient']."</td>",
                "<td>".$recette['Prix']."</td>",
                "<td>".$recette['quantite']."</td></tr>";
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