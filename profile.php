<?php
include "./connection.php";
$params = $_SERVER['QUERY_STRING'];
$connection = Connection();
if (!$connection) {
    echo "failed";
} else {
    $sql = $connection->prepare("SELECT * FROM registration where $params");
    $sql->execute();
    $row = $sql->fetch();
    if ($row['gender'] == 'm') {
        $src = "./male1.jpg";
    } else {
        $src = "./female.png";
    }
}
?>

<head>
    <style>
        body {
            background-color: aliceblue;
        }

        .container {
            max-width: 1110px;
            margin: auto;
        }

        h3 {
            color: green;
            font-size: 35px;
            text-align: center;
        }

        .card {
            max-width: 20%;
            background-color: cornflowerblue;
            padding: 30px;
            margin: auto;
            text-align: center;
            border-radius: 8px;
            margin-top: 50px;
            cursor: pointer;
        }

        h2 {
            margin: 0;
            margin-top: 20px;
        }

        .card-img img {
            border-radius: 150px;
        }

        h1 {
            font-size: px;
            color: white;
            font-size: 45px;
            margin: 0;
        }

        h4 {
            text-transform: uppercase;
            margin: 0;
            margin-top: 10px;
            font-size: 20px;
        }

        .card-container {
            margin: auto;
        }

            Header {
            max-width: 1400px;
            padding: 5px;
            background-color: teal;
            color: white;
            margin: auto;
            text-align: center;
            font-size: 25px;
        }

        .btn {
            padding: 12px;
            color: white;
            background-color: #0475ff;
            border-radius: 6px;
            margin: 0 10px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<Header>
    <h1>Profile Section
    </h1>
</Header>
<div class="container">
    <div class="card">
        <div class="card-container">
            <div class="card-img">
                <img src=<?php echo

                    $src ?> width="200" alt="">
            </div>
            <hr>
            <div class="user-details">
                <h1 id="name">
                    <?php echo $row['name'] ?>
                </h1>
                <h4 id="email">
                    <?php echo $row['email'] ?>
                </h4>
                <h2 id="city">
                    <?php echo $row['city'] ?>
                </h2>
            </div>
        </div>
    </div>
    <a href="index.php" class="btn">Back to Home</a>
</div>