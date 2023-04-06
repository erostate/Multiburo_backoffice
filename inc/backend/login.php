<?php
    session_start();
    include_once '../db.inc.php';
    include_once '../fonctions.inc.php';

    if (isset($_POST['mail']) && isset($_POST['password'])) {
        $mail = $_POST['mail'];
        $password = hash('sha256', $_POST['password']);
        $stmt = $pdo->prepare('SELECT users_id FROM users WHERE mail = :cnx_mail AND password = :cnx_password');
        $stmt->bindParam(':cnx_mail', $mail, PDO::PARAM_STR, 30);
        $stmt->bindParam(':cnx_password', $password, PDO::PARAM_STR, 200);
        $stmt->execute();

        if ($dataUser = $stmt->fetch()) {
            $_SESSION['users']['id'] = $dataUser['users_id'];
            header('Location: ../../index');
        } else {
            header('Location: ../../login?r=register');
        }
    }
?>