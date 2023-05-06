<?php
if (isset($_GET["id"])){
    $id = $_GET["id"];

    $servername ='localhost';
    $username='root';
    $password = 'root';
    $dbname = 'crud';

    $connection = new mysqli($servername, $username, $password, $dbname);

    $sql = "DELETE FROM user_info WHERE id=$id";
    $connection->query($sql);
}
header("location:/crud/index.php");
exit;
?>