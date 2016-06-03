        <?php
            $titlu = "Acasa";
            include "header.php";

            $conexiune = $GLOBALS['conexiune'];
            $sql = "select an.*, ut.utilizator, ut.email, ut.telefon from anunturi an join utilizatori ut on ut.id = an.utilizator order by an.data_adaugarii desc";
            $query = $conexiune->prepare($sql);
            $query->execute();

            $rezultat = $query->get_result();
            
            $arrAnunturi = array();
            while($rand = $rezultat->fetch_assoc()) {
                $arrAnunturi[] = $rand;
            }
        ?>  

            <!-- in pagina pricipala vor putea fi vizualizate ultimele anunturi create indiferent de tipul lor (gasite/pierdute) 
            afisarea acestora se va realiza in functie de data la care au fost ele create-->
            <article class="toateAnunturi">
                <h1>Ultimele anunturi adaugate</h1>
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
                </section>
            </article>
        <?php
            include "footer.php";
        ?> 