<?php
    session_start();
    include_once '../db.inc.php';
    include_once '../fonctions.inc.php';


    if (isset($_POST['ress']))
        $ress = $_POST['ress'];

    if (isset($_POST['date']))
        $date = $_POST['date'];
    
    
    // INSERTION Reservation
    $stmt = $pdo->prepare('INSERT INTO reservation (date, users) VALUES (?, ?)');
    $stmt->execute([$date, $_SESSION['users']['id']]);
    
    $reservId = $pdo->lastInsertId();

    // INSERTION Line_reservation
    $stmt = $pdo->prepare('INSERT INTO line_reservation (reserv, ress) VALUES (?, ?)');
    $stmt->execute([$reservId, $ress]);

    // SI EXTRAS PC RESERVÉ
    if (count($_SESSION['reserv']['listExtrasPc']) > 0) {
        foreach ($_SESSION['reserv']['listExtrasPc'] as $data) {
            // Reservation
            $stmt = $pdo->prepare('INSERT INTO reservation (date, users) VALUES (?, ?)');
            $stmt->execute([$date, $_SESSION['users']['id']]);

            $reservId = $pdo->lastInsertId();

            // Line_reservation
            $stmt = $pdo->prepare('INSERT INTO line_reservation (reserv, ress) VALUES (?, ?)');
            $stmt->execute([$reservId, $data]);

            // echo "PC -> ".$data."<br>";
        }
    }
    // SI EXTRAS PLACE PARKING RESERVÉ
    if (count($_SESSION['reserv']['listExtrasPlPark']) > 0) {
        foreach ($_SESSION['reserv']['listExtrasPlPark'] as $data) {
            // Reservation
            $stmt = $pdo->prepare('INSERT INTO reservation (date, users) VALUES (?, ?)');
            $stmt->execute([$date, $_SESSION['users']['id']]);

            $reservId = $pdo->lastInsertId();

            // Line_reservation
            $stmt = $pdo->prepare('INSERT INTO line_reservation (reserv, ress) VALUES (?, ?)');
            $stmt->execute([$reservId, $data]);

            // echo "PK -> ".$data."<br>";
        }
    }

    // echo "Count PC -> ".count($_SESSION['reserv']['listExtrasPc']);
    // echo "Count PK -> ".count($_SESSION['reserv']['listExtrasPlPark']);
    header('Location: ../../dash/index.php');
?>