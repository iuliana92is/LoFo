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
    </form>
    <br/>
    </br>
    <button name="salveazaEditare" value="Send" class="salveazaEditare"  >Salveaza editarea</button>
    <button name="anuleazaEditare" value="Cancel" class="anuleazaEditare" >Reseteaza campuri</button>
</div>


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
            <input type="text"> </input> 
            <div class="clearfix"></div>
            <br /> 
            <label> Adesa e-mail:</label>
            <input type="text"></input>
            <div class="clearfix"></div>
            <br /> 
            <label>Telefon:</label>
            <input type="text"> </input>
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