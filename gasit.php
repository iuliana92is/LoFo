        <?php
            $titlu = "Gasite";
            include "header.php";

            // paginarea anunturilor 
            // afisarea lor va fi facuta in numar de cate 10//
            // la depasirea limitei de 10 anunturi se va adauga o pagina noua ce va fi pupulata cu urmatoarele minim 10 anunturi
            $conexiune = $GLOBALS['conexiune'];
            $pagina = isset($_GET['pagina']) && $_GET['pagina'] ? $_GET['pagina'] : 1;
            $anunturiPePagina = 10; 
            $tip = 'gasit';
            $sql = "select an.*, ut.utilizator, ut.email, ut.telefon from anunturi an join utilizatori ut on ut.id = an.utilizator  where tip = ?";
            $query = $conexiune->prepare($sql);
            $query->bind_param('s', $tip);
            $query->execute();

            $rezultat = $query->get_result();
            
            // zona de cautare avansata
            // se poate realiza prin completarea spatiilor definite si la sfarsit prin apasarea butonului "search"
            $arrAnunturi = array();
            while($rand = $rezultat->fetch_assoc()) {
                $cautare = true;

                if(isset($_GET['categorie']) && $_GET['categorie'] != $rand['categorie']) {
                    $cautare = false;
                }

                if(isset($_GET['zona']) && $_GET['zona'] != $rand['zona']) {
                    $cautare = false;
                }

                if(isset($_GET['culoare']) && $_GET['culoare'] != $rand['culoare']) {
                    $cautare = false;
                }

                if(isset($_GET['stare']) && $_GET['stare'] != $rand['stare']) {
                    $cautare = false;
                }

                if($cautare) {
                    $arrAnunturi[] = $rand;
                }
            }

            $nrPagini = ceil(count($arrAnunturi) / $anunturiPePagina);
            $arrAnunturi = array_slice($arrAnunturi, ($pagina - 1) * $anunturiPePagina, $anunturiPePagina);
        ?>

        <!-- realizarea unui modal care se deschide atunci cand apasam pe butonul de stergere anunt -->
        <div id="modalSterge" class="hidden">
            <input type="hidden" id="idAnuntStergere"/>
            <div id="inchideModal" onclick="inchidereModalStergere()">
                <img src="assets/images/icons/close.png">
            </div>
            <h1> Esti sigur ca vrei sa stergi ?</h1> 
            <div id="butoaneModal">
                <button name="daSterge" value="yes" class="daSterge" onclick="confirmareStegere()">DA</button>
                <button name="nuSterge" value="no" class="nuSterge" onclick="inchidereModalStergere()">NU</button>
            </div>
        </div>

        <!-- realizarea unui modal care se deschide atunci cand apasam pe butonul de raportare a unei fraude pe un anumit anunt -->
        <div id="modalFrauda" class="hidden">
            <input type="hidden" id="idAnuntFrauda"/>
            <div id="inchideModal"onclick="inchidereModalFrauda()">
                <img src="assets/images/icons/close.png">
            </div>
            <h1> Raporteaza o frauda</h1> 
            <form class="dateModalAnunt">
                <input type="text" placeholder="nume" id="numeFrauda"/>
                <input type="text" placeholder="email" id="emailFrauda"/>  
                <textarea placeholder="Descriere" id="descriereFrauda"></textarea>
            </form>
            <div id="butoaneModal">
                <button name="daTrimite" value="yes" class="daTrimite" onclick="trimiteRaportFrauda()">trimite</button>
                <button name="nuRenunta" value="no" class="nuRenunta" onclick="inchidereModalFrauda()">renunta</button>
            </div>
        </div>

      <!--   zona de cautare avansata
        se poate realiza prin completarea spatiilor definite si la sfarsit prin apasarea butonului "search" -->
        <section class="filterBar">
            <h1>Cautare rapida</h1>
            <form method="GET">
                <select class="categorie" name="categorie">
                    <option disabled="" selected="" value="0">Categorie</option>
                    <?php foreach($GLOBALS['categorii'] as $categorie) { ?>
                        <option value="<?php echo $categorie ?>" <?php echo isset($_GET['categorie']) && $_GET['categorie'] == $categorie ? 'selected="selected"' : ''  ?>><?php echo $categorie ?></option>
                    <?php } ?>
                </select>
                <select class="zona" name="zona">
                    <option disabled="" selected="" value="0">Zona</option>
                    <?php foreach($GLOBALS['zone'] as $zona) { ?>
                        <option value="<?php echo $zona ?>"  <?php echo isset($_GET['zona']) && $_GET['zona'] == $zona ? 'selected="selected"' : ''  ?>><?php echo $zona ?></option>
                    <?php } ?>
                </select>
                <select class="culoare" name="culoare">
                    <option disabled="" selected="" value="0">Culoare</option>
                    <?php foreach($GLOBALS['culori'] as $culoare) { ?>
                        <option value="<?php echo $culoare ?>" <?php echo isset($_GET['culoare']) && $_GET['culoare'] == $culoare ? 'selected="selected"' : ''  ?>><?php echo $culoare ?></option>
                    <?php } ?>
                </select>
                <select class="stare" name="stare">
                    <option disabled="" selected="" value="0">Stare</option>
                    <?php foreach($GLOBALS['stari'] as $stare) { ?>
                        <option value="<?php echo $stare ?>" <?php echo isset($_GET['stare']) && $_GET['stare'] == $stare ? 'selected="selected"' : ''  ?>><?php echo $stare ?></option>
                    <?php } ?>
                </select>
                <button class="search">search</button>
            </form>
        </section>

        <!-- doar in cazul in care un user este autentificat se poate realiza functionalitatea de adaugare a unui nou anunt
        se vor completa campurile predefinite adaugarii unui anunt GASIT-->
        <?php if($_SESSION['logat']) { ?>
            <form id="formFound" method="POST" action="" onsubmit="return adaugareAnunt('gasit');" name="myForm" >
                <div id="formFoundField">
                <h1>Am gasit ceva! <br/>Adaug acum un anunt!</h1>
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
                    <input type="text" placeholder="Nume"id="addNume"  />
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
                    <br/>
                    <div class="clearfix"></div>
                    <div class="upload">
                        <input type="file" name="upload" id="addUpload"/>
                    </div>
                    <br/>
                    <div class="clearfix"></div>
                    <textarea  placeholder="Descriere" id="addDescriere"></textarea>
                    <br/>
                    <div class="clearfix"></div>
                    <button type="submit" class="btn-send">Adauga</button>
                    <button type="reset" class="btn-cancel">renunta</button>
                </div>
            </form>
        <?php } ?>
        
        <!-- tabelul anunturilor gasite  
        se vor completa campurile cu datele caracteristice acestora pentru adaugarea unui nou anunt-->
        <article class="toateAnunturi">
            <h1>Anunturile cu obiectele gasite</h1>
            <section id="toateAnunturi">
                <div class="tot">
                    <ul>
                        <li id="id">id</li>
                        <li id="categorie-toate">categorie</li>
                        <li id="zona-toate">zona</li>
                        <li id="perioada-toate">data</li>
                        <li id="recompensa-toate">obiect/animal</li>
                        <li id="detalii-toate"> detalii</li>
                    </ul>
                </div>
                <div class="clearfix"></div>
                <div class="listaObiecte">
                    <?php foreach($arrAnunturi as $anunt) { ?>
                    <div class="rand">
                        <ul>
                        <li class="id" ><?php echo $anunt['id'] ?> </li>
                        <li class="categorie" ><?php echo $anunt['categorie'] ?> </li>
                        <li class="zona"> <?php echo $anunt['zona'] ?> </li>
                        <li class="dataPublicarii" > <?php echo $anunt['data_adaugarii'] ?> </li>
                        <li class="obiect/animal" ><?php echo $anunt['nume'] ?></li>
                        <li class="detalii"> 
                            <img src="assets/images/icons/down.png" alt="down arrow" onclick="vizualizareDetalii()"/>
                            <img src="assets/images/icons/frauda.png" alt="raporteaza frauda" onclick="deschideModalFrauda(<?php echo $anunt['id'] ?>)"/>
                            <?php if($_SESSION['logat'] && $_SESSION['admin']) { ?>
                                <img src="assets/images/icons/sterge.png" alt="stergere" onclick="deschideModalStergere(<?php echo $anunt['id'] ?>)"/>
                            <?php } ?>
                        </li>
                    </ul>
                    <!-- details informations -->
                    <div class="clearfix"></div>
                    <div class="infoText hidden">
                        <div class="infoTextObiect">
                            <div class="leftText">
                                <p>culoare: </p>
                            </div>
                            <div class="rightText">
                                <p><?php echo $anunt['culoare'] ?></p>
                            </div>
                            <div class="clearfix"></div>
                            <div class="leftText">
                                <p>stare: </p>
                            </div>
                            <div class="rightText">
                                <p><?php echo $anunt['stare'] ?></p>
                            </div>
                            <div class="clearfix"></div>
                            <div class="leftText">
                                <p>utilizator: </p>
                            </div>
                            <div class="rightText">
                                <p><?php echo $anunt['utilizator'] ?></p>
                            </div>
                            <div class="clearfix"></div>
                            <div class="leftText">
                                <p>email: </p>
                            </div>
                            <div class="rightText">
                                <p><?php echo $anunt['email'] ?></p>
                            </div>
                            <div class="clearfix"></div>
                            <div class="leftText">
                                <p>telefon: </p>
                            </div>
                            <div class="rightText">
                                <p><?php echo $anunt['telefon'] ?></p>
                            </div>
                            <div class="clearfix"></div>
                             <div class="leftText">
                                <p>detalii: </p>
                            </div>
                            <div class="rightText">
                                <p><?php echo $anunt['descriere'] ?></p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="infoTextImg">
                            <?php if($anunt['imagine']) { ?>
                            <img src="<?php echo $anunt['imagine'] ?>" alt="imagine obiect" />
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="infoTextOpen"  onclick="inchidereDetalii()">
                            <img src="assets/images/icons/up.png" alt="up arrow" /> 
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <!-- close detail informations -->
                    <hr/>
                    </div>
                    <?php } ?>
                </div>

                <!-- in functie de numarul de anunturi va fi afisata si paginarea -->
                <ul class="pagini">
                    <?php for($i = 1; $i <= $nrPagini; $i++) { ?>
                        <li <?php if($i == $pagina) echo 'class="active"' ?>><a href="?pagina=<?php echo $i ?>"><?php echo $i ?></a></li>
                    <?php } ?>
                </ul>
                <div class="clearfix"></div>

                <!-- zona de export este construita dintr-un select cu 4 tipuri 
                la actionarea butonului "export" se va realiza exportul in acel format selectat -->
                <div class="exporturi">
                    <select id="formatExport">
                        <option value="html">HTML</option>
                        <option value="csv">CSV</option>
                        <option value="json">JSON</option>
                        <option value="pdf">PDF</option>
                    </select>
                    <button class="exportAnunt" onclick="exportAnunturi('gasit')">Export</button>
                </div>
            </section>
        </article>

        <?php
            include "footer.php";
        ?>   
