<?php
header('Content-Type: application/json; charset=utf-8');



$host = "localhost";
$port = "5432";
$dbname = "Test";
$user = "postgres";
$password = "postgresql";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
} catch (PDOException $e) { 
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

// ⚠️ Utilise ST_AsGeoJSON() pour renvoyer des géométries lisibles par Leaflet
$sql = "SELECT name, ST_AsGeoJSON(wkb_geometry) AS geom FROM polynesie;";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data);
// test commit (j'ai la mémoire courte)