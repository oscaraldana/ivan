<?php

/**
 * Clase Singleton para la conexi�n de base de datos de Multinet
 * @author Frank Mu�oz
 * @date   22 de Septiembre de 2016
 */
Class MultinetConex
{

    private static $conex;

    public static function conex()
    {
        if (!isset(self::$conex)) {
            self::requireFilesConnection();
            $multinet = new conex(MULTINET_USER, MULTINET_PASSWORD, MULTINET_HOST, MULTINET_PORT_DB, MULTINET_DB, true, false);
            self::$conex = $multinet;
        }
        return self::$conex;
    }

    private static function requireFilesConnection()
    {
        require_once __DIR__ . '/../config.php';
    }

}
