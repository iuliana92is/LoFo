<?php
    $titlu = "Pierdute";
    include "header.php";

    $conexiune = $GLOBALS['conexiune'];
    $pagina = isset($_GET['pagina']) && $_GET['pagina'] ? $_GET['pagina'] : 1;
    $anunturiPePagina = 2; 
    $tip = 'pierdut';
    $sql = "select an.*, ut.utilizator, ut.email, ut.telefon from anunturi an join utilizatori ut on ut.id = an.utilizator  where tip = ?";
    $query = $conexiune->prepare($sql);
    $query->bind_param('s', $tip);
    $query->execute();

    $rezultat = $query->get_result();
    
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

<div id="modalSterge" class="hidden">
    <div id="inchideModal"onclick="inchidereModal()">
        <img src="assets/images/icons/close.png">
    </div>
    <h1> Esti sigur ca vrei sa stergi ?</h1> 
    <div id="butoaneModal">
        <button name="daSterge" value="yes" class="daSterge"  >DA</button>
        <button name="nuSterge" value="no" class="nuSterge" >NU</button>
    </div>
</div>

<div id="modalFrauda" >
    <div id="inchideModal"onclick="inchidereModal()">
        <img src="assets/images/icons/close.png">
    </div>
    <h1> Raporteaza o frauda</h1> 
    <form class="dateModalAnunt">
        <input type="text" placeholder="nume"/>
        <input type="text" placeholder="email"/>  
        <textarea placeholder="Descriere"></textarea>
    </form>

    <div id="butoaneModal">
        <button name="daTrimite" value="yes" class="daTrimite"  >trimite</button>
        <button name="nuRenunta" value="no" class="nuRenunta" >renunta</button>
    </div>
</div>



<section class="filterBar">
    <h1>Cautare rapida</h1>
    <form>
        <select class="categorie">
            <option disabled="" selected="" value="0">Categorie</option>
            <?php foreach($GLOBALS['categorii'] as $categorie) { ?>
                <option value="<?php echo $categorie ?>"><?php echo $categorie ?></option>
            <?php } ?>
        </select>
        <select class="zona" name="zona">
            <option disabled="" selected="" value="0">Zona</option>
            <?php foreach($GLOBALS['zone'] as $zona) { ?>
                <option value="<?php echo $zona ?>"><?php echo $zona ?></option>
            <?php } ?>
        </select>
        <button class="search">search</button>
    </form>
</section>

<?php if($_SESSION['logat']) { ?>
    <form id="formFound" method="POST" action="" onsubmit="return adaugareAnunt('pierdut');" name="myForm" >
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

<article class="toateAnunturi">
    <h1>Anunturile cu obiectele pierdute</h1>
    <section id="toateAnunturi">
        <div class="tot">
            <ul>
                <li id="id">ID</li>
                <li id="categorie-toate">categorie</li>
                <li id="zona-toate">zona</li>
                <li id="perioada-toate">perioada</li>
                <li id="recompensa-toate">obiect/animal</li>
                <li id="detalii-toate"> detalii</li> 
            </ul>
        </div>
        <div class="clearfix"></div>
        <div class="listaObiecte">
            <?php foreach($arrAnunturi as $anunt) { ?>
            <div class=rand>
                <ul>
                <li class="id" ><?php echo $anunt['id'] ?> </li>
                <li class="categorie" ><?php echo $anunt['categorie'] ?> </li>
                <li class="zona"> <?php echo $anunt['zona'] ?> </li>
                <li class="dataPublicarii" > <?php echo $anunt['data_adaugarii'] ?> </li>
                <li class="obiect/animal" ><?php echo $anunt['nume'] ?></li>
                <li class="detalii"> 
                    <img src="assets/images/icons/down.png" alt="down arrow" onclick="vizualizareDetalii()"/>Detalii
                    <img src="assets/images/icons/frauda.png" alt="raporteaza frauda" onclick="raporteazaFrauda()"/>
                    <img src="assets/images/icons/sterge.png" alt="stergere" onclick="stergere()"/>
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
        <div class="clearfix"></div>
        <ul class="pagini">
            <?php for($i = 1; $i <= $nrPagini; $i++) { ?>
                <li <?php if($i == $pagina) echo 'class="active"' ?>><a href="?pagina=<?php echo $i ?>"><?php echo $i ?></a></li>
            <?php } ?>
        </ul>
        <div class="clearfix"></div>
        <div class="exporturi">
            <select id="formatExport">
                <option value="html">HTML</option>
                <option value="csv">CSV</option>
                <option value="json">JSON</option>
                <option value="pdf">PDF</option>
            </select>
            <button class="exportAnunt" onclick="exportAnunturi('pierdut')">Export</button>
        </div>
        
    </section>
</article>

<?php
    include "footer.php";
?>   
