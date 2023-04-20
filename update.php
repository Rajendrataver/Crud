<?php
session_start();
include "./connection.php";
include "./error.php";
$params = $_SERVER['QUERY_STRING'];
echo $params;
$connection = Connection();

if (!$connection) {
    echo $failed;
} else {
    $sql = $connection->prepare("SELECT * FROM registration where $params");
    $sql->execute();
    $row = $sql->fetch();
    if ($row) {
        $name = $row['name'];
        $email = $row['email'];
        $password = $row['password'];
        $gender = $row['gender'];
        $city = $row['city'];
        $id = $row['ID'];
    } else {
        header('Location: login.php');
    }
}
function checkInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}


if (isset($_POST["update"])) {
    $name = checkInput($_POST["name"]);
    $email = checkInput($_POST["email"]);
    $password = checkInput($_POST["password"]);
    $gender = checkInput($_POST["gender"]);
    $city = checkInput($_POST['city']);

    if (empty($name)) {
        $nameError = $nameRequired;
    } else if (!preg_match("/^([a-zA-Z' ])*$/", $name)) {
        $nameError = $OnlyLetter;
    } else if (empty($email)) {
        $nameError = "";
        $emailError = $emailRequired;
    } else if (!preg_match("/^[_.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+.)+[a-zA-Z]{2,6}$/i", $email)) {
        $emailError = $invalidEmail;
    } else if (empty($password)) {
        $emailError = "";
        $paasswordError = $passwordRequired;
    } else if (strlen($password) < 5) {
        $emailError = "";
        $paasswordError = $strongPassword;
    } else if (empty($gender)) {
        $paasswordError = '';
        $gederError = $genderRequired;
    } else if (empty($city)) {
        $gederError = '';
        $cityError = $selectCity;
    } else {
        $cityError = '';
        $connection = Connection();
        if (!$connection) {
            $result = $failed;
        } else {
            $sql = $connection->prepare("UPDATE registration SET name='$name',email='$email',password='$password',gender='$gender',city='$city' WHERE id=$id");
            $res = $sql->execute();
            if ($res) {
                if ($id == $_SESSION['ID']) {
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    $_SESSION['password'] = $password;
                }
                header('Location: index.php');
            }

        }
    }
}

?>

<head>
    <style>
        Header {
            max-width: 1400px;
            padding: 20px;
            background-color: teal;
            color: white;
            margin: auto;
            text-align: center;
        }

        form {
            max-width: 35%;
            margin: 0 auto;

            padding: 20px 100px;
            margin-top: 50px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            border-radius: 16px;
            padding-bottom: 50px;
        }

        #p {
            width: 40%;
            margin: 0 auto;
            border: 0.5px solid gray;
            padding: 25px 100px;
            margin-top: 50px;
            font-size: 35px;
        }

        form div label {
            font-size: 20px;
        }

        form div {
            margin-top: 30px;
        }

        form h1 {
            color: green;
            text-align: center;
        }

        form div span {
            color: red;
            font-size: 16px
        }

        form .input {
            width: 100%;
            padding: 10px 10px;
            border-radius: 4px;
            border: 0.5px solid gray;
            outline: none;
            font-size: 18px;

        }

        .button {
            padding: 12px 25px;
            background-color: green;
            color: white;
            border: 0;
            border-radius: 8px;
            margin-top: 30px;
            width: 100%;
            font-weight: bold;
        }

        .btn {
            padding: 10px;
            background-color: teal;
            display: BLOCK;
            margin-top: 23px;
            color: white;
            border-radius: 8px;
            text-align: center;
            font-weight: bolder;
            text-decoration: none;
        }

        .border-danger {
            border: 4px solid red;
        }
    </style>
</head>

<body>
    <Header>
        <h1>Update</h1>
    </Header>
    <form method="post">
        <div>
            <label>Name :</label>
            <input type="text" name="name" value="<?php if (isset($name)) {
                echo $name;
            } ?>" class="input" style="<?php if (!empty($nameError)) {
                 echo "border:0.5px solid red";
             }
             ; ?>">
            <span>
                <?php echo $nameError ?>
            </span>
        </div>
        <div>
            <label>Email :</label>
            <input type="email" name="email" value="<?php if (isset($email)) {
                echo $email;
            } ?>" class="input" style="<?php if (!empty($emailError)) {
                 echo "border:0.5px solid red";
             }
             ; ?>">
            <span>
                <?php echo $emailError ?>
            </span>
        </div>
        <div>
            <label>Password :</label>
            <input type="password" name="password" value="<?php if (isset($password)) {
                echo $password;
            } ?>" class="input" style="<?php if (!empty($paasswordError)) {
                 echo "border:0.5px solid red";
             }
             ; ?>">
            <span>
                <?php echo $paasswordError ?>
            </span>
        </div>
        <div>
            <label>Gender : </label>
            <input type="radio" name="gender" value="m" <?php
            if ($gender == "m") {
                echo "checked";
            }
            ?>>Male&nbsp;&nbsp;&nbsp;
            <input type="radio" name="gender" value="f" value="male" <?php
            if ($gender == "f") {
                echo "checked";
            }
            ?>>Female&nbsp;&nbsp;&nbsp;
            <span>
                <?php echo $gederError ?>
            </span>
        </div>

        <div>
            <label>City :</label>
            <select name="city" value="<?php if (isset($city)) {
                echo $city;
            } ?>" class="input" style="<?php if (!empty($cityError)) {
                 echo "border:0.5px solid red";
             }
             ; ?>">
                <option value="">--Please choose a city--</option>
                <option>Indore</option>
                <option>Ujjain</option>
                <option>Bhopal</option>
            </select>
            <span>
                <?php echo $cityError ?>
            </span>
        </div>
        <button type="submit" class="button" name="update">Update</button>
        <a class="btn" href="./index.php">Back to Home</a>
    </form>
    <?php

    ?>
</body>