<?php

namespace XMVC\Service;

class Flash
{
    public static function success($message)
    {
        Session::set('flash_message', [
            'type' => 'success',
            'message' => $message,
        ]);
    }

    public static function error($message)
    {
        Session::set('flash_message', [
            'type' => 'error',
            'message' => $message,
        ]);
    }

    public static function get()
    {
        $message = Session::get('flash_message');
        Session::forget('flash_message');
        return $message;
    }
}