<!-- PUNTO DI PARTENZA DEI FILE -->

<!-- PAGINA DI LOGIN / REGISTRAZIONE -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="./login/style.css">
</head>
<body>
    <div class="wrapper">
        <div class="form-wrapper sign-in">
            <form action="login.php" method="post">
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
            <form action="register.php" method="post">
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
                    <input type="password" name="password" required>
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
    <script src="script.js"></script>
</body>
</html>
