<?php
session_start();
include "./connection.php";
include "./error.php";

function checkInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}


if (isset($_POST["login"])) {
    $email = checkInput($_POST["email"]);
    $password = checkInput($_POST["password"]);
    if (empty($email)) {
        $emailError = $emailRequired;
    } else if (!preg_match("/^[_.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+.)+[a-zA-Z]{2,6}$/i", $email)) {
        $emailError = $invalidEmail;
    } else if (empty($password)) {
        $emailError = "";
        $paasswordError = $passwordRequired;
    } else if (strlen($password) < 5) {
        $emailError = "";
        $paasswordError = $strongPassword;
    } else {
        $paasswordError = '';
        $connection = Connection();
        if (!$connection) {
            $result = $failed;
        } else {
            try {

                $sql = $connection->prepare("SELECT * FROM registration where email='$email'AND password='$password'");
                $sql->execute();
                $password = "";
                $email = "";
                $row = $sql->fetch();
                if ($row) {
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['password'] = $row['password'];
                    $_SESSION['ID'] = $row['ID'];
                    $id = $row['ID'];
                    header("Location: index.php");
                } else {
                    $result = "invalid User";
                }

            } catch (PDOException $error) {
                echo 'Connection error: ' . $error->getMessage();
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
            width: 20%;
            margin: 0 auto;

            padding: 25px 35px;
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

        button {
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
            background-color: #0475ff;
            display: BLOCK;
            margin-top: 23px;
            color: white;
            border-radius: 8px;
            text-align: center;
            font-weight: bolder;
            text-decoration: none;
        }

        .err {
            color: red;
        }

        .border-danger {
            border: 4px solid red;
        }
    </style>
</head>

<body>

    <Header>
        <h1>Login-Page</h1>
    </Header>
    <form method="post">
        <span class="err"> &nbsp;
            <?php echo $result ?>
        </span>
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
        <button type="submit" name="login">Login</button>
        <a class="btn" href="./registration.php">Create An Account</a>
    </form>
</body>