<?php
session_start();
if(isset($_SESSION['email']) && isset($_SESSION['password'])){
if(!(($_SESSION['email'] ==$_SESSION['$ne'])&&($_SESSION['password'] == $_SESSION['$np']))){
    session_destroy();
    header('Location:sign_in.php');
    die();
}

include "database_con.php";
$b = 0;
$m = 0;
$e = 0;
$r=0;

if (isset($_POST['delete'])) {
    $d = 1;
    $q = "delete from reservation;";
    if (!(mysqli_query($c, $q))) {
        $d = 0;
    }

    $q = "delete from contact;";
    if (!(mysqli_query($c, $q))) {
        $d = 0;
    }
    $q="UPDATE avail set count=0;";
    if (!(mysqli_query($c, $q))) {
        $d = 0;
    }
    header("Location: " . $_SERVER['PHP_SELF']); 
    
}

$booking_name = array('', '', '', '', '', '', '', '', '');
$booking_email = array('', '', '', '', '', '', '', '', '');
$booking_date = array('', '', '', '', '', '', '', '', '');
$booking_time = array('', '', '', '', '', '', '', '', '');
$booking_people = array('', '', '', '', '', '', '', '', '');
$booking_request = array('', '', '', '', '', '', '', '', '');


$contact_name = array('', '', '', '', '', '', '', '', '');
$contact_email = array('', '', '', '', '', '', '', '', '');
$contact_subject = array('', '', '', '', '', '', '', '', '');
$contact_message = array('', '', '', '', '', '', '', '', '');




$q = "select *from reservation;";
$result = mysqli_query($c, $q);


//cheking number of rows
for ($i = 0; $e == 0; $i++) {
    if (mysqli_num_rows($result) == $i) {
        $check = $i;
        $e = 1;
        if($i==0){
            $r=1;
        }
    }
}
//if row exists assign values to heading
if ($r == 0) {
    $booking_nameb = "NAME";
    $booking_emailb = "E-mail";
    $booking_dateb = "DATE";
    $booking_timeb = "TIME";
    $booking_peopleb = "PEOPLE";
    $booking_requestb = "SPECIAL REQUEST";
    $nob = "Bookings";
} else {
    $nob = "No Bookings";
    $booking_nameb = "";
    $booking_emailb = "";
    $booking_dateb = "";
    $booking_timeb = "";
    $booking_peopleb = "";
    $booking_requestb = "";
}

// Fetching booking data
for ($i = 0; $i < $check; $i++) {
    $booking = mysqli_fetch_assoc($result);
    $booking_name[$i] = $booking['name'];
    $booking_email[$i] = $booking['email'];
    $booking_date[$i] = $booking['date'];
    $booking_time[$i] = $booking['time'];
    $booking_people[$i] = $booking['people'];
    $booking_request[$i] = $booking['request'];
}


$q = "select *from contact;";
$result = mysqli_query($c, $q);

$e = 0;
$r=0;
//checking rows
for ($i = 0; $e == 0; $i++) {
    if (mysqli_num_rows($result) == $i) {
        $check = $i;
            $e = 1;
            if($i==0){
                $r=1;
            }
    }
}
if ($r == 0) {
    $contact_namec = "NAME";
    $contact_emailc = "E-mail";
    $contact_subjectc = "SUBJECT";
    $contact_messagec = "MESSAGE";
    $noc = "Messages";
} else {
    $noc = "No Messages";
    $contact_namec = "";
    $contact_emailc = "";
    $contact_subjectc = "";
    $contact_messagec = "";
}

// fetchig contact data
for ($i = 0; $i < $check; $i++) {
    $contact = mysqli_fetch_assoc($result);
    $contact_name[$i] = $contact['name'];
    $contact_email[$i] = $contact['email'];
    $contact_subject[$i] = $contact['subject'];
    $contact_request[$i] = $contact['message'];
}
}
else{
    header('Location:timeout.html');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" >
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>| Bookings & Messages</title>
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
        #red{
            color:red;
           
        }
        header {
            width: auto;
            height: auto;
            background-color: aqua;
        }

        .refresh-button {
            background-color: #03d2f7f6;
            color: #4108ecf6;
            border: none;
            border-radius: 5px;
            box-shadow: 2px 2px 5px #03d2f7f6;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        .power-button {
            background-color: #ff0000;
            border: none;
            box-shadow: 5px 5px  12px #851010d3;
            padding: 10px 20px;
            border-radius: 40px 40px 40px 40px;
            font-size: 16px;
            cursor: pointer;
        }

        .refresh-button:active {
            background-color: #0d79f53b;
        }

        .refresh-icon {
            position: absolute;
            width: 260px;
            height: 16px;
            fill: #ffffff;
            right: 10px;
            top: 20px
        }

        .dlt span input {
            background-color: #ea5d1bf6;
            color: #1d1c21f6;
            border: none;
            border-radius: 5px;
            box-shadow: 2px 2px 5px #03d2f7f6;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        .dlt span input:hover {
            background-color: #f52c0da0;
        }

        .dlt {
            padding-top: 80px;
            margin-bottom: 180px;
            width: 260px;
            height: 16px;
            fill: #ffffff;
            right: 10px;
            top: 20px
        }

        .heading {
            text-align: center;
            padding: 25px;
            font-size: 20px;
            color: rgb(245, 107, 9);
        }

        .back {
            background-color: rgba(226, 207, 177, 0.764);
            width: auto;
            display: flex;
            flex-direction: column;
            height: auto;
            align-items: center;
            padding: 40px;
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
            background-color: rgb(162, 192, 182);
            width: 240px;
            font-size: 28px;
            text-align: center;
            border-top-left-radius: 20px;
            border-top-right-radius: 10px;


        }

        .name {
            background-color: chartreuse;
            width: 240px;
            font-size: 20px;
            padding-left: 20px;
        }

        .head2 {
            background-color: rgb(162, 192, 182);
            width: 310px;
            text-align: center;
            font-size: 28px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .email {
            background-color: chartreuse;
            width: 310px;
            font-size: 20px;
            padding-left: 20px;
        }

        .head3 {
            background-color: rgb(162, 192, 182);
            width: 200px;
            text-align: center;
            font-size: 28px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .head6 {
            background-color: rgb(162, 192, 182);
            width: 200px;
            text-align: center;
            font-size: 28px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .date {
            background-color: chartreuse;
            width: 200px;
            font-size: 20px;
            text-align: center;
            padding-left: 20px;
        }
        .time {
            background-color: chartreuse;
            width: 200px;
            font-size: 20px;
            text-align: center;
            padding-left: 20px;
        }

        .head4 {
            background-color: rgb(162, 192, 182);
            width: 100px;
            height: auto;
            text-align: center;
            font-size: 28px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .people {
            background-color: chartreuse;
            width: 100px;
            font-size: 20px;
            text-align: center;
            padding-left: 20px;
        }

        .head5 {
            background-color: rgb(162, 192, 182);
            width: 400px;

            text-align: center;
            font-size: 28px;
            border-top-left-radius: 10px;
            border-top-right-radius: 20px;
        }

        .request {
            background-color: chartreuse;
            width: 400px;
            text-align: center;
            font-size: 20px;
            height: auto;
            max-height: 400px;
            line-height: 4;
            overflow: auto;

            padding-left: 20px;
        }

        .booking-info {
            display: flex;
        }

        .food-items {
            display: flex;
            flex-direction: column;

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
        function refresh() {
            location.reload();
        }
        function power(){
        window.location.href = "destroy_session.php";
    }
    </script>
</head>

<body>
    <header>
        <div class="heading">
            Information
            <div class="refresh-icon">
                <button onclick="refresh()" class="refresh-button"><i class="fa-solid fa-refresh"></i>
                    <b>Refresh</b></button>
                <button onclick="power()" class="power-button"><i class="fa fa-power-off"></i></button>

            </div>
        </div>

    </header>
    <div class="back">
        <div class="table">
           <span>
                <?php echo $nob; ?>
            </span>
        </div>

        <!-- booking box -->
        <div class="box">
            <div class="bar">
                <div class="head1">
                    <span>
                        <?php echo $booking_nameb; ?>
                    </span>
                </div>
                <div class="head2">
                    <span>
                        <?php echo $booking_emailb; ?>
                    </span>
                </div>
                <div class="head3">
                    <span>
                        <?php echo $booking_dateb; ?>
                    </span>
                </div>
                <div class="head6">
                    <span>
                        <?php echo $booking_timeb; ?>
                    </span>
                </div>
                <div class="head4">
                    <span>
                        <?php echo $booking_peopleb; ?>
                    </span>
                </div>
                <div class="head5">
                    <span>
                        <?php echo $booking_requestb; ?>
                    </span>
                </div>
            </div>
            <div class="booking-info">
                <span class="name">
                    <?php echo $booking_name[0]; ?>
                </span>
                <span class="email">
                    <?php echo $booking_email[0]; ?>
                </span>
                <span class="date">
                    <?php echo $booking_date[0]; ?>
                </span>
                <span class="time">
                    <?php echo $booking_time[0]; ?>
                </span>
                <span class="people">
                    <?php echo $booking_people[0]; ?>
                </span>
                <span class="request">
                    <?php echo $booking_request[0]; ?>
                </span>

            </div>
            <div class="booking-info">
                <span class="name">
                    <?php echo $booking_name[1]; ?>
                </span>
                <span class="email">
                    <?php echo $booking_email[1]; ?>
                </span>
                <span class="date">
                    <?php echo $booking_date[1]; ?>
                </span>
                <span class="time">
                    <?php echo $booking_time[1]; ?>
                </span>
                <span class="people">
                    <?php echo $booking_people[1]; ?>
                </span>
                <span class="request">
                    <?php echo $booking_request[1]; ?>
                </span>
            </div>
            <div class="booking-info">
                <span class="name">
                    <?php echo $booking_name[2]; ?>
                </span>
                <span class="email">
                    <?php echo $booking_email[2]; ?>
                </span>
                <span class="date">
                    <?php echo $booking_date[2]; ?>
                </span>
                <span class="time">
                    <?php echo $booking_time[2]; ?>
                </span>
                <span class="people">
                    <?php echo $booking_people[2]; ?>
                </span>
                <span class="request">
                    <?php echo $booking_request[2]; ?>
                </span>
            </div>
            <div class="booking-info">
                <span class="name">
                    <?php echo $booking_name[3]; ?>
                </span>
                <span class="email">
                    <?php echo $booking_email[3]; ?>
                </span>
                <span class="date">
                    <?php echo $booking_date[3]; ?>
                </span>
                <span class="time">
                    <?php echo $booking_time[3]; ?>
                </span>
                <span class="people">
                    <?php echo $booking_people[3]; ?>
                </span>
                <span class="request">
                    <?php echo $booking_request[3]; ?>
                </span>

            </div>
            <div class="booking-info">
                <span class="name">
                    <?php echo $booking_name[4]; ?>
                </span>
                <span class="email">
                    <?php echo $booking_email[4]; ?>
                </span>
                <span class="date">
                    <?php echo $booking_date[4]; ?>
                </span>
                <span class="time">
                    <?php echo $booking_time[4]; ?>
                </span>
                <span class="people">
                    <?php echo $booking_people[4]; ?>
                </span>
                <span class="request">
                    <?php echo $booking_request[4]; ?>
                </span>

            </div>
            <div class="booking-info">
                <span class="name">
                    <?php echo $booking_name[5]; ?>
                </span>
                <span class="email">
                    <?php echo $booking_email[5]; ?>
                </span>
                <span class="date">
                    <?php echo $booking_date[5]; ?>
                </span>
                <span class="time">
                    <?php echo $booking_time[5]; ?>
                </span>
                <span class="people">
                    <?php echo $booking_people[5]; ?>
                </span>
                <span class="request">
                    <?php echo $booking_request[5]; ?>
                </span>

            </div>
        </div>

        <!-- contact box -->
        <div class="table">
            <span>
                <?php echo $noc; ?>
            </span>
        </div>
        <div class="box">
            <div class="bar">
                <div class="head1">
                    <span>
                        <?php echo $contact_namec; ?>
                    </span>
                </div>
                <div class="head2">
                    <span>
                        <?php echo $contact_emailc; ?>
                    </span>
                </div>
                <div class="head3">
                    <span>
                        <?php echo $contact_subjectc; ?>
                    </span>
                </div>

                <div class="head5">
                    <span>
                        <?php echo $contact_messagec; ?>
                    </span>
                </div>
            </div>
            <div class="booking-info">
                <span class="name">
                    <?php echo $contact_name[0]; ?>
                </span>
                <span class="email">
                    <?php echo $contact_email[0]; ?>
                </span>
                <span class="date">
                    <?php echo $contact_subject[0]; ?>
                </span>
                <span class="request">
                    <p>
                        <?php echo $contact_message[0]; ?>
                </span>

            </div>
            <div class="booking-info">
                <span class="name">
                    <?php echo $contact_name[1]; ?>
                </span>
                <span class="email">
                    <?php echo $contact_email[1]; ?>
                </span>
                <span class="date">
                    <?php echo $contact_subject[1]; ?>
                </span>
                <span class="request">
                    <?php echo $contact_message[1]; ?>
                </span>
            </div>
            <div class="booking-info">
                <span class="name">
                    <?php echo $contact_name[2]; ?>
                </span>
                <span class="email">
                    <?php echo $contact_email[2]; ?>
                </span>
                <span class="date">
                    <?php echo $contact_subject[2]; ?>
                </span>
                <span class="request">
                    <?php echo $contact_message[2]; ?>
                </span>
            </div>
            <div class="booking-info">
                <span class="name">
                    <?php echo $contact_name[3]; ?>
                </span>
                <span class="email">
                    <?php echo $contact_email[3]; ?>
                </span>
                <span class="date">
                    <?php echo $contact_subject[3]; ?>
                </span>
                <span class="request">
                    <?php echo $contact_message[3]; ?>
                </span>



            </div>
            <div class="booking-info">
                <span class="name">
                    <?php echo $contact_name[4]; ?>
                </span>
                <span class="email">
                    <?php echo $contact_email[4]; ?>
                </span>
                <span class="date">
                    <?php echo $contact_subject[4]; ?>
                </span>
                <span class="request">
                    <?php echo $contact_message[4]; ?>
                </span>



            </div>
            <div class="booking-info">
                <span class="name">
                    <?php echo $contact_name[5]; ?>
                </span>
                <span class="email">
                    <?php echo $contact_email[5]; ?>
                </span>
                <span class="date">
                    <?php echo $contact_subject[5]; ?>
                </span>
                <span class="request">
                    <?php echo $contact_message[5]; ?>
                </span>


            </div>
        </div>
        <div class="dlt">
            <form method="post" action="">
                <input type="hidden" name="delete" value="1">
                <span id="red"><input type="submit" value="Delete All Records">
                </span>
            </form>
        </div>
    </div>
</body>

</html>
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