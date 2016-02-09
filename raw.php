<?php

session_start();
//var_dump($_POST);
//var_dump($_SESSION);
//var_dump($_SERVER["REQUEST_METHOD"]);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    session_unset();
}

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

if (!isset($_SESSION['field_count'])) {
    $_SESSION['field_count'] = 0;
}
if (isset($_POST['add_field'])) {
    $_SESSION['field_count'] += 1;
}
if (isset($_POST['del_field'])) {
    $_SESSION['field_count'] -= 1;
}
if (isset($_POST['create_form'])) {
    $form_string = "<h2>{$_POST['form_name']}</h2><form>";
    $form_string .= "<table>";
    for ($i = 0; $i < count($_POST['field_type']); $i++) {
        $form_string .= get_form_string($i);
    }
    $form_string .= "</table>";
    $form_string .= "</form>";

    $_SESSION['form_title'] = $_POST['form_name'];
    $_SESSION['form_string'] = $form_string;
}




if (isset($_SESSION['form_string'])) {
    echo "<h3>Your form is generated.</h3>";
    echo $_SESSION['form_string'];
    echo "<br />";
    echo "<a href='download-form.php'>Download Form</a>";
} else {

    echo "<h3>Form Generator</h3>";
    echo "<form action='raw.php' method='post'><button type='submit' name='add_field'>Add Field</button></form>";
    if (isset($_SESSION['field_count']) AND $_SESSION['field_count'] > 0) {
        echo "<form action='raw.php' method='post'><button type='submit' name='del_field'>Delete Field</button></form>";
    }

    echo "<form action='raw.php' method='post'>";
    echo "<table>";
    echo "<tr><td>Form Name:</td><td><input type='text' name='form_name'></td></tr>";
    echo "</table>";

    echo "<table>";
    if (isset($_SESSION['field_count'])) {
        for ($i = 0; $i < $_SESSION['field_count']; $i++) {
            echo "<tr><td><select class='form-control type-selector' name='field_type[]'>" .
            "<option value='TEXT'>Text Input</option>" .
            "<option value='CHEC'>Checkbox</option>" .
            "<option value='DATE'>Date Select Field</option>" .
            "<option value='PASS'>Password Field</option>" .
            "<option value='RADI'>Radio Button</option>" .
            "<option value='SUBM'>Submit Button</option>" .
            "<option value='TXTA'>Text Area</option>" .
            "<option value='BUTT'>Button</option>" .
            "<option value='SELE'>Select Field</option>" .
            "</select></td><td>Title :</td> " .
            "<td><input type='text' class='form-control' name='field_title[]'></td>" .
            "<td>Name :</td>" .
            "<td><input type='text' class='form-control' name='field_name[]' required></td>" .
            "<td>Options :</td>" .
            "<td><input type='text' class='form-control' name='field_options[]' placeholder='Seperate options by a comma'></td>" .
            "<td><a class='delete-row' href='#'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></td>";
        }
    }
    echo "</table>";
    if (isset($_SESSION['field_count']) AND $_SESSION['field_count'] > 0) {
        echo "<br />";
        echo "<input type='submit' name='create_form' value='Create Form'>";
    }
    echo "</form> ";
}
