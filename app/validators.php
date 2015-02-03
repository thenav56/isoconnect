<?php


/*
* app/validators.php
*/

Validator::extend('alpha_spaces', function($attribute, $value)
{
    return preg_match('/^[\pL\s]+$/u', $value);
});



Validator::extend('alpha_num_dashes', function($attribute, $value)
{
    return preg_match('/^[ \w<>-]+$/', $value);
}); // \w is A-Za-z0-9_ 