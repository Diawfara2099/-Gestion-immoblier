<?php
require('../../Database/utilisateur_db.php');

if (isset($_POST['send'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $check = getUserByEmail($email);

            if ($check->rowCount() > 0) {
                $userInfos = $check->fetch();
                if (password_verify($password, $userInfos['password'])) {
                    session_start();
                    $_SESSION['auth'] = true;
                    $_SESSION['id'] = $userInfos['id'];
                    $_SESSION['nom'] = $userInfos['nom'];
                    $_SESSION['prenom'] = $userInfos['prenom'];
                    $_SESSION['email'] = $userInfos['email'];
                    $_SESSION['type'] = $userInfos['type'];
                    header('Location: ../../index.php');
                    exit();
                } else {
                    $errorMessage = "Mot de passe incorrect !";
                }
            } else {
                $errorMessage = "Email incorrect !";
            }
        } else {
            $errorMessage = "Veuillez saisir un email valide !";
        }
    } else {
        $errorMessage = "Veuillez remplir les champs obligatoires !";
    }
}
?>
