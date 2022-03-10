<?php session_start();

use Reensq\plugin\core\Parser;
use Reensq\plugin\lib\jQuery;

$articles = [];



    $sql = 'SELECT * FROM `threads` ORDER BY `id` DESC LIMIT 5';
    $stmt = $PDO->query($sql);

    while($row = $stmt->fetch()) {
        $articles[] = $row;
    }

    echo json_encode($articles);

