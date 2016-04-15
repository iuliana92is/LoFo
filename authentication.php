<form id="formAuthentication" method="POST" action="inregistrare.php" onsubmit="return(validate());" name="myForm" >
    <div id="formAuthenticationField">  
        <input type="text" name="numeUtilizator" id="numeUtilizator"  placeholder="Nume Utilizator"/>
        <input type="password" name="password" class="password"  placeholder="Parola"/>
        <input type="password" name="password" class="password"  placeholder="Parola"/> 
        <br/>   
        <button name="submit" value="Send" class="btn-autentificare"  >Autentificare</button>
        <button name="cancel" value="Cancel" class="btn-cancel" >Renunta</button>
    </div>
</form>