<?php
    $title = "Pagina utilizator";
    include "header.php"; 
     
?>  
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
            <input type="text" value=" " readonly /> 
            <div class="clearfix"></div>
            <br /> 
            <label> Adesa e-mail:</label>
            <input type="text" value=" " readonly />
            <div class="clearfix"></div>
            <br /> 
            <label>Telefon:</label>
            <input type="text" value=" " readonly />
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

<?php
    include "footer.php";
?> 