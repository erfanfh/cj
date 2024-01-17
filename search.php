<?php

function search($query, $conn)
{
    $results = [];
    $query = '%' . $query . '%';

    $stmt = $conn->prepare("SELECT * FROM pages WHERE content LIKE :query");
    $stmt->bindParam(':query', $query, PDO::PARAM_STR);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}

// Handling live search requests
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $results = search($query, $conn);

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($results);
    exit;
}