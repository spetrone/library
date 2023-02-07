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
    return 1;
}

function validate_isbn10($isbn) {
    return 1;
}

function validate_isbn13($isbn) {
    return 1;
}

function validate_year($year) {
    return 1;
}




?>