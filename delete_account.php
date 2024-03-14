<?php

try {if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "dbh.inc.php";
    // Colectează datele din formular
    $username = $_POST["username"];
    $parola= $_POST["parola"];

    $query = "SELECT username FROM spectatori  WHERE username = :username and parola = :parola ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":parola", $parola);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result){

        $query = "DELETE FROM spectatori WHERE username = :username  and  parola = :parola";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":parola", $parola);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo '<div style="color: green; text-align: center; font-size: 100px;">Contul a fost șters cu succes!</div>';
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "login.php";
                    }, 1500); // Redirecteaza catre login.php dupa 1.5 secunde
                  </script>';
            exit();
    } else {
        // Utilizator negasit
        echo '<div style="color: red; text-align: center; font-size: 20px;">Utilizator inexistent!!!</div>';
        echo '<script>
            setTimeout(function() {
                document.querySelector("div").style.display = "none";
            }, 5000);
        </script>';
    }
    
}
    
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Delete Account</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    
    <div class="login">
	<h2>Delete account</h2><br>
    <form id="update" method="post" action="delete_account.php">
        <label><b>Username
        </b>
        </label>
        <input type="text" name="username" id="username" >
        <br><br>
        <label><b>Password
        </b>
        </label>
        <input type="password" name="parola" id="parola">
        <br><br>
        <button type="submit" class="lbutton">Delete</button>
        <br><br>
        <a href="login.php">Login</a>
        <br><br>
		
    </form>
</div>
</body>
</html>