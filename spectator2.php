<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];

    try {
        require_once "dbh.inc.php"; // include the code from dbh.inc.php to establish the database connection

        $query = "SELECT S.username, P.nume, P.data, P.ora, B.loc
                  FROM  bilete B
                  JOIN spectatori S ON S.id_spectator = B.id_spectator
                  JOIN programe P ON P.id_program = B.id_program
                  WHERE S.username = :username ";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        // Fetch the result as an associative array
        $rez = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if the query returned any results
        if ($rez) {
            echo "<div style='border: 2px solid #000; border-radius:2em; border-color: black; padding: 10px; font-size: 1.5em; margin: 10px; color: black; text-align: center'>"; // Added color: white
            echo "<div style='text-align: left'>";
            echo "<h2>" . "Bilete achizitionate: " . "</h2>";
            echo "<div class='program-box'>";
            foreach ($rez as $result){
            // Display the results in a box on the same page
            
            echo "Nume program: " . $result["nume"]. "<br>";
            echo "Data: " . $result["data"]. "<br>";
            echo "Ora: " . $result["ora"] . "<br>";
            echo "Numar loc: " . $result["loc"] . "<br>";
            echo "<br>";
            }
            
            echo "</div>";
            echo "</div>";

        } else {
            // Display the error message in white
            echo"<div style='padding: 10px; font-size: 2em; margin: 10px; color: white; text-align: center'>";
            echo "<div style='color: white;'>Acest spectator nu a achizitionat bilete.</div>";
        }

        // Close the database connection
        $pdo = null;
        $stmt = null;

        // Don't redirect, just end the script here
        die("");
    } catch (PDOException $e) {
        // Display the error message in white
        die("<div style='color: white;'>Query failed: " . $e->getMessage() . "</div>");
    }
} else {
    header("Location: ../index.php");
    die(""); // or exit()
}


?>