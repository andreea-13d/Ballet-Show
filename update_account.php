<?php

try {if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "dbh.inc.php";
    // Colectează datele din formular
    $username = $_POST["username"];
    $parola= $_POST["parola"];

    $query = "SELECT username FROM spectatori  WHERE username = :username ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result){

        $query = "UPDATE spectatori SET parola = :parola WHERE username = :username ";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":parola", $parola);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Utilizatorul și parola sunt valide
        //echo "update reusit!";
        echo '<div style="color: green; text-align: center; font-size: 100px;">Parola resetata cu succes!</div>';
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
    <title>Update Account</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    
    <div class="login">
	<h2>Update account</h2><br>
    <form id="update" method="post" action="update_account.php">
        <label><b>Username
        </b>
        </label>
        <input type="text" name="username" id="username" >
        <br><br>
        <label><b> New Password
        </b>
        </label>
        <input type="password" name="parola" id="parola">
        <br><br>
        <button type="submit" class="lbutton">Update</button>
        <br><br>
        <a href="login.php">Login</a>
        <br><br>
		
    </form>
</div>
</body>
</html>