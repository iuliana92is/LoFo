<?php
    $title = "Inregistrare";
    include "header.php";
?>

<form id="formRegister" method="POST" action="" onsubmit="return inregistrare();" name="myForm" >
    <div id="formRegisterField"> 
        <input type="text" name="nume" placeholder="Nume si prenume" required />
        <input type="email" name="email" id="email" placeholder="Email" required />
        <input type="text" name="utilizator" placeholder="Nume utilizator" required />
        <input type="password" name="parola" class="password" placeholder="Parola" required />
        <input type="phone" name="telefon" placeholder="Nr. Telefon" /> 
        <br/>   
        <button type="submit" class="btn-creare">Creare</button>
        <button type="reset" class="btn-cancel">Renunta</button>
    </div>
</form>

<?php
    include "footer.php";
?>