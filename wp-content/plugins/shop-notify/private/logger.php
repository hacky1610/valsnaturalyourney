<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once dirname( __FILE__ ) . '/interfaces/ILogger.php';


class Logger implements ILogger{

    public function Info($message) {
        $this->Write($message);
    }

    public function Call() {
        $this->Write("Call");      
    }

    private function Write( $message)
    {
        if (WP_DEBUG === true) {
            $caller = debug_backtrace()[2];
            $function = $caller['function'];
            $class = $caller['class'];
            if (is_array($message) || is_object($message)) {
                error_log($class . " | " .$function . " | " . print_r($message, true));
            } else {
                error_log($class . " | " . $function . " | " .$message);
            }
        }
    }
}

