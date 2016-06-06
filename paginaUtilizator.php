        <?php
            $title = "Pagina utilizator";
            include "header.php";

            //doar  in cazul autentificarii se poate ajunge la pagina de utilizator
            //butonul de redirectionare catre pagina de profil al utilizatorului este activ doar dupa ce se face autentificarea
            if(!$_SESSION['logat']) {
                //vom fi directionati catre autentificare pentru completarea campurilor specifice
                header('Location: autentificare.php');
            }


            $conexiune = $GLOBALS['conexiune'];
            $sql = "select an.*, ut.utilizator, ut.id as utilizatorId, ut.email, ut.telefon from anunturi an join utilizatori ut on ut.id = an.utilizator where ut.id = ? order by an.data_adaugarii desc";
            $query = $conexiune->prepare($sql);
            $query->bind_param('i', $_SESSION['idUtilizator']);
            $query->execute();

            $rezultat = $query->get_result();
            
            $arrAnunturi = array();
            while($rand = $rezultat->fetch_assoc()) {
                $arrAnunturi[] = $rand;
            }
        ?> 
        
       <!--  pentru editarea unui anunt ce apartine utilizatorului autentificat se va apasa butonul de editare
        acesta poate modifica datele introduse in momentul in care a dorit sa adauge un nou anunt
        modalul se va deschide doar la apasarea butoului de editare
        noile date completate le vor suprascrie pe cele vechi -->
        <div id="modalAnunt"  class="hidden" >
            <div id="inchideModal" onclick="inchidereModalAnunt()">
                <img src="assets/images/icons/close.png">
            </div>
            <h1>Nume anunt</h1>
            <form class="dateModalAnunt">
                <input type="hidden" id="addIdAnunt"/>
                <select class="categorie" id="addCategorie">
                    <option disabled="" selected="" value="0">Categorie</option>
                    <?php foreach($GLOBALS['categorii'] as $categorie) { ?>
                    <option value="<?php echo $categorie ?>"><?php echo $categorie ?></option>
                    <?php } ?>
                </select> 
                <select class="zona" id="addZona">
                    <option disabled="" selected="" value="0">Zona</option>
                    <?php foreach($GLOBALS['zone'] as $zona) { ?>
                        <option value="<?php echo $zona ?>"><?php echo $zona ?></option>
                    <?php } ?>
                </select>
                <input type="text" placeholder="nume" id="addNume"/>
                <select class="culoare" id="addCuloare">
                    <option disabled="" selected="" value="0">Culoare</option>
                    <?php foreach($GLOBALS['culori'] as $culoare) { ?>
                    <option value="<?php echo $culoare ?>"><?php echo $culoare ?></option>
                <?php } ?>
                </select>
                <select class="stare" id="addStare">
                    <option disabled="" selected="" value="0">Stare</option>
                    <?php foreach($GLOBALS['stari'] as $stare) { ?>
                    <option value="<?php echo $stare ?>"><?php echo $stare ?></option>
                    <?php } ?>
                </select>
                <div class="upload">
                    <input type="file" name="upload" id="addUpload"/>
                </div>
                <textarea placeholder="Descriere" id="addDescriere"></textarea>
                <br/>
                </br>
                <div id="butoaneModal">
                    <button id="salveazaEditare" value="Send" class="salveazaEditare" onclick="modificareAnunt()">Salveaza editarea</button>
                    <button  type="reset" id="anuleazaEditare" value="Cancel" class="anuleazaEditare">Reseteaza campuri</button>
                </div>
            </form>
        </div>

        <!-- realizarea unui modal care se deschide atunci cand apasam pe butonul de stergere anunt -->
        <div id="modalSterge" class="hidden">
            <input type="hidden" id="idAnuntStergere"/>
            <input type="hidden" id="utilizatorAnuntStergere"/>
            <div id="inchideModal" onclick="inchidereModalStergere()">
                <img src="assets/images/icons/close.png">
            </div>
            <h1> Esti sigur ca vrei sa stergi ?</h1> 
            <div id="butoaneModal">
                <button name="daSterge" value="yes" class="daSterge" onclick="confirmareStegere()">DA</button>
                <button name="nuSterge" value="no" class="nuSterge" onclick="inchidereModalStergere()">NU</button>
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

            <!-- zona anunturilor create de utilizatorul autentificat
            el va avea ca si optiuni: vizualizarea anuntului, editarea si stergerea acestuia -->
            <section id="anunturiUtilizator">
                <?php foreach($arrAnunturi as $anunt) { ?>
                    <ul class="infoAnunt">
                         <li class="anuntInfos anuntulMeu">#<?php echo $anunt['id'] . ' ' . $anunt['nume'] ?></li>
                         <li class="anuntInfos editareAnunt" onclick="deschideModalAnunt('editare', '<?php echo $anunt['id'] ?>', '<?php echo $anunt['categorie'] ?>', '<?php echo $anunt['zona'] ?>', '<?php echo $anunt['nume'] ?>', '<?php echo $anunt['culoare'] ?>', '<?php echo $anunt['stare'] ?>', '<?php echo $anunt['descriere'] ?>')">editare</li>
                         <li class="anuntInfos eliminareAnunt" onclick="deschideModalStergere(<?php echo $anunt['id'] ?>, <?php echo $anunt['utilizatorId'] ?>)">eliminare</li> 
                         <li class="anuntInfos vizualizareAnunt" onclick="deschideModalAnunt('vizualizare', '<?php echo $anunt['id'] ?>', '<?php echo $anunt['categorie'] ?>', '<?php echo $anunt['zona'] ?>', '<?php echo $anunt['nume'] ?>', '<?php echo $anunt['culoare'] ?>', '<?php echo $anunt['stare'] ?>', '<?php echo $anunt['descriere'] ?>')">vizualizare</li>
                     </ul> 
                     <div class="clearfix"></div>
                 <?php } ?>
            </section> 
            <div class="clearfix"></div>
        </article>
        <div class="clearfix"></div>
      
        <?php
            include "footer.php";
        ?> 