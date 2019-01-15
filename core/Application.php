<?php

namespace Core;

class Application
{
    public function __construct()
    {
        $this->setReporting();
        $this->unregisterGlobals();
    }

    private function setReporting()
    {
        if (DEBUG) {
            error_reporting(E_ALL);
            ini_set("display_errors", 1);
        } else {
            error_reporting(0);
            ini_set("display_errors", 0);
            ini_set("log_errors", 1);
            ini_set("error_log", ROOT . DS . 'log' . DS . 'general' . DS . 'errors.log');
        }
        
    }

    private function unregisterGlobals()
    {
        if (ini_get('register_globals')) {
            $globalsAry = ['_SESSION', '_COOKIE', '_POST', '_GET', '_REQUEST', '_SERVER', '_ENV', '_FILES'];

            foreach ($globalsAry as $item) {
                foreach ($GLOBALS[$item] as $key => $value) {
                    if ($GLOBALS[$key] === $value) {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }
}