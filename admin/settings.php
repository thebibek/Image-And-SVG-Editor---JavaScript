<?php 
    require_once("includes/db.php");
    $page_name = "Settings";
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once("includes/head.php"); ?>
</head>

<body>
    <?php require_once("includes/sidemenu.php") ?>
    <div class="all-content">
    	<div class="wrapper">
    		<div class="card">
    			<div class="card-header">Change Passowrd</div>
    			<div class="card-body">
                    <form action="settings" method="POST" class="submit_form">
                        <div class="col-md-6">
                            <div class="form-group">
                                <span class="label">Existing Password</span>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    <input type="password" class="form-control" name="current_password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <span class="label">New Password</span>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                                    <input type="password" class="form-control u_password" name="new_password" data-length="[8,20]" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <span class="label">Confirm Password</span>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                                    <input type="password" class="form-control u_password" name="confirm_password" data-length="[8,20]" required>
                                </div>
                            </div>
                            <input type="hidden" name="changePassword" value="1">
                            <button type="submit" class="btn btn-block s-btn">
                                <span class="text">Change</span>
                            </button>
                        </div>
                    </form>
    			</div>
    		</div>
    	</div>
    </div>
    <?php require_once("includes/footer.php"); ?>
</body>

</html>