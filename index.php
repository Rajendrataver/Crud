<?php
include "./connection.php";

session_start();
if (!$_SESSION['ID']) {
    header("Location:login.php");
}
$connection = Connection();
if (!$connection) {
    echo $failed;
} else {
    $sql = $connection->prepare("SELECT * FROM registration");
    $sql->execute();

}
$id = $_SESSION['ID'];
?>

<head>
    <style>
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 25px;
        }

        Header {
            max-width: 1400px;
             padding: 1px;
            background-color: #0f7ccb;
            color: white;
            margin: auto;
            text-align: center;
            font-size: 20px;
        }

        .list-section .table-container {
            width: 100%;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            border-radius: 16px;
            padding: 50px 0;
        }

        a {
            text-decoration: none;
        }

        .list-section table {
            width: 90%;
            margin: auto;
        }

        .list-section {
            margin-top: 50px;
        }

        table tr td,
        th {
            text-align: center;

            padding: 15px;
        }

        .logout-section {
            margin: 50px;
        }

        .btn {
            padding: 12px;
            color: white;
            background-color: #0475ff;
            border-radius: 6px;
            margin: 0 10px;
            cursor: pointer;
        }

        .logout-section .container div {
            display: flex;
            justify-content: space-between;
        }

        .btn:hover {
            background-color: #00479f;
        }

        .danger {
            background-color: #b51010;
        }

        .warning {
            background-color: orange;
            color: black;
        }

        .warning:hover {
            background-color: #c57f00;
        }

        .danger:hover {
            background-color: #8d0000;
        }

        .arrow {
            font-size: 32px
        }

        .readOnly {
            opacity: 0.8;
        }

        .odd {

            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }
    </style>
</head>

<Header>
    <h1>Welcome
        <?php echo $_SESSION['name']; ?>
    </h1>
</Header>
<section class="logout-section">
    <div class="container">
        <div>
            <a href="./logout.php" class="btn"><span class="arrow">&leftarrow;</span> Logout</a>
            <a href="./update.php?ID=<?php echo $id ?>" class="btn warning">Update<span
                    class="arrow">&rightarrow;</span>
            </a>
        </div>
    </div>
</section>
<section class="list-section">
    <div class="container">
        <div class="table-container">
            <table>
                <tr class="tr">
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>City</th>
                    <th>Action</th>
                </tr>
                <?php
                $c = 0;
                while ($row = $sql->fetch()) {
                    if ($c == 1) {
                        $class = "even";
                        $c = 0;
                    } else {
                        $class = "odd";
                        $c = 1;
                    }
                    echo "<tr class=$class>";
                    echo "<td>", ($row['name']), "</td>";
                    echo "<td>", ($row['email']), "</td>";
                    if ($row['gender'] == 'm') {
                        $src = "./male1.jpg";
                    } else {
                        $src = "./female.png";
                    }
                    echo "<td><img width='50px' src=$src /></td>";
                    echo "<td>", ($row['city']), "</td>";
                    $id = $row['ID'];
                    if ($id == $_SESSION['ID']) {
                        echo "<td><a href='./profile.php?ID=$id' class='btn warning '>View Profile</a><a class='btn' href='./update.php?ID=$id'>Update</a>&nbsp;<a href='./delete.php?ID=$id' class='btn danger'>Delete</a>&nbsp;</td>";
                    } else {
                        echo "<td><a href='./profile.php?ID=$id' class='btn warning '>View Profile</a><a class='btn readonly' >Update</a>&nbsp;<a  class='btn danger readonly'>Delete</a></td>";

                    }
                    echo "</tr>";
                }

                ?>
            </table>
        </div>
    </div>
</section>