<?php
    session_start();
    if (!isset($_SESSION['users']['id'])) {
        header('Location: ../login.php');
    }
?>
<!--
    MULTIBURO
    Accueil Panel
-->
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="../assets/script.js"></script>
    <script src="../assets/ajax.js"></script>
    <title>MULTIBURO</title>
    <?php include_once '../inc/db.inc.php'; ?>
    <?php include_once '../inc/fonctions.inc.php'; ?>
</head>
<body>
    <?php
        if (isset($_GET['r']))
            $r = $_GET['r'];
        
        if (isset($_GET['sb']))
            $sb = $_GET['sb'];
        
        if (isset($_GET['nbp']))
            $nbp = $_GET['nbp'];
        
        if (isset($_GET['da']))
            $da = $_GET['da'];
    ?>
    <!-- HEADER -->
    <header>
        <button class="btn btn-home" onclick="window.location.href='../index.php'">Accueil</button>
        <h1>MULTIBURO</h1>
        <button class="btn btn-login" onclick="window.location.href='../inc/backend/logout.php'">Se déconnecter</button>
    </header>

    <!-- PURCHASE -->
    <section id="purchase-sect">
        <h2>Indiquez la journée souhaitée</h2>
        <form action="../inc/backend/dateDispo.php" method="POST">
            <?php
                if (isset($_GET['da']) && isset($_SESSION['reserv']['date'])) {
                    if ($_GET['da'] != "none")
                        echo '<input type="date" name="dateReserv" value="'.$_SESSION['reserv']['date'].'" id="">';
                    else
                        echo '<input type="date" name="dateReserv" id="">';
                }
                else
                    echo '<input type="date" name="dateReserv" id="">';
            ?>
            <input type="hidden" name="r" value="<?= $_GET['r']; ?>">
            <input type="hidden" name="sb" value="<?= $_GET['sb']; ?>">
            <input type="hidden" name="nbp" value="<?= $_GET['nbp']; ?>">
            <button class="btn" type="submit">Vérifier la disponibilité</button>
        </form>
    </section>

    <!-- PURCHASE NEXT STEP -->
    <section id="purch-next-step">
        <?php
            if (isset($_GET['da'])) {
                $da = $_GET['da'];
                if ($da == "none") {
                    echo "<p style='color: red;'>Aurevoir</p>";
                } else {
                    $maxPcAv = returnMaxExtraAvailable('PC', $_SESSION['reserv']['date'], $pdo);
                    $maxPlParkAv = returnMaxExtraAvailable('PK', $_SESSION['reserv']['date'], $pdo);
                    $sessReservRoom = obtainInfoRess('label', $_SESSION['reserv']['room'], $pdo);
                    $typeRess = obtainInfoTypeRess($r, $pdo);
                    $myInfo = obtainInfoUser($_SESSION['users']['id'], $pdo);
                    $reservInfo = obtainInfoReservActu($_GET['r'], $_SESSION['reserv']['room'], $_GET['nbp'], $_SESSION['reserv']['date'], $pdo);

                    if (!isset($_SESSION['reserv']['listExtrasPc'])) {
                        $_SESSION['reserv']['listExtrasPc'] = [];
                    }
                    if (!isset($_SESSION['reserv']['listExtrasPlPark'])) {
                        $_SESSION['reserv']['listExtrasPlPark'] = [];
                    }
                    echo "
                        <h3><span>$da</span> ressource(s) disponible(s)</h3>
                        <p><span>$typeRess</span> attribué : <span>$sessReservRoom</span></p>
                        <p>Souhaitez-vous louer des extras ?</p>
                        <div id=\"bodyExtras\">
                            <fieldset id=\"fieldsetPc\">
                                <legend>Ordinateur</legend>
                                <div>
                                    <button class=\"btn-add-extras\" name=\"editExtrasPc\" value=\"add\">+</button>
                                    <button class=\"btn-add-extras\" name=\"editExtrasPc\" value=\"rem\">-</button>
                                </div>
                                <span id=\"nbExtrasPc\" style=\"float: left;\">0</span>
                            </fieldset>
                            <div id=\"infoExtras\">
                                <input type=\"hidden\" id=\"inpExtrasPc\" value=\"0\" max=\"$maxPcAv\">
                                <input type=\"hidden\" id=\"inpExtrasPlPark\" value=\"0\" max=\"$maxPlParkAv\">
                            </div>
                            <fieldset id=\"fieldsetPlPark\">
                                <legend>Place de parking</legend>
                                <div>
                                    <button class=\"btn-add-extras\" name=\"editExtrasPlPark\" value=\"add\">+</button>
                                    <button class=\"btn-add-extras\" name=\"editExtrasPlPark\" value=\"rem\">-</button>
                                </div>
                                <span id=\"nbExtrasPlPark\" style=\"float: right;\">0</span>
                            </fieldset>
                        </div>
                        <div id=\"orderSummary\">
                            <h2>Résumé</h2>
                            <hr>
                            <div class=\"body-order-summary\">
                                <div id=\"aboutUser\">
                                    $myInfo
                                </div>
                                <div id=\"aboutReserv\">
                                    $reservInfo
                                </div>
                            </div>
                        </div>
                        <div id=\"goToNextStep\">
                            <form action=\"../inc/backend/createReserv.php\" method=\"POST\">
                                <input type=\"hidden\" name=\"ress\" value=\"".$_SESSION['reserv']['room']."\">
                                <input type=\"hidden\" name=\"date\" value=\"".$_SESSION['reserv']['date']."\">
                                <button type=\"button\" class=\"btn\">Annuler</button>
                                <button type=\"submit\" class=\"btn\">Valider</button>
                            </form>
                        </div>
                    ";
                }
            }
        ?>
    </section>

    <!-- FOOTER -->
    <footer>
        <h1>Coucou</h1>
    </footer>
</body>
</html>