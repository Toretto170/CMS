<?php
$filepath = "pathdelfilezippato";

//  if ($_SERVER['REQUEST_METHOD'] === 'POST') {


$host = 'localhost';
$username = 'root';
$password = '';
$database = 'login';


$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die('Connection failed : ' . $conn->connect_error);
}
echo "Connected successfully. \r\n";


$zip = new ZipArchive;
if ($zip->open($filepath) === TRUE) {

    $html = $zip->getFromName('index.html');
    $css = $zip->getFromName('css/style.css');
    $zip->close();


    $sql_create_table = "CREATE TABLE IF NOT EXISTS test_html (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            html LONGTEXT NOT NULL,
            css LONGTEXT NOT NULL,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";

    if ($conn->query($sql_create_table) === TRUE) {
        echo "Table created successfully. \r\n";
    } else {
        echo 'Error creating table: ' . $conn->error;
    }


    $html = mysqli_real_escape_string($conn, $html);
    $css = mysqli_real_escape_string($conn, $css);


    $sql_insert_data = "INSERT INTO test_html (html, css, reg_date) VALUES ('$html', '$css', NOW())";

    if ($conn->query($sql_insert_data) === TRUE) {
        echo "New record created successfully. \r\n";
    } else {
        echo 'Error: ' . $sql_insert_data . '<br>' . $conn->error;
    }

    echo "Upload successful.";
} else {
    echo "Error during the ZIP extraction.";
}

$conn->close();
// }


