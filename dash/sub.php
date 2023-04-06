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
        <button class="btn btn-home" onclick="window.location.href='../index'">Accueil</button>
        <h1>MULTIBURO</h1>
        <button class="btn btn-login" onclick="window.location.href='../inc/backend/logout'">Se déconnecter</button>
    </header>

    <!-- SUB -->
    <?php
        if (usersIsSub($pdo) == true) {
            echo "
                <section id=\"sub-sect\">
                    <h2>Souhaitez vous prolonger votre abonnement ?</h2>
                    <form action=\"../inc/backend/sub.php\" method=\"POST\">
                        <select class=\"inp\" name=\"typeSub\" onchange=\"changeTypeSub('old', this);\">
                            <option disabled selected>Choisir la durée du prolongement</option>
                            <option value=\"day\">Jour</option>
                            <option value=\"week\">Semaine</option>
                            <option value=\"month\">Mois</option>
                        </select>
                        <div id=\"confirmSub\"></div>
                    </form>
                </section>
            ";
        } else {
            echo "
                <section id=\"sub-sect\">
                    <h2>Vous de disposez pas d'abonnement</h2>
                    <form action=\"../inc/backend/sub.php\" method=\"POST\">
                        <select class=\"inp\" name=\"typeSub\" onchange=\"changeTypeSub('new', this);\">
                            <option disabled selected>Choisir le type d'abonnement</option>
                            <option value=\"day\">Journalier</option>
                            <option value=\"week\">Hebdomadaire</option>
                            <option value=\"month\">Mensuel</option>
                        </select>
                        <div id=\"confirmSub\"></div>
                    </form>
                </section>
            ";
        }
    ?>

    <!-- FOOTER -->
    <footer>
        <h1>Coucou</h1>
    </footer>
</body>
</html>