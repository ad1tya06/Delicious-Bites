<?php
ini_set('session.gc_maxlifetime', 300);
session_start();
$err = $select = "";
// Check if session is active
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 301)) {
    // Session expired, destroy session and redirect to login page
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
    header("Location: index.html"); // Redirect to login page
    exit(); // Ensure script stops execution after redirection
}

// Update last activity time stamp
$_SESSION['LAST_ACTIVITY'] = time();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_POST['item'])) {
            $select = "*Please Select atleast one item to order.";
        } else {
      
            $a = 1;
            $i = 0;
            $money = 0;
            $plain_salted_fries = 49;
            $peri_peri_fries = 59;
            $cheese_fries = 79;
            $alloo_tikki_burger = 49;
            $mexican_burger = 69;
            $paneer_burger = 79;
            $arrabbiata_Red_Pasta = 69;
            $alfredo_White_Pasta = 69;
            $mix_Sauce_Pasta = 79;
            $margherita_Pizza = 129;
            $cheese_corn_pizza = 149;
            $paneer_tikka_pizza = 179;
            $name = $_POST['item'];
            foreach ($name as $key => $v) {
                $item[$i] = $v;
                $i++;
            }
            $check = $i - 1;

            for ($i = 0; $i <= $check; $i++) {
                $c = $item[$i];
                $b = (int) $$c;
                $money = $money + $b;
            }


            include "database_con.php";

                $q = "delete from tablethree;";
                mysqli_query($c, $q);
                for ($i = 0; $i <= $check; $i++) {
                    $q = "INSERT INTO tablethree (`items`) VALUES ('$item[$i]');";
                    if (!((mysqli_query($c, $q)))) {
                        $a = 0;
                        $err = "An Error Occured.";
                    }

                }
                $q = "INSERT INTO tablethree (`money`) VALUES ('$money');";

                if (!((mysqli_query($c, $q)))) {
                    $a = 0;
                    $err = "An Error Occured.";
                }
                if (!$a) {
                    $q = "delete from tablethree;";
                    mysqli_query($c, $q);
                }
                if ($a) {
                    session_destroy();
                    mysqli_close($c);
                    header("Location:order_placed.html");
                }
            
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="table.js"></script>
    <link rel="stylesheet" href="table.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>| Table</title>
</head>
<body>
<form method="POST" action="">
        <header>
            <h2>Table No: <span>3</span></h2>
            <h1>Restaurant Menu </h1>
        </header>
        <div class="container">

            <span><b>
                    <?php echo $err, $select; ?>
                </b></span>
            <div>
                <h1>
                    FRIES
                </h1>

            </div>
            <div class="fries">
                <div class="food-box" id="a">
                    <div class="foodimg">
                        <img style="width: 320px; height: 260px;"
                            src="https://img.freepik.com/free-photo/fried-potatoes-french-fries-isolated-white-background_123827-26398.jpg?size=626&ext=jpg&ga=GA1.1.1937446577.1707586438&semt=ais"
                            alt="Food img..">
                        <div class="food_name">
                            <h3><span><input type="checkbox" name="item[]" value="plain_salted_fries"
                                        onclick="plain_salted()"></span> Plain
                                Salted Fries (₹49)</h3>
                        </div>
                    </div>
                </div>

                <div class="food-box" id="b">
                    <div class="foodimg">
                        <img style="width: 250px; height: 200px; padding-left: 18px; padding-top: 30px;"
                            src="https://www.pizzaexpress.com.my/wp-content/uploads/2018/04/peri-chips-1.png"
                            alt="Food img..">
                        <div class="food_name">
                            <h3 style="padding-top: 30px;"><span><input type="checkbox" name="item[]"
                                        value="peri_peri_fries" onclick="peri_peri_fries()"></span> Peri Peri Fries
                                (₹59)</h3>
                        </div>
                    </div>
                </div>

                <div class="food-box" id="c">
                    <div class="foodimg">
                        <img src="https://th.bing.com/th?id=OIP.qUUBbuAohWAedGWcA4uaVwAAAA&w=265&h=235&c=8&rs=1&qlt=90&o=6&dpr=1.3&pid=3.1&rm=2"
                            alt="Food img..">
                        <div class="food_name">
                            <h3 style="margin-top: -10px;"><span><input type="checkbox" name="item[]"
                                        value="cheese_fries" onclick="cheese_fries()"></span> cheese fries (₹79)</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h1>
                    BURGER
                </h1>

            </div>
            <div class="fries">
                <div class="food-box" id="d">
                    <div class="foodimg">
                        <img style="width: 290px; height: 260px; padding-top: 30px;"
                            src="https://thesamosashop.ca/wp-content/uploads/2022/11/Aloo-Tikki-Burger-2.png"
                            alt="Food img..">
                        <div class="food_name">
                            <h3 style="margin-top: -5px;"><span><input type="checkbox" name="item[]"
                                        value="alloo_tikki_burger" onclick="alloo_tikki_burger()"></span> Alloo Tikki
                                Burger (₹49)</h3>
                        </div>
                    </div>
                </div>

                <div class="food-box" id="e">
                    <div class="foodimg">
                        <img style="width: 280px; height: 240px; padding-top: 30px;"
                            src="https://th.bing.com/th/id/OIP.yfXWZKw8ue8hOi83Ip5lKQHaGk?rs=1&pid=ImgDetMain"
                            alt="Food img..">
                        <div class="food_name">
                            <h3><span><input type="checkbox" name="item[]" value="mexican_burger"
                                        onclick="mexican_burger()"></span> Mexican Burger (₹69)
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="food-box" id="f">
                    <div class="foodimg">
                        <img style="width: 250px;padding-left: 14px; height: 200px; padding-top: 40px;"
                            src="https://www.pngmart.com/files/16/Bacon-Cheese-Burger-PNG-Pic.png" alt="Food img..">
                        <div class="food_name">
                            <h3 style="padding-top: 28px;"><span><input type="checkbox" name="item[]"
                                        value="paneer_burger" onclick="paneer_burger()"></span> Paneer Burger (₹79)</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h1>
                    PASTA
                </h1>

            </div>
            <div class="fries">
                <div class="food-box" id="g">
                    <div class="foodimg">
                        <img src="https://www.lemillericette.it/wp-content/uploads/2020/11/SEDANI-ALLARRABBIATA.png"
                            alt="Food img..">
                        <div class="food_name">
                            <h3 style="margin-top: -0px;"><span><input type="checkbox" name="item[]"
                                        value="arrabbiata_Red_Pasta" onclick="arrabbiata_Red_Pasta()"></span> Arrabbiata
                                Red Pasta (₹69)</h3>
                        </div>
                    </div>
                </div>

                <div class="food-box" id="h">
                    <div class="foodimg">
                        <img src="https://www.pngmart.com/files/21/Alfredo-PNG-Clipart.png" alt="Food img..">
                        <div class="food_name">
                            <h3 style="margin-top: -0px;"><span><input type="checkbox" name="item[]"
                                        value="alfredo_White_Pasta" onclick="alfredo_White_Pasta()"></span> Alfredo
                                White Pasta (₹69)</h3>
                        </div>
                    </div>
                </div>

                <div class="food-box" id="i">
                    <div class="foodimg">
                        <img style="width: 290px; height: 260px;"
                            src="https://th.bing.com/th?id=OIP.zVsQK2YyPNfUzmVwTfYfagAAAA&w=301&h=207&c=8&rs=1&qlt=90&o=6&dpr=1.3&pid=3.1&rm=2"
                            alt="Food img..">
                        <div class="food_name">
                            <h3><span><input type="checkbox" name="item[]" value="mix_Sauce_Pasta"
                                        onclick="mix_Sauce_Pasta()"></span> Mix Sauce
                                Pasta (₹79)</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h1>
                    PIZZA
                </h1>

            </div>
            <div class="fries">
                <div class="food-box" id="u">
                    <div class="foodimg">
                        <img src="https://th.bing.com/th/id/OIP.Q5-bJXsO6HfQJgyBLAHQ2QHaFF?rs=1&pid=ImgDetMain"
                            alt="Food img..">
                        <div class="food_name">
                            <h3 style="margin-top: -0px;"><span><input type="checkbox" name="item[]"
                                        value="margherita_Pizza" onclick="margherita_Pizza()"></span> Margherita Pizza
                                (₹129)
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="food-box" id="j">
                    <div class="foodimg">
                        <img src="https://supremepizzaonline.ca/wp-content/uploads/2017/07/BBQ-Chicken-Special-up-1024x1024.jpg"
                            alt="Food img..">
                        <div class="food_name">
                            <h3 style="margin-top: -0px;"><span><input type="checkbox" name="item[]"
                                        value="cheese_corn_pizza" onclick="cheese_corn_pizza()"></span> Cheese Corn
                                Pizza (₹149)</h3>
                        </div>
                    </div>
                </div>

                <div class="food-box" id="k">
                    <div class="foodimg">
                        <img style="width: 260px; height: 240px;padding-left: 20px; padding-top: 30px;"
                            src="https://i.pinimg.com/originals/1c/20/18/1c201876d460a455c741405f5fc4ca08.png"
                            alt="Food img..">
                        <div class="food_name">
                            <h3><span><input type="checkbox" name="item[]" value="paneer_tikka_pizza"
                                        onclick="paneer_tikka_pizza()"></span> Paneer
                                Tikka Pizza (₹179)</h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="total">
            <h2> Total: ₹ <span id="t"></span>/-</h2>
        </div>
        <div>
            <span><input type="submit" class="bubbly-button" value="Submit Order!">
    </form>
</body>
</html>