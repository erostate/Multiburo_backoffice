<?php
    session_start();
    include_once '../db.inc.php';
    include_once '../fonctions.inc.php';


    if (isset($_POST['typeSub']))
        $typeSub = $_POST['typeSub'];
    
    if (isset($_POST['whatDo']))
        $whatDo = $_POST['whatDo'];
    
    if (isset($_POST['periodAdd']))
        $periodAdd = $_POST['periodAdd'];
    
    
    if ($typeSub == "day") {
        $labelTypeSub = "Journalier";
        $duration = 1;
        $price = 5;
    } elseif ($typeSub == "week") {
        $labelTypeSub = "Hebdomadaire";
        $duration = 1;
        $price = 35;
    } else {
        $labelTypeSub = "Mensuel";
        $duration = 1;
        $price = 150;
    }

    if ($whatDo == "new") {
        // INSERTION Subscription
        $stmt = $pdo->prepare('INSERT INTO subscription (label, duration, price) VALUES (?, ?, ?)');
        $stmt->execute([$labelTypeSub, $duration, $price]);

        $reservId = $pdo->lastInsertId();
        $date = date('Y-m-d');

        // INSERTION History_sub
        $stmt = $pdo->prepare('INSERT INTO history_sub (users, sub, date) VALUES (?, ?, ?)');
        $stmt->execute([$_SESSION['users']['id'], $reservId, $date]);
    } else {
        $newDate = date('Y-m-d', strtotime('+'.$periodAdd.' '.$typeSub));
        
        // UPDATE History_sub
        $stmt = $pdo->prepare('UPDATE history_sub SET date = :bind_date WHERE users = :bind_usersid');
        $stmt->bindParam(':bind_date', $newDate, PDO::PARAM_STR, 12);
        $stmt->bindParam(':bind_usersid', $_SESSION['users']['id'], PDO::PARAM_INT, 5);
        $stmt->execute();
    }

    header('Location: ../../dash/index');
?>