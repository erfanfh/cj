<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = isset($_POST['query']) ? $_POST['query'] : '';
    include 'data.php';
    include 'search_function.php';
    $results = search($query, $index);
    echo '<h2>Search Results</h2>';
    echo '<ul>';
    foreach ($results as $result) {
        echo '<li>' . $result['title'] . '</li>';
    }
    echo '</ul>';
}
?>