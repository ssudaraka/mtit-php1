<?php 

/**
 * Main page of our PHP application. If a user signed in it will show that user created
 * HTML forms or else it will just show a welcome message
 */

require_once 'config.php'; ?>

<?php
if (isset($_SESSION["user_email"])) {
    $sql = "SELECT * FROM `forms` WHERE `users_email` = '{$_SESSION["user_email"]}' ORDER BY `created_time` DESC";
    $user_forms = $connection->query($sql);
}
?>
<?php require 'template/header.php'; ?>
    <?php require 'template/navigation.php'; ?>
<div class="container">
<?php if (!isset($_SESSION["user_email"])) { ?>
        <h1>MTIT Form Generator</h1>
        <p class="lead">
            Hello there, MTIT form generator helps you to create HTML forms without any coding. 
            Just enter what are the form fields you want and generate the HTML code for your form! 
            If you <a href="sign-up.php">Sign-Up</a> with us, you can save your generated forms for later use!
        </p>
<?php } else { ?>
        <h1>Howdy <?php echo $_SESSION['user_fname'] . " " . $_SESSION['user_lname']; ?>,</h1>
        <p class="lead">
            Welcome to MTIT Form generator. Here you can <a href="create-form.php">create a new form</a> or see previously created forms. Enjoy!
        </p>
        <?php if ($user_forms->num_rows === 0) { ?>
            <div class="alert alert-danger" role="alert">Seems like you don't have any forms created. <a href="create-form.php">Start by creating a new form!</a></div>
        <?php } else { ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Form Title</th>
                        <th>Created Time</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($form = $user_forms->fetch_object()) { ?>
                    <tr>
                        <td><?php echo $form->form_title; ?></td>
                        <td><?php echo $form->created_time; ?></td>
                        <td>
                            <a href="download-my-form.php?id=<?php echo $form->id; ?>"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a> &nbsp; &nbsp;
                            <a href="delete-my-form.php?id=<?php echo $form->id; ?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                        </td>  
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
<?php } ?>
</div>
<?php require 'template/footer.php'; ?>
        