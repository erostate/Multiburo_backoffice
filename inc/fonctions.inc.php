<?php
    include_once 'db.inc.php';
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    }
    catch(Exception $e) {
        die('Unable to connect to database.');
    }

    // Maybe detect si ressource existe pour aff "disponible" ou "indisponible" sur index

    
    // RETOURNER LE NOMBRE D'EXTRAS MAX
    function returnMaxExtraAvailable($type, $dateReserv, $pdo) {
        // Total des ressources concernées par le type de ressource
        $countRess = $pdo->prepare('SELECT COUNT(*) FROM ressource WHERE type_ress = :bind_typeress');
        $countRess->bindParam(':bind_typeress', $type, PDO::PARAM_STR, 2);
        $countRess->execute();

        // Nombre des ressources déjà utilisé par rapport au type de ressource et la date souhaitée
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM ressource RS
            INNER JOIN line_reservation LR ON LR.ress = RS.ress_id
            INNER JOIN reservation R ON R.res_id = LR.reserv
            WHERE R.date = :bind_date AND RS.type_ress = :bind_typeress');
        $stmt->bindParam(':bind_date', $dateReserv, PDO::PARAM_STR, 15);
        $stmt->bindParam(':bind_typeress', $type, PDO::PARAM_STR, 2);
        $stmt->execute();

        $nbSearch = $stmt->fetchColumn();
        $nbTotal = $countRess->fetchColumn();

        return $nbTotal - $nbSearch;
    }


    // OBTENIR LES INFOS D'UNE RESSOURCE
    function obtainInfoRess($colone, $search, $pdo) {
        if ($colone != "all") {
            if ($search != "all") {
                $stmt = $pdo->prepare('SELECT '.$colone.' FROM ressource WHERE ress_id = :bind_search');
                $stmt->bindParam(':bind_search', $search, PDO::PARAM_INT, 5);
                $stmt->execute();
            }
            $result = $stmt->fetch();

            return $result[$colone];
        }
    }


    // OBTENIR LES INFOS D'UN TYPE DE RESSOURCE
    function obtainInfoTypeRess($search, $pdo) {
        $stmt = $pdo->prepare('SELECT label FROM type_ress WHERE type_code = :bind_search');
        $stmt->bindParam(':bind_search', $search, PDO::PARAM_STR, 10);
        $stmt->execute();

        $result = $stmt->fetch();

        return $result['label'];
    }


    // OBTENIR LES INFOS DE L'UTILISATEUR
    function obtainInfoUser($search, $pdo) {
        $stmt = $pdo->prepare('SELECT U.lastname, U.firstname, U.phone AS "phoneUsers", U.mail, U.cp AS "cpUsers", U.city, O.rs_org, O.cp AS "cpOrga", O.address, O.phone AS "phoneOrga" FROM users U
        INNER JOIN organisation O ON O.org_id = U.orga
        WHERE U.users_id = :bind_usersid');
        $stmt->bindParam(':bind_usersid', $search, PDO::PARAM_INT, 5);
        $stmt->execute();

        $result = $stmt->fetch();

        $tmp = "<h3>";
        $tmp .= "Vous";
        $tmp .= "</h3>";
        $tmp .= "<ul>";
            $tmp .= "<li><span>Nom:</span> ";
            $tmp .= $result['lastname'];
            $tmp .= "</li>";
            $tmp .= "<li><span>Prénom:</span> ";
            $tmp .= $result['firstname'];
            $tmp .= "</li>";
            $tmp .= "<li><span>Téléphone:</span> ";
            $tmp .= $result['phoneUsers'];
            $tmp .= "</li>";
            $tmp .= "<li><span>Adresse Mail:</span> ";
            $tmp .= $result['mail'];
            $tmp .= "</li><br>";
            $tmp .= "<li><b>Adresse</b></li>";
            $tmp .= "<li><span>Code postal:</span> ";
            $tmp .= $result['cpUsers'];
            $tmp .= "</li>";
            $tmp .= "<li><span>Ville:</span> ";
            $tmp .= $result['city'];
            $tmp .= "</li><br>";
            $tmp .= "<li><b>Entreprise</b></li>";
            $tmp .= "<li><span>Nom:</span> ";
            $tmp .= $result['rs_org'];
            $tmp .= "</li>";
            $tmp .= "<li><span>Téléphone:</span> ";
            $tmp .= $result['phoneOrga'];
            $tmp .= "</li>";
            $tmp .= "<li><span>Code postal:</span> ";
            $tmp .= $result['cpOrga'];
            $tmp .= "</li>";
            $tmp .= "<li><span>Adresse:</span> ";
            $tmp .= $result['address'];
            $tmp .= "</li>";
        $tmp .= "</ul>";

        return $tmp;
    }


    // OBTENIR LES INFOS DE LA RESERVATION EN COURS
    function obtainInfoReservActu($typeRess, $ress, $nbp, $date, $pdo) {
        $tmp = "<h3>";
        $tmp .= "Votre reservation";
        $tmp .= "</h3>";
        $tmp .= "<ul>";
            $tmp .= "<li><span>Type de bureau:</span> ";
            $tmp .= obtainInfoTypeRess($typeRess, $pdo);
            $tmp .= "</li>";
            $tmp .= "<li><span>Bureau:</span> ";
            $tmp .= obtainInfoRess('label', $ress, $pdo);
            $tmp .= "</li>";
            $tmp .= "<li><span>Nombre de place:</span> ";
            $tmp .= $nbp;
            $tmp .= "</li><br>";
            $tmp .= "<li><span>Date:</span> ";
            $tmp .= $date;
            $tmp .= "</li>";
        $tmp .= "</ul><br>";
        $tmp .= "<div>";
        $tmp .= "<h3 id=\"titleExtras\">Extras</h3>";
        $tmp .= "<span id=\"listExtrasPc\"><i>Aucun extras</i></span><br>";
        $tmp .= "<span id=\"listExtrasPlPark\"></span>";
        $tmp .= "</div>";

        return $tmp;
    }


    // OBTENIR LA LISTE DES RESERVATIONS SOUS FORME D'ACCORDEON
    function listReservAccor($pdo) {
        $stmt = $pdo->prepare('SELECT R.res_id, R.date, TR.label AS "labelTypeRess", RS.type_ress AS "codeTypeRess", RS.label AS "ress", RS.nb_place, RS.serial_number FROM reservation R
            INNER JOIN line_reservation LR ON R.res_id = LR.reserv
            INNER JOIN ressource RS ON LR.ress = RS.ress_id
            INNER JOIN type_ress TR ON RS.type_ress = TR.type_code
            WHERE R.users = :bind_usersid ORDER BY R.date, RS.type_ress');
        $stmt->bindParam(':bind_usersid', $_SESSION['users']['id'], PDO::PARAM_INT, 5);
        $stmt->execute();

        $tmp = "";
        $result = $stmt->fetchAll();
        if ($stmt->rowCount() != 0) {
            foreach ($result as $data) {
                $tmpRess = "";
                foreach ($result as $dataRess) {
                    if ($dataRess['date'] == $data['date']) {
                        if ($dataRess['codeTypeRess'] == "PC") {
                            $ressLabel = $dataRess['ress'];
                            $serialNum = $dataRess['serial_number'];
                            $tmpRess .= "
                                <span>
                                    <p>Ordinateur: $ressLabel</p>
                                    <p>$serialNum</p>
                                </span>
                            ";
                        } elseif ($dataRess['codeTypeRess'] == "PK") {
                            $ressLabel = $dataRess['ress'];
                            $tmpRess .= "
                                <span>
                                    <p>Stationnement</p>
                                    <p>Place $ressLabel</p>
                                </span>
                            ";
                        }
                    }
                }
                if ($data['codeTypeRess'] == "BI" OR $data['codeTypeRess'] == "OS" OR $data['codeTypeRess'] == "MR") {
                    $resId = $data['res_id'];
                    $date = date('d/m/Y', strtotime($data['date']));
                    $labelTypeRess = $data['labelTypeRess'];
                    $ressLabel = $data['ress'];
                    $nbPlace = $data['nb_place'];
                    $tmp .= "
                        <div class=\"accordion\">
                            <input type=\"radio\" name=\"radio-b\" id=\"accorReserv$resId\">
                            <label for=\"accorReserv$resId\">$date</label>
                            <div class=\"accordion-content-reserv\">
                                <div>
                                    <span>
                                        <p>$labelTypeRess</p>
                                        <p>Bureau $ressLabel</p>
                                    </span>
                                    <span>
                                        <p>$nbPlace place</p>
                                    </span>
                                </div>
                                <fieldset>
                                    <legend>Ressource</legend>
                                    $tmpRess
                                </fieldset>
                                <button class=\"btn\" onclick=\"alert('flemme mais tien l\'id: $resId');\">Détail</button>
                            </div>
                        </div>
                    ";
                }
            }
        } else {
            $tmp .= "<h3 id=\"error\">Aucune réservation</h3>";
        }

        return $tmp;
    }


    // OBTENIR LES INFOS DE SON ABONNEMENT
    function infoMySub($pdo) {
        $stmt = $pdo->prepare('SELECT S.label, S.price, HS.date, S.duration FROM subscription S
            INNER JOIN history_sub HS ON S.sub_id = HS.sub
            WHERE HS.users = :bind_usersid');
        $stmt->bindParam(':bind_usersid', $_SESSION['users']['id'], PDO::PARAM_INT, 5);
        $stmt->execute();

        $tmp = "";
        $result = $stmt->fetch();
        if ($stmt->rowCount() != 0) {
            $label = $result['label'];
            $date = date('d/m/Y', strtotime($result['date']));
            $price = $result['price'].'€';
            if ($result['label'] == "Journalier") {
                $duree = $result['duration']." jour(s)";
                $dateEnd = date('d/m/Y', strtotime($result['date']." +".$result['duration']."day"));
            } elseif ($result['label'] == "Hebdomadaire") {
                $duree = $result['duration']." semaine(s)";
                $dateEnd = date('d/m/Y', strtotime($result['date']." +".$result['duration']."week"));
            } else {
                $duree = $result['duration']." mois";
                $dateEnd = date('d/m/Y', strtotime($result['date']." +".$result['duration']."month"));
            }
            $tmp .= "
                <span>
                    <p>$label</p>
                    <p>
                        Durée de $duree<br>
                        Fin : $dateEnd
                    </p>
                </span>
                <span>
                    <p>$price/mois</p>
                    <p>$date</p>
                </span>
            ";
        } else {
            $tmp .= "
                <p id=\"error\">Aucun abonnement actif</p>
            ";
        }

        return $tmp;
    }


    // OBTENIR LES INFOS DE SON ABONNEMENT
    function infoMyOrga($pdo) {
        $stmt = $pdo->prepare('SELECT O.rs_org AS "rs", O.cp, O.address, O.phone FROM organisation O
            INNER JOIN users U ON O.org_id = U.orga
            WHERE U.users_id = :bind_usersid');
        $stmt->bindParam(':bind_usersid', $_SESSION['users']['id'], PDO::PARAM_INT, 5);
        $stmt->execute();

        $tmp = "";
        $result = $stmt->fetch();
        if ($stmt->rowCount() != 0) {
            $rs = $result['rs'];
            $cp = $result['cp'];
            $address = $result['address'];
            $phone = implode(".", str_split($result['phone'], 2));
            $tmp .= "
                <span>
                    <p>$rs</p>
                </span>
                <span>
                    <p>$address</p>
                    <p><b>$cp</b></p>
                    <p>$phone</p>
                </span>
            ";
        } else {
            $tmp .= "
                <p id=\"error\">Aucune organisation active</p>
                <p>Error: Contactez le support</p>
            ";
        }

        return $tmp;
    }


    // SAVOIR SI UN UTILISATEUR EST SUB
    function usersIsSub($pdo) {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM subscription S
            INNER JOIN history_sub HS ON S.sub_id = HS.sub
            WHERE HS.users = :bind_usersid');
        $stmt->bindParam(':bind_usersid', $_SESSION['users']['id'], PDO::PARAM_INT, 5);
        $stmt->execute();

        $result = $stmt->fetchColumn();
        if ($result == 0) {
            return false;
        } else {
            return true;
        }
    }
?>