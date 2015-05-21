<?php

function select_dynamique_multiple($nom, $tableau) {
    echo"<select name='$nom' multiple>";
    foreach ($tableau as $element) {
        echo "<option>" . $element . " </option>";
    }
    echo"</select>";
}

function select_dynamique($nom, $tableau) {
    echo"<select name='$nom'>";
    foreach ($tableau as $element) {
        echo "<option>" . $element . " </option>";
    }
    echo"</select>";
}

function form_radio($label, $name, $hashtable) {
    echo ("\n<!-- form_select : $label $name -->\n");
    echo("<p>\n");
    foreach ($hashtable as $key => $value) {
        echo ("<input type ='radio' name='$name' value='$value' />" . $value);
    }
    echo (" </p>\n");
}

function form_checkbox($label, $name, $hashtable) {
    echo ("\n<!-- form_select : $label -->\n");
    echo("<p>\n");
    echo ("<label>$label</label>\n");
    foreach ($hashtable as $key => $value) {
        echo ("<input type ='checkbox' name='$name' value='$value' />" . $value);
    }
}

function form_select_opt($name, $hashtable) {
    echo ('<select name=$name>');
    foreach ($hashtable as $key => $value) {
        echo ("<optgroup label='$key'>");
        foreach ($value as $k => $v) {
            echo ("<option>" . $v . "</option>");
        }
        echo('</optgroup>');
    }
    echo('</select>');
}
?>

