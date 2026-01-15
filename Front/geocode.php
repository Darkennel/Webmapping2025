<?php
// Autoriser l'accès depuis ton site
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Vérification de la requête
if (!isset($_GET['q']) || strlen($_GET['q']) < 3) {
    http_response_code(400);
    echo json_encode(["error" => "Requête invalide"]);
    exit;
}

$query = urlencode($_GET['q']);

// URL Nominatim
$url = "https://nominatim.openstreetmap.org/search?format=json&limit=1&q=$query";

// User-Agent OBLIGATOIRE (exigé par Nominatim)
$options = [
    "http" => [
        "header" => 
            "User-Agent: LocalisationUrgence/1.0 (samuel.martin06@hotmail.fr)\r\n"
    ]
];

$context = stream_context_create($options);

// Appel API
$response = @file_get_contents($url, false, $context);

if ($response === false) {
    http_response_code(500);
    echo json_encode(["error" => "Erreur Nominatim"]);
    exit;
}

echo $response;
