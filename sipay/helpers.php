<?php

if(!function_exists('sipay_sdk_root_path')) {
    function sipay_sdk_root_path($folder, $file = null)
    {
        $path = SIPAY_SDK_ROOT_PATH;

        $path .= trim(str_replace('/', DIRECTORY_SEPARATOR, $folder), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        return $path . ($file ?: '');
    }
}

if(!function_exists('sipay_sdk_profile_path')) {
    function sipay_sdk_profile_path($folder, $file = null)
    {
        $path = SIPAY_SDK_PROFILE_PATH;

        $path .= trim(str_replace('/', DIRECTORY_SEPARATOR, $folder), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        return $path . ($file ?: '');
    }
}

if(!function_exists('utimestamp')) {
    function utimestamp($format)
    {
        $microtime = microtime(true);
        list($sec, $usec) = preg_split('/(\.|\,)/', $microtime);
        $format = str_replace('u', $usec, $format);
        return date($format, $microtime);
    }
}

if (!function_exists('json_last_error_msg')) {
    function json_last_error_msg()
    {
        static $ERRORS = array(
            JSON_ERROR_NONE             => 'No error',
            JSON_ERROR_DEPTH            => 'Maximum stack depth exceeded',
            JSON_ERROR_STATE_MISMATCH   => 'State mismatch (invalid or malformed JSON)',
            JSON_ERROR_CTRL_CHAR        => 'Control character error, possibly incorrectly encoded',
            JSON_ERROR_SYNTAX           => 'Syntax error',
            JSON_ERROR_UTF8             => 'Malformed UTF-8 characters, possibly incorrectly encoded'
        );

        $error = json_last_error();
        return isset($ERRORS[$error]) ? $ERRORS[$error] : 'Unknown error';
    }
}
