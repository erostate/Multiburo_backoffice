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
                <input class="radio_faq" type="radio" name="radio-a" id="check1" checked>
                <label class="accordion-label" for="check1">Votre abonnement</label>
                <div class="accordion-content">
                    <span>
                        <p>Mensuel</p>
                        <p>02/05/2023</p>
                    </span>
                    <span>
                        <p>100€/mois</p>
                    </span>
                </div>
            </div>
            <div class="accordion">
                <input class="radio_faq" type="radio" name="radio-a" id="check2">
                <label class="accordion-label" for="check2">Votre organisation</label>
                <div class="accordion-content">
                    <span>
                        <p>IGICOM</p>
                    </span>
                    <span>
                        <p>12 route de Marenne</p>
                        <p><b>69360</b></p>
                        <p>06 55 55 55 55</p>
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <h1>Coucou</h1>
    </footer>

    <script src="../assets/script.js"></script>
</body>
</html>