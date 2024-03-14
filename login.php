<?php
require_once "dbh.inc.php";
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $username = $_POST["username"];
        $parola = $_POST["parola"];

        $query = "SELECT * FROM spectatori WHERE username = :username";
        $stmt = $pdo->prepare($query); // Asigură-te că $pdo este definit prin includerea fișierului corect
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user){
            // Utilizatorul și parola sunt valide
            //echo "Autentificare reușită!";
            header("Location: home.php");
            exit();
        } else {
            // Utilizator sau parolă incorecte
            echo '<div style="color: red; text-align: center; font-size: 20px;">Username sau parola gresita!!!</div>';
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
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    
    <div class="login">
    <br><br>
	<h2>Login</h2><br>
    <form id="login" method="post" action="login.php">
        <label><b>User Name
        </b>
        </label>
        <input type="text" name="username" id="username" placeholder="Username" required>
        <br><br>
        <label><b>Password
        </b>
        </label>
        <input type="password" name="parola" id="parola" placeholder="Password" required>
        <br><br>
        <button type="submit" class="lbutton">Login</button>

		<p class="message">Not registered? <a href="register.php">Create an account</a></p>
        <p class="message">Forgot password? <a href="update_account.php">Update account</a></p>
        <p class="message"> Useless Account? <a href="delete_account.php">Delete account</a></p>   

        <br><br>
        <br><br>
        <br><br>
    </form>
</div>
</body>
</html>