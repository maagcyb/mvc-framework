<?php

declare(strict_types=1);

namespace Core;

use App\Config;
use http\Exception;

class Error
{
    public static function errorHandler(int $level, string $message, string $file, int $line)
    {
        if (error_reporting() !== 0){ //was bedeutet 0?
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
        return null;
    }

    public static function exceptionHandler(\Exception $exception): void
    {
        $code = $exception->getCode();
        if ($code != 404){
            $code = 500;
        }
        http_response_code($code);

        if (Config::SHOW_ERRORS){
            echo '<h1>Fatal Error</h1>';
            echo '<p>Uncaught Exception: ' . get_class($exception) . '</p>';
            echo '<p>Message: ' . $exception->getMessage() . '</p>';
            echo '<p>Stacktrace: <pre>' . $exception->getTraceAsString() . '</pre></p>';
            echo '<p>Thrown in: ' . $exception->getFile() . ' on line: ' . $exception->getLine() . '</p>';
        } else {
            $log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.txt';
            ini_set('error_log', $log);

            $message = 'Uncaught Exception: ' . get_class($exception);
            $message .= ' with message: ' . $exception->getMessage();
            $message .= '\nStacktrace: ' . $exception->getTraceAsString();
            $message .= '\nThrown in: ' . $exception->getFile() . ' on line: ' . $exception->getLine();

            error_log($message);

            View::renderTemplate("$code.html");
        }
    }
}