<?php

require '../vendor/autoload.php';

function shutdown()
{
    if (($error = error_get_last())) {
        println($error);
//        ob_clean();
        # raport the event, send email etc.
//        header("Location: http://localhost/error-capture");
        # from /error-capture, you can use another redirect, to e.g. home page
    }
}

function customError($errno, $errstr, $errfile, $errline)
{
    // echo "Error: [$errno] $errstr\n";
    $ret = func_get_args();
    $end = array_pop($ret);
    // print_r($end);
    print_r($ret);
}

function exception_error_handler($severity, $message, $file, $line)
{
    if (!(error_reporting() & $severity)) {
        // This error code is not included in error_reporting
        return;
    }
    println("-------------------------------------------finish--------------------------");
    throw new ErrorException($message, 0, $severity, $file, $line);
}

//set_error_handler("customError");
set_error_handler("exception_error_handler");
//register_shutdown_function('shutdown');

//println('E_ALL:'.E_ALL);
//println(decbin(E_ALL));
//println('E_STRICT:'.E_STRICT);
//println(decbin(E_STRICT));
//$bit = E_ALL|E_STRICT;
//println('E_ALL|E_STRICT:'.$bit);

//println(5/0 );

strpos();
//println(4|1);

//echo($test);
//$file = fopen('a.jpg', 'r');

