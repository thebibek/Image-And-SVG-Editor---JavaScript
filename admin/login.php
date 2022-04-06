<?php 
    require_once("../includes/db.php");
    if(isset($_SESSION['admin'])){
        echo '<script>location.assign("dashboard")</script>';
        die();
    }
    if(isset($_POST['login'])){
        $email = ($_POST['email']);
        $password = ($_POST['password']);
        $login = $db->selectSingle("admins",array(
            "email" => $email
        ));
        if($login){
            if(password_verify($password, $login['password'])){
                $admin_id = $login['id'];
                $_SESSION['admin'] = $admin_id;
                echo '<script>location.assign("dashboard")</script>';
                die();
            } else {
                echo '<script>location.assign("login?error=Password is wrong. Please Try with a valid  password")</script>';
            }
        } else {
            echo '<script>location.assign("login?error=Email or Password is wrong. Please Try with a valid email and password")</script>';
        }
    }
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login |
        <?php echo $site_name; ?>
    </title>
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body class="content-center">
    <div class="col-lg-4 col-md-8 bg_dark p-5">
        <form action="login" method="POST">
            <div class="form-group">
                <h3 class="heading mb-5 text-center">
                    <?php echo $site_name; ?> | Admin
                </h3>
            </div>
            <div class="form-group">
                <span class="label">Email</span>
                <div class="input-group">
                    <input type="email" name="email" class="form-control" placeholder="Enter Your Email...." required>
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
            </div>
            <div class="form-group">
                <span class="label">Password</span>
                <div class="input-group">
                    <input type="password" name="password" class="form-control" required>
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                </div>
                <div class="pull-right mt-3">
                    <a href="forgot">Forgot Password?</a>
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
                <input type="hidden" name="login" value="1">
                <button class="btn-block btn s-btn" type="submit"><span class="text">Login</span></button>
            </div>
        </form>
    </div>
    <script src="../js/jquery.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>