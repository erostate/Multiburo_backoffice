<?php
    session_start();
?>
<!--
    MULTIBURO
    Accueil
-->
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>MULTIBURO</title>
    <?php include_once 'inc/db.inc.php'; ?>
    <?php include_once 'inc/fonctions.inc.php'; ?>
</head>
<body>
    <!-- HEADER -->
    <header>
        <?php
            if (!isset($_SESSION['users']['id'])) {
                echo "<h1>MULTIBURO</h1>";
                echo "<button class=\"btn btn-login\" onclick=\"window.location.href='login'\">Se connecter</button>";
            } else {
                echo "<button class=\"btn btn-home\" onclick=\"window.location.href='dash/index'\">Panel</button>";
                echo "<h1>MULTIBURO</h1>";
                echo "<button class=\"btn btn-login\" onclick=\"window.location.href='inc/backend/logout'\">Se déconnecter</button>";
            }
        ?>
    </header>

    <!-- HERO -->
    <section id="hero-sect">
        <img src="assets/img/hero_test2.jpg" alt="Hero banner">
        <!-- <h2>Besoin d'un espace de travail ?</h2> -->
    </section>

    <!-- PLAN -->
    <section id="plan-sect">
        <div>
            <h1>Nos plans</h1>
            <select id="sortBy" onchange="changeSortPlan(this);">
                <option select value="day">Prix par : Jour</option>
                <option value="week">Prix par : Semaine</option>
                <option value="month">Prix par : Mois</option>
            </select>
        </div>
        <div class="pricing-table">
            <div class="pricing-box">
                <div class="pricing-header">
                    <h2>Bureau individuel</h2>
                    <p class="pricing-price" id="priceBurInd">à partir de 15€/jour</p>
                </div>
                <?php
                    if (isset($_SESSION['users']['id']))
                        echo "<span class=\"seeMore\" onclick=\"buyPlan('BI');\">En savoir plus</span>";
                    else
                        echo "<span class=\"seeMore\" onclick=\"window.location.href='login'\">En savoir plus</span>";
                ?>
                <div class="pricing-nbPlace">
                    <label for="nbPlaceBurInd">Nombre de place voulu<span>*</span></label>
                    <input id="nbPlaceBurInd" onkeyup="checkNbPlaceCorrect(this, 'BI');" type="number" min="1" max="10" value="1" name="" id="">
                    <p id="errorNbPlaceBurInd">Le nombre de place doit être compris entre 1 et 10</p>
                </div>
                <ul>
                    <li>
                        <svg class="icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z"/>
                            <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"/>
                        </svg>
                        Isolé du bruit
                    </li>
                    <li>
                        <svg class="icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z"/>
                            <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"/>
                        </svg>
                        Usage par une personne
                    </li>
                </ul>
            </div>
            <div class="pricing-box">
                <div class="pricing-header">
                    <h2>Bureau en Open space</h2>
                    <p class="pricing-price" id="priceBurCol">à partir de 15€/jour</p>
                </div>
                <?php
                    if (isset($_SESSION['users']['id']))
                        echo "<span class=\"seeMore\" onclick=\"buyPlan('OS');\">En savoir plus</span>";
                    else
                        echo "<span class=\"seeMore\" onclick=\"window.location.href='login'\">En savoir plus</span>";
                ?>
                <div class="pricing-nbPlace">
                    <label for="nbPlaceBurCol">Nombre de place voulu<span>*</span></label>
                    <input id="nbPlaceBurCol" onkeyup="checkNbPlaceCorrect(this, 'OS');" type="number" min="1" max="10" value="1" name="" id="">
                    <p id="errorNbPlaceBurCol">Le nombre de place doit être compris entre 1 et 10</p>
                </div>
                <ul>
                    <li>
                        <svg class="icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z"/>
                            <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"/>
                        </svg>
                        Seul ou à plusieurs
                    </li>
                    <li>
                        <svg class="icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z"/>
                            <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"/>
                        </svg>
                        Coucou toi
                    </li>
                </ul>
            </div>
            <div class="pricing-box pricing-table-best">
                <div class="pricing-header">
                    <h2>Salle de réunion</h2>
                    <p class="pricing-price" id="priceSalReu">à partir de 25€/jour</p>
                </div>
                <?php
                    if (isset($_SESSION['users']['id']))
                        echo "<span class=\"seeMore\" onclick=\"buyPlan('MR');\">En savoir plus</span>";
                    else
                        echo "<span class=\"seeMore\" onclick=\"window.location.href='login'\">En savoir plus</span>";
                ?>
                <div class="pricing-nbPlace">
                    <label for="nbPlaceSalReu">Nombre de place voulu<span>*</span></label>
                    <input id="nbPlaceSalReu" onkeyup="checkNbPlaceCorrect(this, 'MR');" type="number" min="10" max="30" value="10" name="" id="">
                    <p id="errorNbPlaceSalReu">Le nombre de place doit être compris entre 10 et 30</p>
                </div>
                <ul>
                    <li>
                        <svg class="icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z"/>
                            <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"/>
                        </svg>
                        Salle avec beaucoup de place
                    </li>
                    <li>
                        <svg class="icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z"/>
                            <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"/>
                        </svg>
                        Isolé du bruit
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <h1>Coucou</h1>
    </footer>

    <script src="assets/script.js"></script>
</body>
</html>