<?php
require_once "config.php";

?>
<!DOCTYPE html>
<html lang="ro">
    <head>
        <title>Lost and Found</title>
        <meta charset="UTF-8">
        <meta name="author" content="Iuliana Ciobanu">
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <link rel='stylesheet' href="assets/css/style.css" /> 
        <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon" />
    </head>
    <body>
 
        <?php
            include "header.php";
        ?> 
        <?php
            include "ultimeleAnunturi.php";
        ?> 
        <?php
            include "vizualizateAnunturi.php";
        ?>  
        <?php
            include "footer.php";
        ?>   
        <script src="assets/js/elements.js" type="text/javascript"></script>
        <script type="text/javascript" src="assets/js/data.js"></script>
    </body>
</html>