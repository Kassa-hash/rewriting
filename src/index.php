<?php
$host = "db";
$dbname = "rewriting";
$user = "user";
$password = "password";

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    echo "Connexion à PostgreSQL réussie 🚀";

    $pdo->exec("CREATE TABLE IF NOT EXISTS test (
        id SERIAL PRIMARY KEY,
        name TEXT
    )");

    $pdo->exec("INSERT INTO test (name) VALUES ('Hello Docker')");

    $stmt = $pdo->query("SELECT * FROM test");

    foreach ($stmt as $row) {
        echo "<p>{$row['id']} - {$row['name']}</p>";
    }

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>