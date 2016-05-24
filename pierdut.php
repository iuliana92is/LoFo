<?php
    $titlu = "Pierdute";
    include "header.php"; 

    $conexiune = $GLOBALS['conexiune'];
    $pagina = isset($_GET['pagina']) && $_GET['pagina'] ? $_GET['pagina'] : 1;
    $anunturiPePagina = 2; 
    $sql = "select * from anunturi where tip = 'pierdut'";
    $rezultat = $conexiune->query($sql);

    $arrAnunturi = array();
    while($rand = $rezultat->fetch_assoc()) {
        $arrAnunturi[] = $rand;
    }

    $nrPagini = ceil(count($arrAnunturi) / $anunturiPePagina);
    $arrAnunturi = array_slice($arrAnunturi, ($pagina - 1) * $anunturiPePagina, $anunturiPePagina);
?>  

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
                <li class="categorie" ><?php echo $anunt['categorie'] ?> </li>
                <li class="zona"> <?php echo $anunt['zona'] ?> </li>
                <li class="dataPublicarii" > <?php echo $anunt['data_adaugarii'] ?> </li>
                <li class="obiect/animal" ><?php echo $anunt['nume'] ?></li>
                <li class="detalii"> <img src="assets/images/icons/down.png" alt="down arrow" onclick="vizualizareDetalii()"/>Detalii</li>
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
        <ul class="pagini">
            <?php for($i = 1; $i <= $nrPagini; $i++) { ?>
                <li <?php if($i == $pagina) echo 'class="active"' ?>><a href="?pagina=<?php echo $i ?>" style="color: black; float: left;"><?php echo $i ?></a></li>
            <?php } ?>
        </ul>
        <div class="clearfix"></div> 

        <select id="formatExport">
            <option value="html">HTML</option>
            <option value="csv">CSV</option>
            <option value="json">JSON</option>
            <option value="pdf">PDF</option>
        </select>
        <button onclick="exportAnunturi('pierdut')">Export</button>
    </section>
</article>

<?php
    include "footer.php";
?>   
