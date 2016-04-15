<form id="formFound" method="POST" action="inregistrare.php" onsubmit="return(validate());" name="myForm" >
    <div id="formFoundField">
    <h1>Am pierdut ceva! <br/> Fac un anunt despre ce am pierdut!</h1>
       <!--  <input name="name" type="text"  placeholder="Nume"/>
        <input name="email" type="text" id="email"  placeholder="Email"/>
        <input name="phone" placeholder="Nr. Telefon" type="text"  pattern="^\d{4}-\d{3}-\d{4}$" /> -->
        <select class="categorie">
            <option disabled="" selected="">Categorie</option>
            <option>Animale</option>
            <option>Obiecte</option>
        </select>
        <select class="zona">
            <option disabled="" selected="">Zona</option>
            <option>Pacurari</option>
            <option>Dacia</option>
            <option>Alexandru</option>
            <option>Dacia</option>
            <option>Canta</option>
            <option>Nicolina</option>
            <option>Galata</option>
            <option>Podul Ros</option>
            <option>Centru</option>
            <option>Copou</option>
            <option>Bucium</option>
            <option>Bularga</option>
            <option>Tatarasi</option>
            <option>Targu cucu</option>
            <option>Aeroport</option>
            <option>Ciric</option>
            <option>Frumoasa</option>
            <option>Valea lupului</option>
        </select>
        <select class="animale">
            <option disabled="" selected="">Animale</option>
            <option>Catel</option>
            <option> Pisica</option>
            <option> Hamster</option>
            <option>Papagal</option>
            <option> Porcusor </option>
            <option> Altele</option>
        </select>
        <select class="obiecte">
            <option disabled="" selected="">Obiecte</option>
            <option> Accesorii</option>
            <option> Bijuterii</option>
            <option> Portofele</option>
            <option> Chei</option>
            <option> Bunuri valoroase </option>
            <option> Acte</option>
            <option> Altele</option>
        </select> 
        <select class="culoare">
            <option disabled="" selected="">Culoare</option>
            <option> Rosu</option>
            <option> Galben</option>
            <option> Albastru</option>
            <option> Mov</option>
            <option> Verde</option>
            <option> Portocaliu</option>
            <option> Maro</option>
            <option> Roz</option>
            <option> Gri</option>
            <option> Alb</option>
            <option> Negru</option>
        </select>
        <select class="stare">
            <option disabled="" selected="">Stare</option>
            <option>Buna</option>
            <option>Deteriorat</option>
        </select>
        <br/> 
        <div class="clearfix"> </div>
        <div class="upload">
            <input type="file" name="upload"/>  
        </div>
        <br/>
        <div class="clearfix"> </div>
        <textarea  placeholder="Descriere"></textarea>
        <br/>
        <div class="clearfix"> </div>
        <button name="submit" value="Send" class="btn-send"  >Adauga</button>
        <button name="cancel" value="Cancel" class="btn-cancel" >renunta</button>
    </div>
</form>