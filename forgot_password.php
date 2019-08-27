<?php $currentPage = "Password Recovery"?>

<?php require_once 'includes/header.php'?>
    <div class="container">
        <div class="content">
            <h2 class="heading">Password Recovery</h2>
                <?php

if (isset($_POST['password-recovery'])) {
    $user_name = escape($_POST['user-name']);
    $user_email = escape($_POST['user-email']);
    $query = "SELECT * FROM users WHERE user_name='$user_name' AND user_email='$user_email' AND is_active=1";
    $query_con = mysqli_query($con, $query);
    if (!$query_con) {
        die("Query failed" . mysqli_error($con));
    }
    if (mysqli_num_rows($query_con) == 1) {
        if (!isset($_COOKIE['_unp_'])) {
            $user_name = $_POST['user-name'];
            $user_email = $_POST['user-email'];
            date_default_timezone_set("asia/jerusalem");

            //email confirmation
            $mail->addAddress($user_email);
            $email = $user_email;
            $token = getToken(32);
            $encode_token = base64_encode(urlencode($token));
            $email = base64_encode(urlencode($user_email));
            $expire_date = date("Y-m-d H:i:s", time() + 60 * 20);
            $expire_date = base64_encode(urlencode($expire_date));

            $query = "UPDATE users SET validation_key='$token' WHERE user_name='$user_name' AND user_email='$user_email' AND is_active=1";
            $query_con = mysqli_query($con, $query);
            if (!$query_con) {
                die("Query failed" . mysqli_error($con));
            } else {

                $mail->Subject = "Password reset request";
                $mail->Body = "<h2>Follow the link to reset password</h2>
                  <a href='localhost/user_registration/new_password.php?eid={$email}&token={$encode_token}&exd={$expire_date}'>Click here to create new password</a>
                   <p>This link is valid for 20 minutes</p>";

                if ($mail->send()) {
                    setcookie('_unp_', getToken(16), time() + 60 * 20, '', '', '', true);
                    echo "<div class='notification'>Check your email for password reset link</div>";
                }
            }

        } else {
            echo "<div class='notification'>You must be await at least 20 minutes for another request</div>";
        }
    } else {
        echo "<div class='notification'>Sorry! User not found</div>";

    }
}

?>

            <!-- <div class='notification'>You need to wait at lest 20 minutes for another request</div> -->
            <form action="" method="POST">
                <div class="input-box">
                    <input type="text" class="input-control" placeholder="Username" name="user-name" required>
                </div>
                <div class="input-box">
                    <input type="email" class="input-control" placeholder="Email address" name="user-email" required>
                </div>
                <div class="input-box">
                    <input type="submit" class="input-submit" value="RECOVER PASSWORD" name="password-recovery" required>
                </div>
            </form>
        </div>
    </div>
<?php require_once 'includes/footer.php'?>