<?php
    session_start();
    include_once '../db.inc.php';
    include_once '../fonctions.inc.php';


    if (isset($_GET['leave'])) {
        // SELECT History_sub -> Récupérer l'id de Subscription
        $stmt = $pdo->prepare('SELECT sub FROM history_sub WHERE users = :bind_usersid');
        $stmt->bindParam(':bind_usersid', $_SESSION['users']['id'], PDO::PARAM_INT, 5);
        $stmt->execute();
        $resultSelSub = $stmt->fetch();
        $subId = $resultSelSub['sub'];

        // SUPPRESSION History_sub
        $stmt = $pdo->prepare('DELETE FROM history_sub WHERE users = :bind_usersid');
        $stmt->bindParam(':bind_usersid', $_SESSION['users']['id'], PDO::PARAM_INT, 5);
        $stmt->execute();

        // SUPPRESSION Subscription
        $stmt = $pdo->prepare('DELETE FROM subscription WHERE sub_id = :bind_subid');
        $stmt->bindParam(':bind_subid', $subId, PDO::PARAM_INT, 5);
        $stmt->execute();
    } else {
        if (isset($_POST['typeSub']))
            $typeSub = $_POST['typeSub'];
        
        if (isset($_POST['whatDo']))
            $whatDo = $_POST['whatDo'];
        
        if (isset($_POST['periodAdd']))
            $periodAdd = $_POST['periodAdd'];
        
        if (isset($_POST['act']))
            $act = $_POST['act'];
        
        
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
            // SELECT Subscription -> Récupérer la Duration actuel
            $stmt = $pdo->prepare('SELECT S.sub_id, S.duration FROM subscription S
                INNER JOIN history_sub HS ON HS.sub = S.sub_id
                WHERE HS.users = :bind_usersid');
            $stmt->bindParam(':bind_usersid', $_SESSION['users']['id'], PDO::PARAM_INT, 5);
            $stmt->execute();
            $resISub = $stmt->fetch();

            $subId = $resISub['sub_id'];
            $durActu = $resISub['duration'];
            
            // Action à effectuer
            if ($act == "changeFormule") {
                $newDur = $periodAdd;
            } elseif ($act == "prolongSub") {
                $newDur = $durActu + $periodAdd;
            }
            
            // UPDATE Subscription
            $stmt = $pdo->prepare('UPDATE subscription SET label = :bind_label, duration = :bind_duration WHERE sub_id = :bind_subid');
            $stmt->bindParam(':bind_label', $labelTypeSub, PDO::PARAM_STR, 20);
            $stmt->bindParam(':bind_duration', $newDur, PDO::PARAM_INT, 5);
            $stmt->bindParam(':bind_subid', $subId, PDO::PARAM_INT, 5);
            $stmt->execute();
        }
    }

    header('Location: ../../dash/index');
?>