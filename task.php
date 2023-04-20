<h1>Hello world</h1>
<?php
$db_name = "mysql:host=localhost;dbname=newDataBase;";
$conn = new PDO($db_name, "root", "root");
if ($conn->errorCode()) {

    echo '<h1>err<h1>';
} else {
    $sql = $conn->query("SELECT * from registration");
    var_dump($sql);

    while ($row = $sql->fetch()) {
        echo "<pre>";
        print_r($row);
        echo "</pre>";
    }
}
?>