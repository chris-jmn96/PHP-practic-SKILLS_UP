<?php
require "../modules/require/config.php";
htmlspecialchars($_SERVER['PHP_SELF']);
$_SERVER['REQUEST_METHOD'] == NULL;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usarios Inscritos</title>
    <!-- <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/normalize.css"> -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main>
        <?php if($_SERVER['REQUEST_METHOD'] === 'GET') : ?>
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                <button type="submit" name="mostrarInscritos">ENVIAR</button>
            </form>
            <?php else : ?>
                <?php
                    //require __DIR__. '/inc/post.php';
                    $sql = "SELECT * FROM news_reg";
                    $stmt = $conn->prepare($sql);
                    $stmt -> execute();

                    if ($result = $stmt->setFetchMode(PDO::FETCH_ASSOC)){
                        echo '<table>
                        <thead>
                        <tr>
                        <th>NOMBRE</th>
                        <th>EMAIL</th>
                        <th>TELEFONO</th>
                        <th>DOMICILIO</th>
                        <th>CIUDAD</th>
                        <th>PROVINCIA</th>
                        <th>CÓDIGO POSTAL</th>
                        <th>NEWSLETTER</th>
                        <th>NEWS</th>
                        <th>SUGGESTION</th>
                        </tr>
                        </thead>';

                        foreach(($rows = $stmt->fetchAll()) as $row){
                            echo "<tr>
                            <td>".$row["fullname"]."</td>
                            <td>".$row["email"]."</td>
                            <td>".$row["phone"]."</td>
                            <td>".$row["address"]."</td>
                            <td>".$row["city"]."</td>
                            <td>".$row["state"]."</td>
                            <td>".$row["zipcode"]."</td>
                            <td>".$row["newsletters"]."</td>
                            <td>".$row["format_news"]."</td>
                            <td>".$row["suggestion"]."</td>
                            </tr>";
                        }
                        echo '</tr>
                        </table>';           
                    }else{
                        echo "<p>0 results, no found data</p><br>";
                    }
                    $conn = null;
                ?>
            <?php endif ?>
    </main> 
</body>
</html>