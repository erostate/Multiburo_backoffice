<!--
    MULTIBURO
    Connexion
-->
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>MULTIBURO</title>
    <?php
        include_once 'inc/db.inc.php';
        include_once 'inc/fonctions.inc.php';
        if (isset($_GET['r']) && !empty($_GET['r'])) {
            $error = $_GET['r'];
        } else {
            $error = '';
        }
    ?>
</head>
<body>
    <!-- HEADER -->
    <header>
        <button class="btn btn-home" onclick="window.location.href='index.php'">Accueil</button>
        <h1>MULTIBURO</h1>
    </header>

    <!-- LOGIN -->
    <section id="login-sect">
        <?php
            if ($error == "register") {
                echo "
                <form action='inc/backend/login.php' method='post'>
                    <input style='margin-top: 300px;' type='text' name='mail' placeholder='Adresse mail'>
                    <input style='margin-top: 300px;' type='text' name='mail' placeholder='Adresse mail'>
                    <input style='margin-top: 300px;' type='text' name='mail' placeholder='Adresse mail'>
                    <br><br>
                    <button type='submit'>Valider</button>
                </form>
                ";
            } else {
                echo "
                <form class='form-group' action='inc/backend/login.php' method='POST'>
                    <fieldset>
                        <legend>Formulaire de connexion</legend>
                        <div class='form-control' id='inpLogin'>
                            <input type='value' name='mail' required>
                            <label>
                                <span style='transition-delay:0ms'>A</span>
                                <span style='transition-delay:30ms'>d</span>
                                <span style='transition-delay:60ms'>r</span>
                                <span style='transition-delay:90ms'>e</span>
                                <span style='transition-delay:120ms'>s</span>
                                <span style='transition-delay:150ms'>s</span>
                                <span style='transition-delay:180ms'>e</span>
                                <span style='transition-delay:210ms'></span>
                                <span style='transition-delay:240ms'>M</span>
                                <span style='transition-delay:270ms'>a</span>
                                <span style='transition-delay:300ms'>i</span>
                                <span style='transition-delay:330ms'>l</span>
                            </label>
                        </div>
                        <div class='form-control' id='inpLogin'>
                            <input type='password' name='password' required>
                            <label>
                                <span style='transition-delay:0ms'>M</span>
                                <span style='transition-delay:30ms'>o</span>
                                <span style='transition-delay:60ms'>t</span>
                                <span style='transition-delay:90ms'></span>
                                <span style='transition-delay:120ms'>d</span>
                                <span style='transition-delay:150ms'>e</span>
                                <span style='transition-delay:180ms'></span>
                                <span style='transition-delay:210ms'>p</span>
                                <span style='transition-delay:240ms'>a</span>
                                <span style='transition-delay:270ms'>s</span>
                                <span style='transition-delay:300ms'>s</span>
                                <span style='transition-delay:330ms'>e</span>
                            </label>
                        </div>
                        <div class='form-control'>
                            <button class='btn_login'>
                                <div class='text'>
                                    <span>Se</span>
                                    <span>connecter</span>
                                </div>
                                <div class='clone'>
                                    <span>Se</span>
                                    <span>connecter</span>
                                </div>
                            </button>
                        </div>
                    </fieldset>
                </form>
                ";
            }
        ?>
    </section>

    <script src="assets/script.js"></script>
</body>
</html>