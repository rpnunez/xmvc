<?php

namespace XMVC\Service;

class Log
{
    protected static function write($level, $message)
    {
        $channel = Config::get('log.default');
        $logFile = Config::get("log.channels.{$channel}.path");

        $logDir = dirname($logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $message = sprintf(
            "[%s] %s: %s" . PHP_EOL,
            date('Y-m-d H:i:s'),
            strtoupper($level),
            $message
        );

        file_put_contents($logFile, $message, FILE_APPEND);
    }

    public static function info($message)
    {
        static::write('info', $message);
    }

    public static function error($message)
    {
        static::write('error', $message);
    }
}