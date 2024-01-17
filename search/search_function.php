<?php

function search($query, $index) {
    $results = [];
    foreach ($index as $page) {
        if (stripos($page['content'], $query) !== false) {
            $results[] = $page;
        }
    }
    return $results;

}
?>