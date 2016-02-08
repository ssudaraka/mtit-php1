<nav class="navbar navbar-default">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Form Generator</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <?php $request_url = basename($_SERVER['REQUEST_URI']); ?>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?php if(isset($_SESSION["user_email"])) { ?>
            <ul class="nav navbar-nav">
                <li data-toggle="tooltip" data-placement="bottom" title="Created Forms" <?php echo $request_url === "index.php" ? "class='active'" : null ?>><a href="index.php">My Forms</a></li>
                <li data-toggle="tooltip" data-placement="bottom" title="Create a new Form" <?php echo $request_url === "create-form.php" ? "class='active'" : null ?>><a href="create-form.php">New Form</a></li>
            </ul>
            <?php } else { ?>
                <ul class="nav navbar-nav">
                <li data-toggle="tooltip" data-placement="bottom" title="Sign-up on Form Generator" <?php echo $request_url === "sign-up.php" ? "class='active'" : null ?>><a href="sign-up.php">Sign Up</a></li>
                <li data-toggle="tooltip" data-placement="bottom" title="Login into Form Generator" <?php echo $request_url === "sign-in.php" ? "class='active'" : null ?>><a href="sign-in.php">Log in</a></li>
                <li data-toggle="tooltip" data-placement="bottom" title="Create a Form" <?php echo $request_url === "create-form.php" ? "class='active'" : null ?>><a href="create-form.php">Create Form</a></li>
            </ul>
            <?php } ?>
            
            <?php if(isset($_SESSION["user_email"])) { ?>
            <ul class="nav navbar-nav navbar-right">
                <li class="navbar-text">Hello <?php echo $_SESSION['user_fname'] . " " . $_SESSION['user_lname']; ?></li>
                <li data-toggle="tooltip" data-placement="bottom" title="Logout"><a href="sign-out.php"><span class="glyphicon glyphicon-off" aria-hidden="true"></span></a></li>
            </ul>
            <?php } ?>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
