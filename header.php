<?php
    require_once "config.php";
?>
<!DOCTYPE html>
<html lang="ro">
    <head>
        <title> <?php echo isset($title) && $title ? $title . " - " : "" ?> Lost and Found</title>
        <meta charset="UTF-8">
        <meta name="author" content="Iuliana Ciobanu">
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' /> 
        <link rel='stylesheet' href="assets/css/style.css" /> 
        <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon" />
    </head>
    <body>
        <header>
            <section class="header-bar">
                <div class="left-side">
                    <div id="inregistrare"> 
                            <a href="inregistrare.php" class="inregistrare-link">inregistrare</a>  
                       
                    </div>
                    <div id="autentificare"> 
                            <a href="autentificare.php" class="autentificare-link">autentificare</a>  
                        
                    </div>
                </div>
                <div class="logo">
                    <a href="index.php"><img src="assets/images/logo.png" alt="logo" /> </a> 
                </div>
                <div class="right-side">
                    <div id="gasit">
                        <a href="gasit.php" class="gasit-link">gasit</a>
                    </div>
                    <div id="pierdut">
                        <a href="pierdut.php" class="pierdut-link">pierdut</a>
                    </div>
                </div>
            </section>
            <div class="clearfix"></div>
            <div class="slider"> 
            </div>
        </header>