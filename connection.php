<?php
function Connection()
{
    $db_name = "mysql:host=localhost;dbname=newDataBase;";
    return new PDO($db_name, "root", "root");
}
?>