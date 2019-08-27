<?php ob_start();?>
<?php require_once "includes/db.php";?>
<?php require_once "includes/functions.php";?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Password</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="content">
            <h2 class="heading">New Password</h2>

        <?php

if (isset($_GET['eid']) && isset($_GET['token']) && isset($_GET['exd'])) {
    $user_email = urldecode(base64_decode($_GET['eid']));
    $validation_key = urldecode(base64_decode($_GET['token']));

    $expire_date = urldecode(base64_decode($_GET['exd']));
    date_default_timezone_set("asia/jerusalem");
    $current_date = date("Y-m-d H:i:s");
    if ($expire_date <= $current_date) {
        echo "<div class='notification'>Sorry this link was expired</div>";
    } else {
        $check = true;
        if (isset($_POST['submit'])) {

            $user_pass = escape($_POST['new-password']);
            $user_con_pass = escape($_POST['confirm-new-password']);
            if ($user_pass == $user_con_pass) {
                //password validation
                $pattern_up = "/^.*(?=.{4,56})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/";
                if (!preg_match($pattern_up, $user_pass)) {
                    $errPass = "Must be at lest 4 character long, 1 upper case, 1 lower case letter and 1 number exist";
                }
            } else {
                $errPass = "Password dosen't matched";
            }

            if (!isset($errPass)) {
                $query = "SELECT * FROM users WHERE user_email='$user_email' AND validation_key='$validation_key' AND is_active=1";
                $query_con = mysqli_query($con, $query);
                if (!$query_con) {
                    die("Query failed" . mysqli_error($con));
                }
                if (mysqli_num_rows($query_con) == 1) {
                    $password = password_hash($user_pass, PASSWORD_BCRYPT, ['cost=>10']);
                    $query1 = "UPDATE users SET user_password='$password' WHERE validation_key='$validation_key' AND user_email='$user_email' AND is_active=1";
                    $query_con1 = mysqli_query($con, $query1);
                    if (!$query_con1) {
                        die("Query failed" . mysqli_error($con));
                    } else {
                        $query2 = "UPDATE users SET validation_key=0 WHERE user_email='$user_email' AND validation_key='$validation_key' AND is_active=1";
                        $query_con2 = mysqli_query($con, $query2);
                        if (!$query_con2) {
                            die("Query failed" . mysqli_error($con));
                        }
                        echo "<div class='notification'> New Password successfully created</div>";
                        header("Refresh:3;url='login.php'");
                    }
                } else {
                    echo "<div class='notification'>Invalid link</div>";

                }
            }

        }

    }

} else {
    echo "<div class='notification'>Something went wrong</div>";
}

if (isset($errPass)) {
    echo "<div class='notification'>{$errPass}</div>";

}

?>

            <form action="" method="POST">
                <div class="input-box">
                    <input type="password" class="input-control" placeholder="New password" name="new-password" required <?php echo isset($check) ? "disabled" : ""; ?>>
                </div>
                <div class="input-box">
                    <input type="password" class="input-control" placeholder="Confirm new password" name="confirm-new-password" required <?php echo isset($check) ? "disabled" : ""; ?>>
                </div>
                <div class="input-box">
                    <input type="submit" class="input-submit" value="SUBMIT" name="submit" <?php echo isset($check) ? "disabled" : ""; ?>>
                </div>
            </form>

        </div>
    </div>
</body>
</html>