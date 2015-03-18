<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 *
 * -----------------------------------------------------------------------------
 * Errors and Exceptions core
 *
 * This includes helper for handling system-level errors and exceptions
 */

/**
 * [ SYSTEM USE ONLY ]
 */
function coresys_handle_error($level, $str, $file, $line)
{
    $error_levels = array(
        E_COMPILE_ERROR => 'Fatal compile-time error',
        E_COMPILE_WARNING => 'Compile-time warning',
        E_ERROR => 'Fatal runtime error',
        E_NOTICE => 'Runtime notice',
        E_PARSE => 'Compile-time parse error',
        E_WARNING => 'Runtime warning',
        E_USER_WARNING => 'User-defined warning',
        E_USER_NOTICE => 'User-define notice',
        E_USER_ERROR => 'User-defined error',
        E_RECOVERABLE_ERROR => 'Catchable error'
    );

    echo '<div style="border:2px solid #f00; padding:2%; font-family:arial;" align="left">';
        echo '<span style="font-variant:small-caps;"><b><u>ERROR</u> at Line '.$line.'</b><br>'
                .'<span style="font-variant:normal;font-family:monospace;">'.$file.'</span></span>';
        echo '<p style="padding:2%; border-left:3px solid #f00; margin:0px; margin-top:5px;">';
            echo '<span style="font-variant:small-caps;">['.$error_levels[$level].']&nbsp;&nbsp;</span>';
            echo '<br>';
            echo '<br>';
            echo '<span style="font-family:sans-serif;">'.$str.'</span>';
        echo '</p>';
    echo '</div>';
}


/**
 * [ SYSTEM USE ONLY ]
 */
function coresys_handle_exception(\Exception $ex)
{
    echo '<div style="border:2px solid #f00; padding:2%; font-family:arial;" align="left">';
        echo '<span style="font-variant:small-caps;">';
        echo '<b><u>Uncaugh Exception</u> at Line '.$ex->getLine().'</b><br>'.$ex->getFile().'</span>';
        echo '<p style="padding:2%; border-left:3px solid #f00; margin:0px; margin-top:5px;">';
            echo '<span style="font-variant:small-caps;">['.$ex->getCode().']&nbsp;&nbsp;</span>';
            echo '<br>';
            echo '<br>';
            echo $ex->getMessage();
            echo '<br>';
            echo '<br>';
            echo '<u>Trace stack:</u>';
            echo '<br>';
//            $stackTraces = $ex->getTrace();
//            POPS\Utils\ARRAYS::Dump($stackTraces);
            $stackTrace = $ex->getTraceAsString();
            echo preg_filter("/\s?#\d+\s/", "<br>", $stackTrace);
        echo '</p>';
    echo '</div>';
}