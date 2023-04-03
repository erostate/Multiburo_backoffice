<?php
    session_start();
    include_once '../db.inc.php';
    include_once '../fonctions.inc.php';


    if (isset($_POST['dateReserv']))
        $dateReserv = $_POST['dateReserv'];
    
    if (isset($_POST['r']))
        $r = $_POST['r'];

    if (isset($_POST['sb']))
        $sb = $_POST['sb'];
    
    if (isset($_POST['nbp']))
        $nbp = $_POST['nbp'];
    
    // Total des ressources concernées par le nombre de place et le type de ressource
    $countRess = $pdo->prepare('SELECT COUNT(*) FROM ressource WHERE nb_place = :bind_nbplace AND type_ress = :bind_typeress');
    $countRess->bindParam(':bind_nbplace', $nbp, PDO::PARAM_INT, 2);
    $countRess->bindParam(':bind_typeress', $r, PDO::PARAM_STR, 2);
    $countRess->execute();

    // Nombre des ressources déjà utilisé par rapport au nombre de place, du type de ressource et de la date souhaitée
    $stmt = $pdo->prepare('SELECT ress_id FROM ressource RS
        INNER JOIN line_reservation LR ON LR.ress = RS.ress_id
        INNER JOIN reservation R ON R.res_id = LR.reserv
        WHERE R.date = :bind_date AND RS.nb_place = :bind_nbplace AND RS.type_ress = :bind_typeress');
    $stmt->bindParam(':bind_date', $dateReserv, PDO::PARAM_STR, 15);
    $stmt->bindParam(':bind_nbplace', $nbp, PDO::PARAM_INT, 2);
    $stmt->bindParam(':bind_typeress', $r, PDO::PARAM_STR, 2);
    $stmt->execute();

    $search = $stmt->fetch();
    $nbTotal = $countRess->fetchColumn();
    if ($stmt->rowCount() == $nbTotal) {
        header('Location: ../../dash/purchase.php?r='.$r.'&sb='.$sb.'&nbp='.$nbp.'&da=none');
    } else {
        // Récupérer un ID de ressource parmi les disponible
        $ressAv = $pdo->prepare('SELECT ress_id FROM ressource RS WHERE nb_place = :bind_nbplace AND type_ress = :bind_typeress AND ress_id <> :bind_ressid');
        $ressAv->bindParam(':bind_nbplace', $nbp, PDO::PARAM_INT, 2);
        $ressAv->bindParam(':bind_typeress', $r, PDO::PARAM_STR, 2);
        $ressAv->bindParam(':bind_ressid', $search['ress_id'], PDO::PARAM_INT, 5);
        $ressAv->execute();
        $resultLoc = $ressAv->fetch();

        $_SESSION['reserv']['date'] = $dateReserv;
        $_SESSION['reserv']['room'] = $resultLoc['ress_id'];
        $ressAvailable = $nbTotal - $stmt->rowCount();
        echo $nbTotal;
        echo $stmt->rowCount();
        header('Location: ../../dash/purchase.php?r='.$r.'&sb='.$sb.'&nbp='.$nbp.'&da='.$ressAvailable);
    }
?>