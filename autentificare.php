<?php
    $title = "Autentificare";
    include "header.php";
?>
<form id="formAuthentication" method="POST" action="" onsubmit="return autentificare();" name="myForm" >
    <div id="formAuthenticationField">  
        <input type="text" name="utilizator" placeholder="Utilizator" />
        <input type="password" name="parola" class="parola" placeholder="Parola" />
        <br/>   
        <button type="submit" class="btn-autentificare">Autentificare</button>
        <button type="reset" class="btn-cancel">Renunta</button>
    </div>
</form> 
<?php
    include "ultimeleAnunturi.php";
    ?> 
<?php
    include "vizualizateAnunturi.php";
    ?>  
<?php
    include "footer.php";
?>