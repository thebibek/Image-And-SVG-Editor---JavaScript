<?php 
    require_once("../includes/db.php");
    require_once("./includes/inc/emails.php");
    if(isset($_SESSION['admin'])){
        echo '<script>location.assign("dashboard")</script>';
        die();
    }
    function reloadWith($msg, $status = "error"){
        echo '<script>location.assign("forgot?'. $status .'='. $msg .'")</script>';
    }
    if(isset($_POST['forgotAdminPassword'])){
        $email = ($_POST['email']);
        $exist = $db->selectSingle("admins",array(
            "email" => $email
        ));
        if($exist){
            $admin_id = $exist['id'];
            $token = md5(time() . $admin_id);
            $token_expire_date = date("Y-m-d H:i:s", strtotime('+24 hours'));
            $updateToken = $db->update("admins", array(
                "forgot_token" => $token,
                "forgot_token_expire_date" => $token_expire_date
            ), array("id" => $admin_id));
            if($updateToken){
                $sendEmail = sendForgotEmail($email, $token);
                reloadWith("We've sent reset link to your email, The reset link will expire in next 24 hours", "success");
            } else {
                reloadWith("Something went wrong Please try again!");
            }
        } else {
            reloadWith("Email not exists");
        }
    }
    // Forgot Password
    $forgotPassword = false;
    if(isset($_GET['token']) && isset($_GET['email'])){
        $token = $_GET['token'];
        $email = $_GET['email'];
        $timestamp = date("Y-m-d H:i:s");
        $admin = $db->selectSingle("admins", array(
            "forgot_token" => $token,
            "email" => $email,
        ));
        if($admin){
            $token_expire_date = $admin['forgot_token_expire_date'];
            $token_expire_date = date("Y-m-d H:i:s", strtotime($token_expire_date));
            if($timestamp > $token_expire_date){
                reloadWith("Token is expired!. Please try again to reset password");
            } else {
                $forgotPassword = true;
            }
        } else {
                reloadWith("Wrong Email or token");
        }
    }
    if(isset($_POST['resetPassword'])){
        if($forgotPassword){
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];
            $token = $db->validText($_GET['token']);
            $email = $db->validText($_GET['email']);
            if($new_password == $confirm_password){
                $new_password = password_hash($new_password, PASSWORD_BCRYPT);
                $update = $db->update("admins", array("password" => $new_password), array(
                    "email" => $email
                ));
                if($update){
                    $token_expire_date = date("Y-m-d H:i:s", strtotime('-2 days'));
                    $update = $db->update("admins", array("forgot_token_expire_date" => $token_expire_date), array(
                        "email" => $email
                    ));
                    echo '<script>location.assign("login?success=Your password has been changed successfully")</script>';
                } else {
                    reloadWith("Error Please try again");
                }
            } else {
                reloadWith("Confirm Password is not matching with New Password. Please Enter the same password");
            }
        }
    }
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password |
        <?php echo $site_name; ?>
    </title>
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body class="content-center">
    <div class="col-lg-4 col-md-8 bg_dark p-5">
        <?php if($forgotPassword){ ?>
        <form action="forgot?token=<?php echo $_GET['token'] ?>&email=<?php echo $_GET['email']; ?>" method="POST" class="forgotPasswordForm">
            <div class="form-group">
                <h3 class="heading mb-3 text-center">
                    <?php echo $site_name; ?> | Admin
                </h3>
                <p class="more mb-5">Change Password</p>
            </div>
            <div class="form-group">
                <span class="label">New Password</span>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                    <input type="password" class="form-control u_password" name="new_password" data-length="[8,100]" required>
                </div>
            </div>
            <div class="form-group">
                <span class="label">Confirm Password</span>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                    <input type="password" class="form-control u_password" name="confirm_password" data-length="[8,100]" required>
                </div>
            </div>
            <?php 
                if(isset($_GET['success'])){
                    echo '<p class="text-success">'. htmlspecialchars($_GET['success']) .'</p>';
                } else if(isset($_GET['error'])){
                    echo '<p class="text-danger">'. htmlspecialchars($_GET['error']) .'</p>';
                }
             ?>
            <div class="form-group">
                <input type="hidden" name="resetPassword" value="1">
                <button class="btn-block btn s-btn" type="submit"><span class="text">Change Password</span></button>
            </div>
        </form>
        <?php } else { ?>
        <form action="forgot" method="POST">
            <div class="form-group">
                <h3 class="heading mb-3 text-center">
                    <?php echo $site_name; ?> | Admin
                </h3>
                <p class="more mb-5">Enter your email to receive a password reset link.</p>
            </div>
            <div class="form-group">
                <span class="label">Email</span>
                <div class="input-group">
                    <input type="email" name="email" class="form-control" placeholder="Enter Your Email...." required>
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
            </div>
            <?php 
                if(isset($_GET['success'])){
                    echo '<p class="text-success">'. htmlspecialchars($_GET['success']) .'</p>';
                } else if(isset($_GET['error'])){
                    echo '<p class="text-danger">'. htmlspecialchars($_GET['error']) .'</p>';
                }
             ?>
            <div class="form-group">
                <input type="hidden" name="forgotAdminPassword" value="1">
                <button class="btn-block btn s-btn" type="submit"><span class="text">Send Reset Link</span></button>
            </div>
        </form>
        <?php } ?>
    </div>
    <script src="../js/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <script>
    $(".forgotPasswordForm").on("submit", function(e) {
        let valid = true;
        let inputs = $(this).find("input");
        for (let i = 0; i < inputs.length; i++) {
            if (!validInput(inputs[i])) {
                valid = false;
                break;
            }
        }
        if (valid) {
            let u_password = $(this).find(".u_password");
            if (u_password.length > 0) {
                if (u_password.get(0).value !== u_password.get(1).value) {
                    valid = false;
                    appendError($(u_password.get(1)).parents(".form-group"), "Password is not matching.", u_password.get(1));
                }
            }
        }
        if (!valid) {
            e.preventDefault();
        }
    });
    </script>
</body>

</html>