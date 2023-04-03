<?php
    session_start();
    if (!isset($_SESSION['users']['id'])) {
        header('Location: ../index.php');
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
    <title>MULTIBURO</title>
    <?php include_once '../inc/db.inc.php'; ?>
    <?php include_once '../inc/fonctions.inc.php'; ?>
</head>
<body>
    <!-- HEADER -->
    <header>
        <button class="btn btn-home" onclick="window.location.href='../index.php'">Accueil</button>
        <h1>MULTIBURO</h1>
        <button class="btn btn-login" onclick="window.location.href='../inc/backend/logout.php'">Se déconnecter</button>
    </header>

    <!-- YOUR PLAN -->
    <section id="my-plan-sect">
        <h1>Votre plan</h1>
        <div class="accordion-wrapper">
            <div class="accordion">
                <input type="radio" name="radio-a" id="accorSub" checked>
                <label for="accorSub">Votre abonnement</label>
                <div class="accordion-content">
                    <?php
                        echo infoMySub($pdo);
                    ?>
                </div>
            </div>
            <div class="accordion">
                <input type="radio" name="radio-a" id="accorOrg">
                <label for="accorOrg">Votre organisation</label>
                <div class="accordion-content">
                    <?php
                        echo infoMyOrga($pdo);
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- YOUR RESERVATION -->
    <section id="reserv-sect">
        <div class="accordion-header-reserv">
            <span>
                <h1>Vos réservations</h1>
                <p>Cliquer pour plus d'infos</p>
            </span>
            <a href="../index.php#plan-sect">Nouvelle réservation</a>
        </div>
        <div class="accordion-wrapper">
            <?php
                echo listReservAccor($pdo);
            ?>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <h1>Coucou</h1>
    </footer>

    <script src="../assets/script.js"></script>
</body>
</html>