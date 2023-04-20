<h1>this is delete page</h1>

<?php
include "./connection.php";
$params = $_SERVER['QUERY_STRING'];
var_dump($params);
$$connection = Connection();
if (!$connection) {
    echo "failed";
} else {
    $sql = $connection->prepare("DELETE  FROM registration where $params");
    $sql->execute();
    var_dump($sql);
    if ($sql) {
        header('Location: index.php');
    } else {
        header('Location: update.php');
    }
}