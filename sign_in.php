<?php
session_start();
$err = $ErrMsg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $a = 1;
    include "database_con.php";
    $q = 'SELECT *FROM details';
    $r = mysqli_query($c, $q);
    if (mysqli_num_rows($r) > 0) {
        $row = mysqli_fetch_assoc($r);
        $_SESSION['email'] = $row["email"];
        $_SESSION['password'] = $row["password"];
    } else {
        $con = "An error occured";
        die();
    }
    $_SESSION['$ne'] = $_POST['email'];
    $pattern = "/^([a-z0-9_\-]+)(\.[a-z0-9_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/";
    if (!preg_match($pattern, $_SESSION['$ne'])) {
        $ErrMsg = "Email is not valid.";
    }
    if (!($_SESSION['email'] == input_data($_SESSION['$ne']))) {
        $a = 0;
        $err = "Invalid Id, Password.";
    }



    $_SESSION['$np'] = $_POST['password'];
    if (!($_SESSION['password'] == input_data($_SESSION['$np']))) {
        $a = 0;
        $err = "Invalid Id, Password.";
    }

    if($a){
        mysqli_close($c);
        header('Location:order_status.php');
    }
    
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>| Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            list-style: none;
            text-decoration: none;
            color: black;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        .header {
            display: flex;
           justify-content:space-between;
            height: 65px;
            padding: 0 7vw;
            background-color: rgb(248, 232, 217);
            border-bottom: 2px solid rgb(252, 196, 124);
            box-shadow: 0 2px 15px rgb(253, 124, 124);
        }

        .header i {
            font-size: 25px;
          padding-top:20px;
            cursor: pointer;
            margin-left:-80px;
        }

        .logo img {
            width: 300px;
            mix-blend-mode: darken;
            cursor: pointer;
        }

        .logo img:hover {
            width: 320px;
            transition: all 0.2s;
        }

        .logo {
            display: flex;
            justify-content: left;
            padding-top: 20px;
            margin-right:-80px;
            
        }

        .back {
            padding: 100px;
            background-color: rgba(252, 196, 124, 0.26);
            display: flex;
            justify-content: center;
            height: 900px;
        }

        .box {
            display: flex;
            flex-direction: column;
            width: 800px;
            border-radius: 90px;
            background-color: rgba(206, 190, 169, 0.493);
            height: 600px;
            box-shadow: 5px 5px 12px 5px rgba(148, 121, 82, 0.534);
            padding-top: 50px;
            padding-left: 50px;

        }

        .box h2 {
            text-align: center;
            margin-bottom: 30px;
            color: rgba(244, 88, 27, 0.824);
            font-size: 50px;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            margin-left: -70px;
        }

        .blank {
            width: 90%;
            height: 70px;
            cursor: pointer;
            border: none;
            outline: none;
            margin-top: 30px;
            background-color: #cbc7ba35;
            color: rgb(0, 0, 0);
            border-radius: 50px;
            box-shadow: 2px 2px 9px rgba(51, 39, 34, 0.342);
            padding: 20px;
        }


        .box div {
            display: flex;
            justify-content: center;
        }

        input[type="submit"] {
            margin-top: 50px;
            background-color: rgba(199, 174, 150, 0.548);
            color: black;
            font-size: 23px;
            font-weight: bold;
            border-radius: 40px;
            box-shadow: 2px 2px 9px #9b70309b;
            padding: 10px;
            cursor: pointer;
            margin-left: -70px;
            border: none;
            outline: none;
        }

        input[type="submit"]:active {
            background-color: rgba(252, 196, 124, 0.26);
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color:  rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .message {
            background: transparent;
            border: 2px solid rgba(242, 218, 218, 0.197);
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
        }
        .overlay{
            display:none;
        }

        /* Resposive */

        @media only screen and (max-width: 768px) {
            .overlay {
                display:visible;
                display: flex;
            }
            header{
                justify-content:center;
            }
            .header .logo{
                margin:0px;
            }
            .box{
                display: none;
            }
           
        }
    </style>
</head>

<body>

    <div class="header">
        <a href="./"><i class="fa-solid fa-arrow-left"></i></a>
        <div class="logo">
            <img src="https://see.fontimg.com/api/renderfont4/gxgyE/eyJyIjoiZHciLCJoIjo4MSwidyI6MTI1MCwiZnMiOjY1LCJmZ2MiOiIjMDAwMDAwIiwiYmdjIjoiI0ZGRkZGRiJ9/RGVsaWNpb3VzIEJpdGVz/airtravelerspersonaluse-bdit.png"
                alt="Logo">
        </div>
        <div class="overlay">
        <div class="message">
            <p>Not Available for Mobile Version</p>
        </div>
    </div>
    </div>
    <div class="back">
        <div class="box">
            <h2>Sign in</h2><br>
            <span style="color:Red">
                <?php echo $err, $ErrMsg; ?>
            </span>
            <form method="POST" action="">
                <input class="blank" type="email" name="email" id="email" placeholder="Enter E-mail" required><br>
                <input class="blank" type="password" name="password" id="password" placeholder="Enter password" required><br>
                <div class="submit">
                    <input type="submit" value="Log in">
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<?php
function input_data($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>