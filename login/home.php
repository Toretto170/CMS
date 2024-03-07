<?php
session_start();

// Check per vedere se l'utente si è autenticato
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location: main.php");
    exit;
}
?>

<!-- LANDING PAGE -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        p {
            color: #666;
            margin-top: 20px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Welcome!</h1>
    <p>Thank you for registering/logging in. You are now part of our community.</p>
    <p> This is your home page </p>
    <p>If you want to explore your template, please do so <a href="collection_templates.php">here</a>.</p>
    <p>If you want to create a new webpage, please do so  <a href="web_editor.php">here</a>.</p>
    <p>Logout <a href="logout.php">here</a>.</p>
</div>
</body>
</html>
