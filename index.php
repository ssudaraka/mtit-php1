<?php require_once 'config.php'; ?>
<?php require 'template/header.php'; ?>
<?php require 'template/navigation.php'; ?>
<div class="container">
    <?php if(!isset($_SESSION["user_email"])) { ?>
    <h1>MTIT Form Generator</h1>
    <p class="lead">
        Hello there, MTIT form generator helps you to create HTML forms without any coding. 
        Just enter what are the form fields you want and generate the HTML code for your form! 
        If you <a href="sign-up.php">Sign-Up</a> with us, you can save your generated forms for later use!
    </p>
    <?php } else { ?>
    <h1>Howdy <?php echo $_SESSION['user_fname'] . " " . $_SESSION['user_lname'] ; ?>,</h1>
    <p class="lead">
        Welcome to MTIT Form generator. Here you can <a href="create-form.php">create a new form</a> or see previously created forms. Enjoy!
    </p>
    <div class="alert alert-danger" role="alert">Seems like you don't have any forms created. <a href="create-form.php">Start by creating a new form!</a></div>
    <?php } ?>
</div>
<?php require 'template/footer.php'; ?>
        