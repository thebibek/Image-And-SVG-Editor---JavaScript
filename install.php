<?php
    require_once('./includes/inc/config.php');
    if((defined('DB_HOST') && defined('DB_USER') && defined('DB_PASSWORD') && defined('DB_NAME'))){
        echo '<script>location.assign("index");</script>';
        die();
    }
    if(isset($_POST['install'])){
        $admin_password = password_hash($_POST['admin_password'], PASSWORD_BCRYPT);
        $admin_email = $_POST['admin_email'];
        unset($_POST['install']);
        unset($_POST['admin_password']);
        $config_data = '<?php' . PHP_EOL;
        foreach($_POST as $key => $value){
            if(strstr(strtolower($key), 'db')){
                $config_data .= 'define("'. $key .'" , "'. $value .'");' . PHP_EOL;
                define("$key", "$value");
            } else {
                $config_data .= '$' . $key . ' = "'. $value .'";' . PHP_EOL;
            }
        }
        $config_data .= '?>';
        $file = fopen('./includes/inc/config.php', 'w');
        fwrite($file, $config_data);
        fclose($file);
        $file = fopen('./admin/includes/inc/config.php', 'w');
        fwrite($file, $config_data);
        fclose($file);
        $no_db_redirects = true;
        require_once('./includes/inc/database.php');
        require_once('./includes/inc/install_database.php');
        $update = $db->update('admins', array(
            'email' => $admin_email,
            'password' => $admin_password
        ));
        header('Location: index');
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install | Imageeditor</title>
    <link rel="stylesheet" href="./css/fonts.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body class="content-center">
    <div class="col-lg-8 col-md-8 bg_dark p-5">
        <form action="install" method="POST">
            <div class="row">
                <div class="form-group col-12">
                    <h3 class="heading mb-2 text-center">
                        Install | <?php echo 'Imageeditor'; ?>
                    </h3>
                    <p class="text-center mb-5">Please fill the information to install the imageeditor</p>
                </div>
                <div class="form-group col-md-6">
                    <span class="label">DB Host</span>
                    <input type="text" name="DB_HOST" class="form-control" placeholder="e.g localhost" required>
                </div>
                <div class="form-group col-md-6">
                    <span class="label">DB User</span>
                    <input type="text" name="DB_USER" class="form-control" placeholder="e.g root" required>
                </div>
                <div class="form-group col-md-6">
                    <span class="label">DB Name</span>
                    <input type="text" name="DB_NAME" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <span class="label">DB Password</span>
                    <input type="password" name="DB_PASSWORD" class="form-control">
                </div>
                <div class="col-12">
                    <hr>
                </div>
                <div class="form-group col-md-6">
                    <span class="label">Site Name</span>
                    <input type="text" name="site_name" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <span class="label">Site URL</span>
                    <input type="text" name="site_url" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <span class="label">Admin Email</span>
                    <input type="email" name="admin_email" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <span class="label">Admin Password</span>
                    <input type="password" name="admin_password" class="form-control" required>
                </div>
                <div class="form-group col-12">
                    <input type="hidden" name="install" value="1">
                    <button class="btn-block btn s-btn" type="submit"><span class="text">Login</span></button>
                </div>
            </div>
        </form>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="admin/js/script.js"></script>
</body>

</html>