<?php require_once 'config.php'; ?>
<?php
$form_data = array(
    'first_name' => null,
    'last_name' => null,
    'email' => null,
    'password' => null,
    'conf_password' => null,
);

function user_exists($email, $connection) {
    $sql = "SELECT * FROM `users` WHERE `email` = '{$email}'";
    $result = $connection->query($sql);

    return $result->num_rows > 0 ? TRUE : FALSE;
}

function create_user($user, $connection) {

    $hashed_pw = md5($user['password']);
    $sql = "INSERT INTO `users` (`email`, `password`, `first_name`, `last_name`) VALUES ("
            . "'{$user['email']}', "
            . "'{$hashed_pw}',"
            . "'{$user['first_name']}',"
            . "'{$user['last_name']}')";

    $connection->query($sql);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_error = array();

    $form_data = array(
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'conf_password' => $_POST['conf_password'],
    );

    if (user_exists($form_data['email'], $connection)) {
        $form_error['email'] = "This email is already registered";
    }

    if ($form_data['password'] !== $form_data['conf_password']) {
        $form_error['password'] = "Password doesn't match with Password confirmation";
    }

    if (count($form_error) === 0) {
        create_user($form_data, $connection);
        header('Location: reg-success.php');
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
                    <h3>Sign Up</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" action="sign-up.php" method="post">
                        <div class="form-group <?php echo (isset($form_error['first_name']) ? "has-error" : null); ?>">
                            <label for="first_name" class="col-sm-2 control-label">First Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter your first name" value="<?php echo $form_data['first_name']; ?>" required>
                                <?php if (isset($form_error['first_name'])) { ?>
                                    <span class="help-block">
                                        <?php echo $form_error['first_name']; ?>
                                    </span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group <?php echo (isset($form_error['last_name']) ? "has-error" : null); ?>">
                            <label for="last_name" class="col-sm-2 control-label">Last Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter your last name" value="<?php echo $form_data['last_name']; ?>" required>
                                <?php if (isset($form_error['last_name'])) { ?>
                                    <span class="help-block">
                                        <?php echo $form_error['last_name']; ?>
                                    </span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group <?php echo (isset($form_error['email']) ? "has-error" : null); ?>">
                            <label for="email" class="col-sm-2 control-label">E-Mail Address</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" value="<?php echo $form_data['email']; ?>" required>
                                <?php if (isset($form_error['email'])) { ?>
                                    <span class="help-block"><?php echo $form_error['email']; ?></span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group <?php echo (isset($form_error['password']) ? "has-error" : null); ?>">
                            <label for="password" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                <?php if (isset($form_error['password'])) { ?>
                                    <span class="help-block">
                                        <?php echo $form_error['password']; ?>
                                    </span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group <?php echo (isset($form_error['conf_password']) ? "has-error" : null); ?>">
                            <label for="conf_password" class="col-sm-2 control-label">Confirm Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="conf_password" name="conf_password" placeholder="Enter your password again" required>
                                <?php if (isset($form_error['conf_password'])) { ?>
                                    <span class="help-block"></span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-8">
                                <button type="submit" class="btn btn-info">Sign Up</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'template/footer.php'; ?>
        