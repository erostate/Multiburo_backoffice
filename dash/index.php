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
                <label class="accordion-label" for="check1">How do I purchase?</label>
                <div class="accordion-content">
                    <p>Your payment will go through Tebex, who is the official FiveM partner when it comes to buying assets. After your purchase, you will be able to download your files instantly.</p>
                </div>
            </div>
            <div class="accordion">
                <input class="radio_faq" type="radio" name="radio-a" id="check2">
                <label class="accordion-label" for="check2">How do I reach out to get support?</label>
                <div class="accordion-content">
                    <p>We would love to count you within our community members, feel free to <a style="text-decoration-line: underline;" target="_blank" href="https://bs-scripts.space/">join our Discord</a>.</p>
                </div>
            </div>
            <div class="accordion">
                <input class="radio_faq" type="radio" name="radio-a" id="check3">
                <label class="accordion-label" for="check3">How much time is needed for my server to be whitelisted?</label>
                <div class="accordion-content">
                    <p>You don't have to do anything for your server to be whitelisted. Granting access to your server is automated and instant.</p>
                </div>
            </div>
            <div class="accordion">
                <input class="radio_faq" type="radio" name="radio-a" id="check4">
                <label class="accordion-label" for="check4">Do I need a specific FiveM server version to run it properly?</label>
                <div class="accordion-content">
                    <p>We highly recommend you to update your server build to 4793+ to avoid crashes. We are using new features from Cfx.re, which work smoothly on the latest server artifacts.</p>
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