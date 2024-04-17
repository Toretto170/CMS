<?php
global $conn;
session_start();

include("../modules/connection_db.php");
include("../modules/authentication_user.php");

// query per ottenere l'username e mostrarlo poi sulla landing page
$user_id = $_SESSION['user_id'];
$sql = "SELECT username FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$username = $row['username'];
$stmt->close();

?>


<!-- Landing Page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="home_style.css">
</head>
<body>
<header>
    <div class="navbar">
        <ul class="links">
            <li><a href="home.php">Home</a></li>
            <li><a href="../web-editor/web_editor.php">Web Editor</a></li>
            <li><a href="../templates/collection_templates.php">Collection Templates</a></li>
        </ul>
        <div class="user">
            <img src="../img/user.png" id="user">
            <div class="user-menu">
                <ul class="hover-menu">
                    <li><a href="./logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
        <div class="toggle_btn">
            <i class="fa-solid fa-bars"></i>
        </div>
        <div class="dropdown_menu">
            <li><a href="home.php">Home</a></li>
            <li><a href="../web-editor/web_editor.php">Web Editor</a></li>
            <li><a href="../templates/collection_templates.php">Collection Templates</a></li>
            <li><a href="./logout.php">Logout</a></li>
        </div>
    </div>
</header>

<main>
    <section id="home">
        <h1> Welcome aboard, <?php echo $username; ?>! </h1>
        <p>
            We're thrilled to have you join our team<br/>We can't wait to see the amazing things we'll achieve together.
            <br/>
        </p>
    </section>
</main>

<script>
    const toggleBtn = document.querySelector('.toggle_btn')
    const toggleBtnIcon = document.querySelector('.toggle_btn i')
    const dropDownMenu = document.querySelector('.dropdown_menu')

    toggleBtn.onclick = function () {
        dropDownMenu.classList.toggle('open');
        const isOpen = dropDownMenu.classList.contains('open')

        toggleBtnIcon.classList = isOpen
            ? 'fa-solid fa-bars'
            : 'fa-solid fa-bars'

    }
</script>
</body>
</html>