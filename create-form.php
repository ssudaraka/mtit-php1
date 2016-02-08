<?php require_once 'config.php'; ?>
<?php

/**
 * Method to build the HTML input field tags.
 * 
 * @param Int $index Array index of the $_POST array
 * @return String 
 */
function get_form_string($index) {
    switch ($_POST['field_type'][$index]) {
        case 'TEXT':
            $string = "<tr><td>{$_POST['field_title'][$index]}:</td><td> <input type='text' name='{$_POST['field_name'][$index]}'><td></tr>";
            return $string;
        case 'CHEC':
            $string = "<tr><td>{$_POST['field_title'][$index]}</td><td>";
            $options = explode(",", $_POST['field_options'][$index]);
            foreach ($options as $option) {
                $string .= "<input type='checkbox' name='{$_POST['field_name'][$index]}' value='{$option}'> {$option} ";
            }
            $string .= "</td></tr>";
            return $string;
        case 'DATE':
            $string = "<tr><td>{$_POST['field_title'][$index]}:</td><td> <input type='date' name='{$_POST['field_name'][$index]}'></td></tr>";
            return $string;
        case 'PASS':
            $string = "<tr><td>{$_POST['field_title'][$index]}: </td><td><input type='password' name='{$_POST['field_name'][$index]}'></td></tr>";
            return $string;
        case 'RADI':
            $string = "<tr><td>{$_POST['field_title'][$index]}</td><td>";
            $options = explode(",", $_POST['field_options'][$index]);
            foreach ($options as $option) {
                $string .= "<input type='radio' name='{$_POST['field_name'][$index]}' value='{$option}'> {$option} ";
            }
            $string .= "</td></tr>";
            return $string;
        case 'SUBM':
            $string = "<tr><td></td><td><input type='submit' name='{$_POST['field_name'][$index]}' value='{$_POST['field_title'][$index]}'></td></tr>";
            return $string;
        case 'TXTA':
            $string = "<tr><td>{$_POST['field_title'][$index]}:</td><td><textarea name='{$_POST['field_name'][$index]}'></textarea></td></tr>";
            return $string;
        case 'BUTT':
            $string = "<tr><td></td><td><button name='{$_POST['field_name'][$index]}'>{$_POST['field_title'][$index]}</button></td></tr>";
            return $string;
        case 'SELE':
            $string = "<tr><td>{$_POST['field_title'][$index]}:</td><td><select name='{$_POST['field_name'][$index]}'>";
            $options = explode(",", $_POST['field_options'][$index]);
            foreach ($options as $option) {
                $string .= "<option value='{$option}'>{$option}</option>";
            }
            $string .= "</select></td></tr>";
            return $string;
    }
}

/**
 * Method to create a form in the database.
 * 
 * @param String $title Title of the form
 * @param String $time Time of the form created
 * @param String $user_email User's email address
 * @param Mixed $connection DB Connection
 * @return Int Newly created form's ID
 */
function create_form($title, $time, $user_email, $connection){
    $sql = "INSERT INTO `forms` (`form_title`, `created_time`, `users_email`) VALUES "
            . "('{$title}', '{$time}', '{$user_email}')";

    $connection->query($sql);
    return $connection->insert_id;
}

/**
 * Method to add the form field information to database.
 * 
 * @param Int $form_id
 * @param String $user_email
 * @param String $field_type
 * @param String $field_name
 * @param Int $order
 * @param String $options
 * @param Mixed $connection
 */
function save_field($form_id, $user_email, $field_type, $field_title, $field_name, $order, $options, $connection){
    $sql = "INSERT INTO `forms_fields` (`forms_id`, `forms_users_email`, `fields_type`, `field_title`, `field_name`, "
            . "`form_order`, `options`) VALUES ({$form_id}, '{$user_email}', '{$field_type}', "
            . "'{$field_title}', '{$field_name}', $order, '{$options}')";
            
    $connection->query($sql);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_string = null;
    $form_error = array();
    if (!isset($_POST['field_type'])) {
        $form_error['nofields'] = "Form needs atleast one form field to be generated.";
    } else {
        
        $form_id = null;
        
        if(isset($_SESSION['user_email'])) {
            $form_id = create_form($_POST['form_name'], date("Y-m-d H:i:s"), $_SESSION['user_email'], $connection);
        }
        
        $form_string = "<h2>{$_POST['form_name']}</h2><form>";
        $form_string .= "<table>";
        for ($i = 0; $i < count($_POST['field_type']); $i++) {
            $form_string .= get_form_string($i);

            if ($form_id) {
                save_field($form_id, $_SESSION['user_email'], $_POST['field_type'][$i], $_POST['field_title'][$i], $_POST['field_name'][$i], $i+1, $_POST['field_options'][$i], $connection);
            }
            
        }
        $form_string .= "</table>";
        $form_string .= "</form>";

        $_SESSION['form_title'] = $_POST['form_name'];
        $_SESSION['form_string'] = $form_string;
    }
}
?>

<?php require 'template/header.php'; ?>
<?php require 'template/navigation.php'; ?>
<script>
    $(document).ready(function () {


        $("#add-new").click(function () {
            var fieldText = getFieldText();
            $("#playground").append(fieldText);
        });

        $("body").on("click", ".delete-row", function (event) {
            event.preventDefault();
            $(this).closest('tr').remove();
        });

    });

    function getFieldText() {
        var string = "<tr><td><select class='form-control type-selector' name='field_type[]'>" +
                "<option value='TEXT'>Text Input</option>" +
                "<option value='CHEC'>Checkbox</option>" +
                "<option value='DATE'>Date Select Field</option>" +
                "<option value='PASS'>Password Field</option>" +
                "<option value='RADI'>Radio Button</option>" +
                "<option value='SUBM'>Submit Button</option>" +
                "<option value='TXTA'>Text Area</option>" +
                "<option value='BUTT'>Button</option>" +
                "<option value='SELE'>Select Field</option>" +
                "</select></td><td>Title :</td> " +
                "<td><input type='text' class='form-control' name='field_title[]'></td>" +
                "<td>Name :</td>" +
                "<td><input type='text' class='form-control' name='field_name[]' required></td>" +
                "<td>Options :</td>" +
                "<td><input type='text' class='form-control' name='field_options[]' placeholder='Seperate options by a comma'></td>" +
                "<td><a class='delete-row' href='#'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></td>";

        return string;
    }

</script>
<?php if (isset($form_string)) { ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Form Preview
                    </div>
                    <div class="panel-body">
                        <?php echo $form_string; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Code
                    </div>
                    <div class="panel-body">
                        <p>
                            <a href="download-form.php">Download HTML page</a>
                        </p>
                        <br />
                        <code>
                            <?php echo htmlspecialchars($form_string); ?>
                        </code>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p class="lead">
                    To create a new form, Add new form field then fill the <strong>Title</strong> 
                    of that field, Enter the <strong>Name</strong> for that field and 
                    <strong>Enter Options separated by commas ( , )</strong>
                </p>
            </div>
        </div>
        <?php if (isset($form_error['nofields'])) { ?>
            <div class="alert alert-danger" role="alert"><?php echo $form_error['nofields']; ?></div>
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Create a new form</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <button id="add-new" class="btn btn-block btn-info">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
                                    Add New Field
                                </button>
                            </div>
                        </div>
                        <form  action="create-form.php" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" style="margin-top: 10px">
                                        <label for="form_name">Form Tile</label>
                                        <input type="text" class="form-control" id="form_title" name="form_name" placeholder="Enter a name for your form" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div  class="col-md-12 form-group-sm">
                                    <table id="playground" class="table table-bordered">
                                    </table>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary" name="create-submit">
                                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 
                                        Create Form
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php require 'template/footer.php'; ?>

