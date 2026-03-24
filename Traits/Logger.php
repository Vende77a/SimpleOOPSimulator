<?php
namespace App\Traits;

trait Logger {
    public function log($message) {
        echo $message . PHP_EOL;
    }
}
