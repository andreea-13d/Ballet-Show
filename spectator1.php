<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];

    try {
        require_once "dbh.inc.php"; // include the code from dbh.inc.php to establish the database connection

        $query = "SELECT S.username, count(R.id_recenzie) as nr_recnzii
                  FROM  recenzii R
                  JOIN spectatori S ON S.id_spectator = R.id_spectator
                  WHERE S.username = :username
                  GROUP BY S.id_spectator
                  HAVING count(R.id_recenzie)";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        // Fetch the result as an associative array
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the query returned any results
        if ($result) {
            // Display the results in a box on the same page
            echo "<div style='border: 2px solid #000; border-radius:2em; border-color: black; padding: 10px; font-size: 1.5em; margin: 10px; color: black; text-align: center'>"; // Added color: white
            echo "<div style='text-align: left'>";
            if ($result["nr_recenzii"] = 0)
                echo "Activitate: " . "    Inactiv" . "<br>";
            else if ($result["nr_recenzii"] > 0 && $result["nr_recenzii"] <=2)
                echo "Activitate: " . "    Activ" . "<br>";
            else 
                echo "Activitate: " . "    Foarte Activ" . "<br>";
            echo "<br>";
            echo "</div>";
        } else {
            // Display the error message in white
            echo"<div style='padding: 10px; font-size: 2em; margin: 10px; color: white; text-align: center'>";
            echo "<div style='color: white;'>Nu am găsit nici- un utilizator cu acest username.</div>";
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