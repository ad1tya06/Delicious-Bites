<?php
session_start();
if(isset($_SESSION['email']) && isset($_SESSION['password'])){
header("refresh:10");
if(!(($_SESSION['email'] == input_data($_SESSION['$ne']))&&($_SESSION['password'] == input_data($_SESSION['$np'])))){
    session_destroy();
    header('Location:sign_in.php');
    die();
}

$num = array('one', 'two', 'three', 'four', 'five', 'six');
$m = 0;
$money = array('', '', '', '', '', '');
$nonempty = 0;
include "database_con.php";
for ($j = 0; $j < 6; $j++) {
    $e = 0;
    $q = "select *from table$num[$j];";
    $result = mysqli_query($c, $q);

    // checking how many rows are empty
    if (mysqli_num_rows($result) > 0) {
        $z[$m] = $j;
        $m++;
    }
}


$m = 0;
//Using loop to access all table's data
for ($j = 0; $j < 6; $j++) {
    // echo $z[$m]."in<br>";
    if ($z[$m] == $j) {
        
        $e = 0;
        $q = "select *from table$num[$j];";
        $result = mysqli_query($c, $q);

        // checking numbr of rows
        for ($i = 0; $e == 0; $i++) {
            if (mysqli_num_rows($result) == $i) {
                $check = $i;
                $e = 1;
            }
        }


        //Getting data from db
        for ($i = 0; $i < $check; $i++) {
            $row = mysqli_fetch_assoc($result);
            //here 'if' is usd to check , alues only assign which exists
            if (!($i == $check - 1)) {
                $item[$num[$j]][$i] = $row['items'];
            } else {
                //here else part is used, to assign null values to rest of the indexes
                $s = 12 - $check + 1;//it checks how many indexes are left
                for ($t = 1; $t <= $s; $t++) {
                    $item[$num[$j]][$i] = ' ';//it asssigns
                    $i++;//it increments the index
                }
                //now whole loop running $i's value increased , so decrese to further runable
                $i = 12 - $s;
            }// now dcresed to previous value, it will go futher because below $i is used who want running value , not the value incresed in else part
            if ($i == $check - 1) {
                $money[$j] = $row['money'];
            }
        }
        //Removing underscoe from items
        for ($i = 0; $i < $check - 1; $i++) {
            $replace = $item[$num[$j]][$i];
            $item[$num[$j]][$i] = str_replace('_', " ", $replace);
        }
        if(isset($z[$m+1])){
        $m=$m+1;
        }
    } else {
        for($t = 0; $t < 12; $t++) {
            $item[$num[$j]][$t] = ' ';
        }
    }
}
}
else
{
    header('Location:timeout.html');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>| Order status</title>
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

        header {
            width: auto;
            height: auto;
            background-color: aqua;
        }

        .heading {
            text-align: center;
            padding: 25px;
            font-size: 20px;
            color: rgb(245, 107, 9);
        }
        .info-button {
            background-color: #03d2f7f6;
            color: #4108ecf6;
            border: none;
            border-radius: 5px;
            box-shadow: 2px 2px 5px #03d2f7f6;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        .info-button:active {
            background-color: #0d79f53b;
        }

        .info-icon {
            position: absolute;
            width: 260px;
            height: 16px;
            fill: #ffffff;
            right: 10px;
            top: 20px
        }

        .back {
            background-color: rgba(226, 207, 177, 0.764);
            width: auto;
            display: flex;
            flex-direction: column;
            height: auto;
            align-items: center;
        }

        .table {
            padding-top: 30px;
            font-size: 40px;
        }

        .box {
            background-color: blueviolet;
            width: auto;
            height: auto;
            margin: 30px;
            display: flex;
            flex-direction: column;
            border-radius: 40px;
            justify-content: center;
            box-shadow: 2px 2px 12px rgb(47, 200, 255);
            padding: 20px;
            outline: auto;
        }

        .bar {
            display: flex;
            height: auto;
            width: auto;

        }

        .head1 {
            background-color: aquamarine;
            width: 600px;
            padding: 20px 20px;
            font-size: 30px;
            text-align: center;
            border-top-left-radius: 20px;


        }

        .head2 {
            background-color: rgb(162, 192, 182);
            width: 600px;
            padding: 20px 20px;
            text-align: center;
            font-size: 30px;
            border-top-right-radius: 20px;
        }

        .food-items {
            display: flex;

        }

        .items {
            background-color: rgba(127, 255, 212, 0.679);
            width: 600px;
            display: flex;
            padding: 20px;
            font-size: 25px;
            height: auto;
            flex-direction: column;
            border-bottom-left-radius: 20px;
        }

        .money {
            background-color: rgba(162, 192, 182, 0.656);
            width: 600px;
            font-size: 40px;
            padding: 13px;
            text-align: center;
            border-bottom-right-radius: 20px;
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


        @media only screen and (max-width: 768px) {
            .overlay {
                display:visible;
                display: flex;
            }

        }
    </style>
        <script>
        function info() {
            window.location.href="information.php";
        }
    </script>
</head>

<body>
    <header>
        <div class="heading">
            Order Status
            <div class="info-icon">
                <button onclick="info()" class="info-button">
                    <b>Info</b></button>
            </div>
        </div>
    </header>
    <div class="back">
        <div class="table">
            Table 1.
        </div>
        <div class="box">
            <div class="bar">
                <div class="head1">
                    FOOD
                </div>
                <div class="head2">
                    TOTAL:
                </div>
            </div>
            <div class="food-items">
                <div class="items">
                    <span>
                        <?php echo $item[$num[0]][0]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[0]][1]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[0]][2]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[0]][3]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[0]][4]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[0]][5]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[0]][6]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[0]][7]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[0]][8]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[0]][9]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[0]][10]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[0]][11]; ?>
                    </span>
                </div>
                <div class="money">
                    <span>₹
                        <?php echo $money[0]; ?>/-
                    </span>
                </div>
            </div>
        </div>


        <div class="table">
            Table 2.
        </div>
        <div class="box">
            <div class="bar">
                <div class="head1">
                    FOOD
                </div>
                <div class="head2">
                    TOTAL:
                </div>
            </div>
            <div class="food-items">
                <div class="items">
                    <span>
                        <?php echo $item[$num[1]][0]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[1]][1]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[1]][2]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[1]][3]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[1]][4]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[1]][5]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[1]][6]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[1]][7]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[1]][8]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[1]][9]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[1]][10]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[1]][11]; ?>
                    </span>
                </div>
                <div class="money">
                    <span>₹
                        <?php echo $money[1]; ?>/-
                    </span>
                </div>
            </div>
        </div>

        <div class="table">
            Table 3.
        </div>
        <div class="box">
            <div class="bar">
                <div class="head1">
                    FOOD
                </div>
                <div class="head2">
                    TOTAL:
                </div>
            </div>
            <div class="food-items">
                <div class="items">
                    <span>
                        <?php echo $item[$num[2]][0]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[2]][1]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[2]][2]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[2]][3]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[2]][4]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[2]][5]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[2]][6]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[2]][7]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[2]][8]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[2]][9]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[2]][10]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[2]][11]; ?>
                    </span>
                </div>
                <div class="money">
                    <span>₹
                        <?php echo $money[2]; ?>/-
                    </span>
                </div>
            </div>
        </div>


        <div class="table">
            Table 4.
        </div>
        <div class="box">
            <div class="bar">
                <div class="head1">
                    FOOD
                </div>
                <div class="head2">
                    TOTAL:
                </div>
            </div>
            <div class="food-items">
                <div class="items">
                    <span>
                        <?php echo $item[$num[3]][0]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[3]][1]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[3]][2]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[3]][3]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[3]][4]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[3]][5]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[3]][6]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[3]][7]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[3]][8]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[3]][9]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[3]][10]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[3]][11]; ?>
                    </span>
                </div>
                <div class="money">
                    <span>₹
                        <?php echo $money[3]; ?>/-
                    </span>
                </div>
            </div>
        </div>


        <div class="table">
            Table 5.
        </div>
        <div class="box">
            <div class="bar">
                <div class="head1">
                    FOOD
                </div>
                <div class="head2">
                    TOTAL:
                </div>
            </div>
            <div class="food-items">
                <div class="items">
                    <span>
                        <?php echo $item[$num[4]][0]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[4]][1]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[4]][2]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[4]][3]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[4]][4]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[4]][5]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[4]][6]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[4]][7]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[4]][8]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[4]][9]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[4]][10]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[4]][11]; ?>
                    </span>
                </div>
                <div class="money">
                    <span>₹
                        <?php echo $money[4]; ?>/-
                    </span>
                </div>
            </div>
        </div>


        <div class="table">
            Table 6.
        </div>
        <div class="box">
            <div class="bar">
                <div class="head1">
                    FOOD
                </div>
                <div class="head2">
                    TOTAL:
                </div>
            </div>
            <div class="food-items">
                <div class="items">
                    <span>
                        <?php echo $item[$num[5]][0]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[5]][1]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[5]][2]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[5]][3]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[5]][4]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[5]][5]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[5]][6]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[5]][7]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[5]][8]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[5]][9]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[5]][10]; ?>
                    </span>
                    <span>
                        <?php echo $item[$num[5]][11]; ?>
                    </span>
                </div>
                <div class="money">
                    <span>₹
                        <?php echo $money[5]; ?>/-
                    </span>
                </div>
            </div>
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
<script>
    $(window).on('beforeunload', function(){
        $.ajax({
            url: 'destroy_session.php', // PHP script to destroy session
            type: 'POST',
            async: false, // Synchronous request
            success: function(data) {
                console.log("Session destroyed.");
            }
        });
    });
    </script>