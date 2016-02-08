<?php
/**
 * This page responds to user's previously created forms download requests.
 */
require_once 'config.php';

function get_form_string($field_type, $field_title, $field_name, $options) {
    switch ($field_type) {
        case 'TEXT':
            $string = "<tr><td>{$field_title}:</td><td> <input type='text' name='{$field_name}'><td></tr>";
            return $string;
        case 'CHEC':
            $string = "<tr><td>{$field_title}</td><td>";
            $options = explode(",", $options);
            foreach ($options as $option) {
                $string .= "<input type='checkbox' name='{$field_name}' value='{$option}'> {$option} ";
            }
            $string .= "</td></tr>";
            return $string;
        case 'DATE':
            $string = "<tr><td>{$field_title}:</td><td> <input type='date' name='{$field_name}'></td></tr>";
            return $string;
        case 'PASS':
            $string = "<tr><td>{$field_title}: </td><td><input type='password' name='{$field_name}'></td></tr>";
            return $string;
        case 'RADI':
            $string = "<tr><td>{$field_title}</td><td>";
            $options = explode(",", $options);
            foreach ($options as $option) {
                $string .= "<input type='radio' name='{$field_name}' value='{$option}'> {$option} ";
            }
            $string .= "</td></tr>";
            return $string;
        case 'SUBM':
            $string = "<tr><td></td><td><input type='submit' name='{$field_name}' value='{$field_title}'></td></tr>";
            return $string;
        case 'TXTA':
            $string = "<tr><td>{$field_title}:</td><td><textarea name='{$field_name}'></textarea></td></tr>";
            return $string;
        case 'BUTT':
            $string = "<tr><td></td><td><button name='{$field_name}'>{$field_title}</button></td></tr>";
            return $string;
        case 'SELE':
            $string = "<tr><td>{$field_title}:</td><td><select name='{$field_name}'>";
            $options = explode(",", $options);
            foreach ($options as $option) {
                $string .= "<option value='{$option}'>{$option}</option>";
            }
            $string .= "</select></td></tr>";
            return $string;
    }
}

if (isset($_GET['id']) AND isset($_SESSION['user_email'])) {
    $sql = "SELECT * FROM `forms` WHERE `id` = {$_GET['id']} AND `users_email`= '{$_SESSION['user_email']}'";
    $result = $connection->query($sql);

    $form_fields = null;
    if ($result->num_rows > 0) {
        $sql = "SELECT * FROM `forms_fields` WHERE forms_id = {$_GET['id']} ORDER BY `form_order`";
        $form_fields = $connection->query($sql);
    }
    
    $form = $result->fetch_object();

    $form_string = "<h2>{$form->form_title}</h2><form>";
    $form_string .= "<table>";
    while ($form_field = $form_fields->fetch_object()) {
        $form_string .= get_form_string($form_field->fields_type, $form_field->field_title, $form_field->field_name, $form_field->options);
    }
    $form_string .= "</table>";
    $form_string .= "</form>";

    $_SESSION['form_title'] = $form->form_title;
    $_SESSION['form_string'] = $form_string;
}
?>
<?php require 'template/header.php'; ?>
<?php require 'template/navigation.php'; ?>

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
<?php } ?>