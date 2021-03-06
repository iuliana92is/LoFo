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
        
    <!-- in zona de header avem un tip de meniu de navigare cu 5 butoane ce ne va redirectiona catre 5 pagini diferite
        dupa ce userul se autentifica, butonul de inregistrare se va transorma in butonul nume_user 
        ce ne va redirectiona catre pagina utilizatorului autentificat
        iar butonul de autentificare se va transforma in cel de logout ce va avea ca si scop 
        delogarea userului si retrimiterea automata catre pagina index -->
        <header>
            <section class="header-bar">
                <div class="left-side">
                    <div id="inregistrare">
                        <?php if(!$_SESSION['logat']) { ?>
                            <a href="inregistrare.php" class="inregistrare-link">inregistrare</a>
                        <?php } else { ?>
                            <a href="paginaUtilizator.php" class="inregistrare-link"><?php echo $_SESSION['utilizator'] ?> - profil</a>
                        <?php } ?>
                    </div>
                    <div id="autentificare">
                        <?php if(!$_SESSION['logat']) { ?>
                            <a href="autentificare.php" class="autentificare-link">autentificare</a>
                        <?php } else { ?>
                            <a href="logout.php" class="autentificare-link">logout</a>
                        <?php } ?>
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