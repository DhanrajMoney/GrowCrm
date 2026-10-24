<?php

/**
 * checck if we have a numeric id or disable the for
 * @return string a very random unique id
 */

function moduleCheckID($id = '') {
    return (is_numeric($id)) ? '' : 'disabled';
}

/**
 * return a checked or unchecked image
 * @return string a very random unique id
 */

function moduleCheckBoxStatus($status = '') {
    return ($status == 'yes') ? 'check-box-checked.jpg' : 'check-box.jpg';
}