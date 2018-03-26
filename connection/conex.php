<?php


Class WolfConex
{

    private static $conex;

    public static function conex()
    {
        if (!isset(self::$conex)) {
            self::requireFilesConnection();
            $multinet = new class_conex(USER_DB, PASWD_DB, HOST_DB, PORT_DB, NAME_DB, true, false);
            self::$conex = $multinet;
        }
        return self::$conex;
    }

    private static function requireFilesConnection()
    {
        require_once __DIR__ . '/../conf/conf.php';
    }

}