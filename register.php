<form id="formRegister" method="POST" action="inregistrare.php" onsubmit="return(validate());" name="myForm" >
    <div id="formRegisterField"> 
        <input  type="text" name="name" placeholder="Nume utilizator"/>
        <input  type="text" name="email" id="email"  placeholder="Email"/>
        <input type="password" name="password" class="password"  placeholder="Parola"/>
        <input type="password" name="password" class="password"  placeholder="Parola"/>
        <input name="phone" placeholder="Nr. Telefon" type="text"  pattern="^\d{4}-\d{3}-\d{4}$" /> 
        <br/>   
        <button name="submit" value="Send" class="btn-creare"  >Creare</button>
        <button name="cancel" value="Cancel" class="btn-cancel" >Renunta</button>
    </div>
</form>