<?php


function is_valid_password($value) {
    if (isset($value) && strlen($value) > 5 && strlen($value) < 21 && ctype_alpha($value)) {
        return true;
    } else {
        return false;
    }
}

function is_valid_username($value) {
    if (isset($value) && strlen($value) < 41 && $value != '') {
        return true;
    } else {
        return false;
    }
}

function is_valid_email($value) {
    if (isset($value) && strlen($value) > 0 && strlen($value) < 255) {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else
            return false;
    } else {
        return false;
    }
}

/*** for book form */
function validate_book_title($title) {
    if (isset($title) && strlen($title) > 0 && strlen($title) < 255)
        return 1;
    else
        return 0;
}

function validate_year($year) {
    if (isset($year) && strlen($year) == 4 && is_numeric($year))
    return 1;
else
    return 0;
}




?>