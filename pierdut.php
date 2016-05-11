<?php
    $titlu = "Pierdute";
    include "header.php";
?>  

<section class="filterBar">
    <h1>Cautare rapida</h1>
    <form>
        <select class="categorie">
            <option disabled="" selected="" value="0">Categorie</option> 
                <option value=" "> </option> 
        </select>
        <select class="zona" name="zona">
            <option disabled="" selected="" value="0">Zona</option> 
                <option value=" "> </option> 
        </select>
        <button class="search">search</button>
    </form>
</section>

    <form id="formFound" method="POST" action=""  name="myForm" >
        <div id="formFoundField">
        <h1>Am gasit ceva! <br/>Adaug acum un anunt!</h1>
            <select class="categorie" id="addCategorie">
                <option disabled="" selected="" value="0">Categorie</option> 
                <option value=" "> </option> 
            </select>
            <select class="zona" id="addZona">
                <option disabled="" selected="" value="0">Zona</option> 
                    <option value=" "> </option> 
            </select>
            <input type="text" placeholder="Nume"id="addNume"  />
            <select class="culoare" id="addCuloare">
                <option disabled="" selected="" value="0">Culoare</option> 
                <option value=" "> </option> 
            </select>
            <select class="stare" id="addStare">
                <option disabled="" selected="" value="0">Stare</option> 
                <option value=" "> </option> 
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
<?php
    include "toateAnunturi.php";
?> 
<?php
    include "footer.php";
?>   
