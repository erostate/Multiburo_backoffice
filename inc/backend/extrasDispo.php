<?php
    session_start();
    include_once '../db.inc.php';
    include_once '../fonctions.inc.php';


    if (isset($_POST['nbExtras']))
        $nbExtras = $_POST['nbExtras'];
    
    if (isset($_POST['typeRess']))
        $typeRess = $_POST['typeRess'];

    if (isset($_POST['dateReserv']))
        $dateReserv = $_POST['dateReserv'];
    
    if (isset($_POST['act']))
        $act = $_POST['act'];
    
    
    if ($typeRess == "PC") {
        if (isset($_SESSION['reserv']['listExtrasPc']))
            unset($_SESSION['reserv']['listExtrasPc']);
        $_SESSION['reserv']['listExtrasPc'] = [];
    } else {
        if (isset($_SESSION['reserv']['listExtrasPlPark']))
            unset($_SESSION['reserv']['listExtrasPlPark']);
        $_SESSION['reserv']['listExtrasPlPark'] = [];
    }
    
    
    $ressAv = $pdo->prepare('SELECT ress_id, label, serial_number FROM ressource RS WHERE type_ress = :bind_typeress AND ress_id NOT IN (
        SELECT LR.ress FROM line_reservation LR INNER JOIN reservation R ON LR.reserv = R.res_id WHERE R.date = :bind_date
    ) LIMIT :bind_nbextras');
    $ressAv->bindParam(':bind_typeress', $typeRess, PDO::PARAM_STR, 2);
    $ressAv->bindParam(':bind_date', $dateReserv, PDO::PARAM_STR, 10);
    $ressAv->bindParam(':bind_nbextras', $nbExtras, PDO::PARAM_INT, 5);
    $ressAv->execute();
    $resultLoc = $ressAv->fetchAll();

    if ($typeRess == "PC") {
        $tmp = "<b>Ordinateur:</b><br>";

        foreach ($resultLoc as $data) {
            $tmp .= " -";
            $tmp .= $data['label'];

            array_push($_SESSION['reserv']['listExtrasPc'], $data['ress_id']);
        }
    } else {
        $tmp = "<b>Place de parking:</b><br>";

        foreach ($resultLoc as $data) {
            $tmp .= " -";
            $tmp .= $data['label'];
            
            array_push($_SESSION['reserv']['listExtrasPlPark'], $data['ress_id']);
        }
    }

    if ($nbExtras != 0) {
        echo $tmp;
    } else {
        echo "";
    }
    
    // echo "<br><br>";
    // print_r($_SESSION['reserv']['listExtrasPc']);
    // echo "<br>";
    // print_r($_SESSION['reserv']['listExtrasPlPark']);
?>