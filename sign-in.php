<?php require_once 'config.php'; ?>
<?php

$form_data = array(
    'email' => null,
    'password' => null,
);

function sign_in($email, $password, $connection){
    $hashed_pw = md5($password);
    $sql = "SELECT * FROM `users` WHERE `email` = '{$email}' AND `password` = '{$hashed_pw}'";
    
    $result = $connection->query($sql);
    return $result->num_rows === 1 ? $result->fetch_object() : null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_error = array();
    $form_data['email'] = $_POST['email'];
    $user = sign_in($_POST['email'], $_POST['password'], $connection);
    
    if($user){
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_fname'] = $user->first_name;
        $_SESSION['user_lname'] = $user->last_name;
        
        header('Location: index.php');
    } else {
        $form_error['email'] = "Invalid email or password";
    }
}

?>
<?php require 'template/header.php'; ?>
<?php require 'template/navigation.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Sign In</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" action="sign-in.php" method="post">
                        <div class="form-group <?php echo (isset($form_error['email']) ? "has-error" : null); ?>">
                            <label for="email" class="col-sm-2 control-label">E-Mail Address</label>
                            <div class="col-sm-4">
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $form_data['email']; ?>" required>
                                <?php if (isset($form_error['email'])) { ?>
                                    <span class="help-block">
                                        <?php echo $form_error['email']; ?>
                                    </span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group <?php echo (isset($form_error['password']) ? "has-error" : null); ?>">
                            <label for="password" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <?php if (isset($form_error['password'])) { ?>
                                    <span class="help-block">
                                        <?php echo $form_error['password']; ?>
                                    </span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-8">
                                <button type="submit" class="btn btn-info">Sign In</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'template/footer.php'; ?>