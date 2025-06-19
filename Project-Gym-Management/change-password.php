<?php
session_start();
include('dbcon.php');

// Vérifie si l'utilisateur est connecté en tant qu'admin
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Traitement du changement de mot de passe
if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $old_password = mysqli_real_escape_string($con, $_POST['old_password']);
    $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
    $new_password_confirm = mysqli_real_escape_string($con, $_POST['new_password_confirm']);

    // Hashage des mots de passe

    
    //$old_password_hashed = md5($old_password);
    //$new_password_hashed = md5($new_password);

    // Ajout nouveau mot de passe plus sécurisé avec bcrypt au lieu de md5()

    // Pour l'insertion dans la base de données
    $new_password_hashed = password_hash($new_password, PASSWORD_BCRYPT);

    // Pour vérifier le mot de passe actuel
    if (password_verify($current_password, $row['password'])) {
    // Mot de passe correct, vous pouvez mettre à jour le mot de passe
    $update_query = mysqli_query($con, "UPDATE admin SET password='$new_password_hashed' WHERE user_id='$user_id'");
    }


    // Vérifie si l'ancien mot de passe est correct
    $query = mysqli_query($con, "SELECT * FROM admin WHERE user_id = '$user_id' AND password = '$old_password_hashed'");
    if (mysqli_num_rows($query) > 0) {
        if ($new_password === $new_password_confirm) {
            // Mettre à jour le mot de passe
            $update_query = mysqli_query($con, "UPDATE admin SET password = '$new_password_hashed' WHERE user_id = '$user_id'");
            if ($update_query) {
                echo "<div class='alert alert-success'>Mot de passe changé avec succès.</div>";
            } else {
                echo "<div class='alert alert-danger'>Erreur lors de la mise à jour du mot de passe.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Les nouveaux mots de passe ne correspondent pas.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>L'ancien mot de passe est incorrect.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Changer le mot de passe - Admin</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Changer le mot de passe</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="old_password">Ancien mot de passe :</label>
                <input type="password" name="old_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="new_password">Nouveau mot de passe :</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="new_password_confirm">Confirmer le nouveau mot de passe :</label>
                <input type="password" name="new_password_confirm" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Changer le mot de passe</button>
        </form>
    </div>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
