<?php
    session_start();
    include_once '../db.inc.php';
    include_once '../fonctions.inc.php';


    if (isset($_POST['typeSub']))
        $typeSub = $_POST['typeSub'];
    
    
    if ($typeSub == "day") {
        $labelTypeSub = "Journalier";
        $duration = 1;
        $price = 5;
    } elseif ($typeSub == "week") {
        $labelTypeSub = "Hebdomadaire";
        $duration = 7;
        $price = 35;
    } else {
        $labelTypeSub = "Mensuel";
        $duration = 30;
        $price = 150;
    }
    
    // INSERTION Subscription
    $stmt = $pdo->prepare('INSERT INTO subscription (label, duration, price) VALUES (?, ?, ?)');
    $stmt->execute([$labelTypeSub, $duration, $price]);
    
    $reservId = $pdo->lastInsertId();
    $date = date('Y-m-d');

    // INSERTION History_sub
    $stmt = $pdo->prepare('INSERT INTO history_sub (users, sub, date) VALUES (?, ?, ?)');
    $stmt->execute([$_SESSION['users']['id'], $reservId, $date]);

    header('Location: ../../dash/index.php');
?>