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
?>