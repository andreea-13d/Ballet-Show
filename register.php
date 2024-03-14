<?php
// Verifică dacă formularul a fost trimis prin metoda POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Colectează datele din formular
    $first_name = $_POST["Fname"];
    $last_name = $_POST["Lname"];
    $username = $_POST["username"];
    $parola= $_POST["parola"];

    // Verifică dacă toate câmpurile sunt completate
    if (!empty($first_name) && !empty($username) && !empty($parola)&&!empty($last_name) ) {
        // Puteți adăuga aici logica pentru înregistrare într-o bază de date, dacă este necesar
        // De exemplu, puteți utiliza instrucțiuni SQL pentru a insera datele într-o tabelă
        require_once "dbh.inc.php";

        // Instrucțiune SQL pentru inserarea datelor în baza de date
        //inseram in baza de date un nou user
        $query = "INSERT INTO spectatori (username, parola) VALUES (:username, :parola)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':parola', $parola); // Folosim hash-ul parolei
        $stmt->execute();
        // Redirectează către pagina de login
        echo '<div style="color: green; text-align: center; font-size: 100px;">Contul a fost creat cu succes!</div>';
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "login.php";
                    }, 1500); // Redirecteaza catre login.php dupa 1.5 secunde
                  </script>';
            exit();
    } else {
        echo '<div style="color: red; text-align: center; font-size: 20px;">Toate câmpurile trebuie completate. Vă rugăm să reveniți și să completați toate informațiile.</div>';

        // Adaugă cod JavaScript pentru a ascunde mesajul după 5 secunde
        echo '<script>
            setTimeout(function() {
                document.querySelector("div").style.display = "none";
            }, 5000);
        </script>';
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Create an Account</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    
    <div class="login">
	<h2>Create an account</h2><br>
    <form id="register" method="post" action="register.php">
        <label><b>First Name
        </b>
        </label>
        <input type="text" name="Fname" id="Fname" >
        <br><br>
        <label><b>Last Name
        </b>
        </label>
        <input type="text" name="Lname" id="Lname">
        <br><br>
        <label><b>Username
        </b>
        </label>
        <input type="text" name="username" id="username">
        <br><br>
        <label><b>Password
        </b>
        </label>
        <input type="password" name="parola" id="parola">
        <br><br>
        <button type="submit" class="lbutton">Create</button>
        <br><br>
         <a href="login.php">Login</a>
        <br><br>
		
    </form>
</div>
</body>
</html>