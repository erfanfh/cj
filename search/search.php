<?php

function search()
{
    $mysqli = new mysqli("localhost", "#", "", "#");
    $mysqli->set_charset("utf8");
    $stmt = $mysqli->stmt_init();

    if (!empty($_GET['search'])) {
        $GLOBALS['title'] = "جستجو : {$_GET['search']}";
        $search_query = "title LIKE ? OR content LIKE ?";
        $_GET['search'] = "%{$_GET['search']}%";
    } else {
        $GLOBALS['title'] = "لیست مطالب";
        $search_query = "true";
    }
    $query = "SELECT * FROM `posts` WHERE {$search_query}";
    $stmt->prepare($query);
    if (!empty($_GET['search'])) {
        $stmt->bind_param('ss', $_GET['search'], $_GET['search']);
    }
    $GLOBALS['rows'] = [];
    if ($stmt->execute() && $res = $stmt->get_result()) {
        if ($stmt->affected_rows || $res->num_rows) {
            while ($row_loop = $res->fetch_assoc()) {
                $GLOBALS['rows'][] = $row_loop;
            }
        }
    }

    $stmt->close();
    $mysqli->close();
}

if (!empty($_GET['search']) && @$_GET['ext'] == "js") {
    header("Content-Type: application/json");
    search();
    echo json_encode($GLOBALS['rows']);
}