<article class="toateAnunturi">
    <h1>Toate Anunturile</h1>
    <section id="toateAnunturi">
        <div class="tot">
            <ul>
                <li id="categorie-toate">Categorie</li>
                <li id="zona-toate">zona</li>
                <li id="perioada-toate">perioada</li>
                <li id="recompensa-toate">obiect/animal</li>
                <li id="detalii-toate"> detalii</li>
            </ul>
        </div>
        <div class="clearfix"></div>
        <div class="listaObiecte">
            <div class=rand>
                <ul>
                <li class="categorie" >obiect </li>
                <li class="zona"> dancu </li>
                <li class="dataPublicarii" > ziua curenta </li>
                <li class="obiect/animal" > telefon </li>
                <li class="detalii"> <img src="assets/images/icons/down.png" alt="down arrow" onclick="vizualizareDetalii()"/>   Detalii </li>
            </ul>
            <!-- details informations -->
            <div class="clearfix"></div>
            <div class="infoText hidden">
                <div class="infoTextObiect">
                    <div class="leftText">
                        <p>culoare: </p>
                    </div>
                    <div class="rightText">
                        <p> maro</p>
                    </div>
                    <div class="clearfix"></div>
                    <div class="leftText">
                        <p>stare: </p>
                    </div>
                    <div class="rightText">
                        <p> stricat</p>
                    </div>
                    <div class="clearfix"></div>
                    <div class="leftText">
                        <p>detalii: </p>
                    </div>
                    <div class="rightText">
                        <p>   verde buline  buline bulinealbastre   verde buline albastre verde buline albastreverde buline albastre  verde buline albastre verde buline albastre  verde buline albastre verde buline albastre  verde buline albastre verde buline albastre </p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="infoTextImg">
                    <img src="assets/images/lost/lost4.jpg" alt="imagine obiect" />
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



            <div class="rand">
                <ul>
                    <li class="categorie" >obiect </li>
                    <li class="zona"> dancu </li>
                    <li class="dataPublicarii" > ziua curenta </li>
                    <li class="obiect/animal" > telefon </li>
                    <li class="detalii"> <img src="assets/images/icons/down.png" alt="down arrow" onclick="vizualizareDetalii()"/>   Detalii </li>
                </ul>
                <!-- details informations -->
                <div class="clearfix"></div>
                <div class="infoText hidden">
                    <div class="infoTextObiect">
                        <div class="leftText">
                            <p>culoare: </p>
                        </div>
                        <div class="rightText">
                            <p> maro</p>
                        </div>
                        <div class="clearfix"></div>
                        <div class="leftText">
                            <p>stare: </p>
                        </div>
                        <div class="rightText">
                            <p> stricat</p>
                        </div>
                        <div class="clearfix"></div>
                        <div class="leftText">
                            <p>detalii: </p>
                        </div>
                        <div class="rightText">
                            <p>   verde buline  buline bulinealbastre   verde buline albastre verde buline albastreverde buline albastre  verde buline albastre verde buline albastre  verde buline albastre verde buline albastre  verde buline albastre verde buline albastre </p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="infoTextImg">
                        <img src="assets/images/lost/lost4.jpg" alt="imagine obiect" />
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
        </div>
    </section>
</article>

<script type="text/javascript">
    function vizualizareDetalii(e) {
        var event = event || window.event;
        var detalii = event.srcElement;
        while ((detalii = detalii.parentElement) && !detalii.classList.contains("rand"));

        for(var i = 0; i < detalii.childNodes.length; i++) {
            if(detalii.childNodes[i].classList && detalii.childNodes[i].classList.contains("infoText")) {
                detalii = detalii.childNodes[i];
                break;
            }
        }

        detalii.classList.add("active");
        detalii.classList.remove("hidden");
    }

    function inchidereDetalii(e) {
        var event = event || window.event;
        var detalii = event.srcElement;
        while ((detalii = detalii.parentElement) && !detalii.classList.contains("infoText"));
        detalii.classList.add("hidden");
        detalii.classList.remove("active");
    }

</script>