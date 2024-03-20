<!-- PUNTO DI PARTENZA DEI FILE -->

<?php
session_start();


// Controlla se è stato impostato un messaggio di errore
if (isset($_SESSION['error_message'])) {
    echo "<script>alert('{$_SESSION['error_message']}');</script>";
    // Dopo aver mostrato l'alert, rimuove il messaggio di errore
    unset($_SESSION['error_message']);
}

// Controlla se è stato impostato un messaggio di successo
if (isset($_SESSION['success_message'])) {
    echo "<script>alert('{$_SESSION['success_message']}');</script>";
    // Dopo aver mostrato l'alert, rimuove il messaggio di successo
    unset($_SESSION['success_message']);
}
// Cancella tutte le variabili di sessione
$_SESSION = array();

// Cancella il cookie di sessione
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Cancella la sessione
session_destroy();
?>

<!-- PUNTO DI PARTENZA DEI FILE -->
<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Per modificare l'icona nella tab del browser -->
    <link rel="icon" href="img/login.png" type="image/png">
    <!-- --------------------------------------------- -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="./login/style.css">
</head>
<body>
<div class="wrapper">
    <div class="form-wrapper sign-in">
        <form action="./login/login.php" method="post">
            <h2>Login</h2>
            <div class="input-group">
                <input type="text" name="login_username" required>
                <label for="">Username</label>
            </div>

            <div class="input-group">
                <input type="password" name="login_password" required>
                <label for="">Password</label>
            </div>

            <div class="remember">
                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>
            </div>
            <button type="submit" name="login_submit">Login</button>
            <div class="signUp-link">
                <p>Don't have an account? <a href="#" class="signUpBtn-link">Sign up</a></p>
            </div>
        </form>
    </div>

    <div class="form-wrapper sign-up">
        <form action="./login/register.php" method="post">
            <h2>Sign Up</h2>
            <div class="input-group">
                <input type="text" name="username" required>
                <label for="">Username</label>
            </div>
            <div class="input-group">
                <input type="email" name="email" required>
                <label for="">Email</label>
            </div>

            <div class="input-group">
                <input type="password" id="password" name="password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Deve contenere almeno una lettera maiuscola, una minuscola, un numero e deve essere lunga almeno 8 caratteri" required>
                <label for="">Password</label>
            </div>

            <div class="remember">
                <label>
                    <input type="checkbox" name="agree"> I agree to the terms and conditions
                </label>
            </div>
            <button type="submit" name="register_submit">Sign Up</button>
            <div class="signUp-link">
                <p>Already have an account? <a href="#" class="signInBtn-link">Sign In</a></p>
            </div>
        </form>
    </div>
</div>
<script src="./login/script.js"></script>
</body>
</html>
