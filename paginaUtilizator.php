        <?php
            $title = "Pagina utilizator";
            include "header.php";

            //doar  in cazul autentificarii se poate ajunge la pagina de utilizator
            //butonul de redirectionare catre pagina de profil al utilizatorului este activ doar dupa ce se face autentificarea
            if(!$_SESSION['logat']) {
                //vom fi directionati catre autentificare pentru completarea campurilor specifice
                header('Location: autentificare.php');
            }
        ?> 
        
       <!--  pentru editarea unui anunt ce apartine utilizatorului autentificat se va apasa butonul de editare
        acesta poate modifica datele introduse in momentul in care a dorit sa adauge un nou anunt
        modalul se va deschide doar la apasarea butoului de editare
        noile date completate le vor suprascrie pe cele vechi -->
        <div id="modalAnunt"  class="hidden" >
            <div id="inchideModal"onclick="inchidereModal()">
                <img src="assets/images/icons/close.png">
            </div>
            <h1>Nume anunt</h1>
            <form class="dateModalAnunt">
                <select class="categorie">
                    <option disabled="" selected="">Categorie</option>
                    <option>Animale</option>
                    <option>Obiecte</option>
                </select> 
                <select class="zona">
                    <option disabled="" selected="">Zona</option>
                    <option>Pacurari</option>
                    <option>Dacia</option> 
                    <option>Valea lupului</option>
                </select>
                <input type="text" placeholder="nume"/>
                 <select class="culoare">
                    <option disabled="" selected="">Culoare</option>
                    <option> Rosu</option>
                    <option> Galben</option> 
                </select>
                   <select class="stare">
                    <option disabled="" selected="">Stare</option>
                    <option>Buna</option>
                    <option>Deteriorat</option>
                </select>
                <div class="upload">
                    <input type="file" name="upload"/> 
                </div>
                <textarea placeholder="Descriere"></textarea>
            </form>
            <br/>
            </br>
            <div id="butoaneModal">
                <button name="salveazaEditare" value="Send" class="salveazaEditare"  >Salveaza editarea</button>
                <button name="anuleazaEditare" value="Cancel" class="anuleazaEditare" >Reseteaza campuri</button>
            </div>
        </div>

        <!-- zona alocata datelor userului autentificat
        se vor prelua datele din baza de date si vor fi afisate la profilul acestuia in campurile predefinite -->
        <article class="user">
            <h1>Nume User:</h1>

            <div class="informatiileMele">
                <p>Informatiile Mele:</p>
            </div> 
            <br /> 
            <section id="infoMele"> 
            <br /> 
                <form  class="infoMele"> 
                    <label>Nume:</label>
                    <input type="text" value="<?php echo $_SESSION['utilizator'] ?>" readonly /> 
                    <div class="clearfix"></div>
                    <br /> 
                    <label> Adesa e-mail:</label>
                    <input type="text" value="<?php echo $_SESSION['email'] ?>" readonly />
                    <div class="clearfix"></div>
                    <br /> 
                    <label>Telefon:</label>
                    <input type="text" value="<?php echo $_SESSION['telefon'] ?>" readonly />
                    <div class="clearfix"></div>
                    <br /> 
                </form>
                 
            </section>  
            <br /> 
            <br /> 
            <br /> 
            <div class="listaPostari">
                <p>Lista anunturilor postate de mine:</p>
            </div>
            <br />

            zona anunturilor create de utilizatorul autentificat
            el va avea ca si optiuni: vizualizarea anuntului, editarea si stergerea acestuia
            <section id="anunturiUtilizator"> 
                <ul class="infoAnunt">
                     <li class="  anuntInfos anuntulMeu"> nume anunt 1</li>
                     <li class="  anuntInfos editareAnunt">editare</li>
                     <li class="  anuntInfos eliminareAnunt">eliminare</li> 
                     <li class="  anuntInfos vizualizareAnunt">vizualizare</li>
                 </ul> 
                 <div class="clearfix"></div>
                  <ul class="infoAnunt">
                    <li class="  anuntInfos anuntulMeu">nume anunt 2</li>
                     <li class="  anuntInfos editareAnunt">editare</li>
                     <li class="  anuntInfos eliminareAnunt">eliminare</li> 
                     <li class="  anuntInfos vizualizareAnunt">vizualizare</li>
                 </ul> 
                 <div class="clearfix"></div>
                  <ul class="infoAnunt">
                     <li class="  anuntInfos anuntulMeu">nume anunt 3</li>
                     <li class="  anuntInfos editareAnunt">editare</li>
                     <li class="  anuntInfos eliminareAnunt">eliminare</li> 
                     <li class="  anuntInfos vizualizareAnunt">vizualizare</li>
                 </ul>
                 <div class="clearfix"></div>
            </section> 
            <div class="clearfix"></div>
        </article>
        <div class="clearfix"></div>
      
        <?php
            include "footer.php";
        ?> 