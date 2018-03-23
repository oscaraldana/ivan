<?php

/*
 * Esta clase permitira generar un log localmente de mensajes con soporte de backtrace.
 */

/**
 * Description of DebugBack
 *
 * @author Alan Acosta <zagato.gekko@gmail.com>
 */
class DebugBack {
    public static $enable = true;
	
	public static $maxDebugLevel = 0; // Si es cero acepta todos los niveles
	
	public static $fileName = "debug_log";

        const LOG_FAC = true;
    
    private static function dMsg( $msg = "", $debugLevel = 2, $withTrace = true )
    {
		$filePath = RUTA_LOGS.'/'.DebugBack::$fileName;
        
		try
		{
			$cadena = self::buildErrorString("<strong style='color:red;'>$msg</strong>", $debugLevel, $withTrace);
			$f = @fopen($filePath, "a+");
			if($f)
			{
				@fwrite($f, "\n\n==================================================================\n");
				@fwrite($f, $cadena);
				@fclose($f);
			}else {
				error_log("Error abriendo el archivo de debugBack: {$filePath}");
			}
		}  catch (Exception $e)
		{
			//
		}
    }
	
    public static function buildErrorString( $msg = "", $debugLevel = 1, $withTrace = true )
    {
		$resp = "";
		try
		{
			$t = date("Y-m-d H:i:s");
			$prefix = "";
			if( $withTrace )
			{
				$arr_debug = debug_backtrace();
				$startLevel = (count($arr_debug)-1);
				if( self::$maxDebugLevel>0 && $startLevel>self::$maxDebugLevel )
					$startLevel = self::$maxDebugLevel;
				$debugPos = 0;
				for ($index = $startLevel; ($debugLevel==0 || $debugPos < $debugLevel) ; $index--, $debugPos++)
				{
					if( !isset($arr_debug[$index]) ) {
						break;
					}
					$arr = $arr_debug[$index]; // 0 seria gMsg, 1, seria desde donde se llama
					if( $arr['function'] == "call_user_func" || $arr['function'] == "call_user_func_array" || (@($arr['class']) == "xajaxFunctionPlugin" && $arr['function'] == "processRequest" )) {
//                                            continue; // Ya no es necesario un mayor nivel de profundidad ya que es una peticion por xajax y no arrojara mas informacion
                                            $arr['args'] = ""; // Ahora se limpian los argumentos de los metodos que no arrojan informacion interesante para debug pero generar fallo de memoria
					}
					if( @$arr['class'] == "DebugBack" ) {
                                            continue; // Ya no es necesario un mayor nivel de profundidad ya que estamos en la clase de depuracion
					}
	//				$args = var_export($arr['args'], true); // Var export falla en referencias recursivas ciclicas.
					ob_start();
                                            print_r($arr['args']);
					$args = ob_get_clean();
					// $args = str_replace("\n", " ", $args);
					$args = preg_replace("/\s+/", " ", $args);
					$resp .= @("[pid(".getmypid().") $t] $prefix  *[$index]* ".$arr['file']."[".$arr['line']."] ".@($arr['class'])."->".$arr['function']."(".($args).")\n");
					$prefix .= "--";
				}
				
				// Si ademas hay informacion de error la anexamos ya que podria ser util
				if(!is_null($e = error_get_last())) 
					if( in_array( $e['type'], array(E_ERROR, E_USER_ERROR, E_WARNING, E_USER_WARNING) ) )
						$resp .= "[pid(".getmypid().") $t]  error_get_last  >> ".self::getErrorName ($e['type']).": {$e['file']}[{$e['line']}]: {$e['message']}\n";

			}
			
			$resp .= "[pid(".getmypid().") mem(".DebugBack::get_mem_usage_report().") $t ".", HWUSER:".(isset($_SESSION['ses_usr_cod'])?$_SESSION['ses_usr_cod']:"UNKNOW")."]   ++ $msg\n";
			
		}  catch (Exception $e)
		{
			error_log($e->getMessage());
		}
                //Se cambia el valor de la constante de conexión del String resultante
                $resp = str_replace(NOMBRE_PASSWORD, "*********", $resp);
		return $resp;
    }
	
	/**
	 * Este es el metodo principal para realizar depuracion inline
	 * @param String $errMsg Mensaje de error personalizado
	 * @param String $handleType log|email|return|echo
	 * @param boolean $withTrace
	 * @return type
	 */
	public static function debugError( $errMsg, $handleType = 'log', $withTrace = true, $debugLevel = 0 )
	{
//		if( !self::$enable && (defined("AMBIENTE") && AMBIENTE != "PRODUCCION") )
//			return;
		
		switch ($handleType) {
			case "log":
				self::dMsg($errMsg, $debugLevel, $withTrace);
				break;

			case "email":
				$cadena = self::buildErrorString("<strong style='color:red;'>$errMsg</strong>", $debugLevel, $withTrace);
                $mail = new PlantillaMail();
                // ($From, $para, $asunto, $contenido="", $adjunto="", $reply="", $tabla_bit='', $llave_tabla='', $reserva="", $cc="", $bcc="") {
                if(!$mail->enviarMail(_CORREO_DEBUG_ERRORS
                    , _CORREO_DEBUG_ERRORS
                    , date("Y-m-d H:i:s").' - Informe de error'
                    , "<pre>$cadena</pre>"))
				{
					error_log("Error enviando el correo electronico con el reporte de errores");
					self::dMsg($errMsg, $debugLevel, $withTrace);
                    return false;
                }else
                {
                    return true;
                }
				break;

			case "return":
				if( $withTrace )
					return self::buildErrorString($errMsg, $debugLevel, $withTrace);
				else
					return $errMsg;
				break;

			case "echo":
				if( $withTrace )
					echo self::buildErrorString($errMsg, $debugLevel, $withTrace);
				else
					echo $errMsg;
				break;

			default:
				error_log("Unknow error type");
				break;
		}
	}
	
    
    public static function handler_error( $errno , $errstr , $errfile = null, $errline = null, $errcontext = null )
    {
        switch ($errno) {
            case E_USER_ERROR:
            case E_ERROR:
//            case E_USER_NOTICE:
//            case E_NOTICE:
                self::dMsg(__FUNCTION__." => ".self::getErrorName($errno).": {$errfile}[$errline]: $errstr", 2);
                break;
//            default:
//                self::dMsg("ERR_UNKNOW: [$errno] $errstr en {$errfile}[$errline]", 1);
//                break;
        }
        return false;
    }
    
    public static function handler_shutdown()
    {
        if(!is_null($e = error_get_last())) 
        {
            if( in_array( $e['type'], array(E_ERROR, E_USER_ERROR) ) )
                self::dMsg(__FUNCTION__." => ".self::getErrorName ($e['type']).": {$e['file']}[{$e['line']}]: {$e['message']}", 2);
        }
    }
    
    public static function handler_shutdown_session()
    {
        session_destroy();
        $e['type']='Destuye las sessiones';
        $e['file']='';
        self::dMsg(__FUNCTION__." => ".self::getErrorName ($e['type']).": {$e['file']}[{$e['line']}]: {$e['message']}", 2);
        
    }
    
    public static function getErrorName($type)
    {
        switch($type)
        {
            case E_ERROR: // 1 //
                return 'E_ERROR';
            case E_WARNING: // 2 //
                return 'E_WARNING';
            case E_PARSE: // 4 //
                return 'E_PARSE';
            case E_NOTICE: // 8 //
                return 'E_NOTICE';
            case E_CORE_ERROR: // 16 //
                return 'E_CORE_ERROR';
            case E_CORE_WARNING: // 32 //
                return 'E_CORE_WARNING';
            case E_CORE_ERROR: // 64 //
                return 'E_COMPILE_ERROR';
            case E_CORE_WARNING: // 128 //
                return 'E_COMPILE_WARNING';
            case E_USER_ERROR: // 256 //
                return 'E_USER_ERROR';
            case E_USER_WARNING: // 512 //
                return 'E_USER_WARNING';
            case E_USER_NOTICE: // 1024 //
                return 'E_USER_NOTICE';
            case E_STRICT: // 2048 //
                return 'E_STRICT';
            case E_RECOVERABLE_ERROR: // 4096 //
                return 'E_RECOVERABLE_ERROR';
            case E_DEPRECATED: // 8192 //
                return 'E_DEPRECATED';
            case E_USER_DEPRECATED: // 16384 //
                return 'E_USER_DEPRECATED';
        }
    }
	
	public static function get_mem_usage_report( $real = true ) {
		return "Act:{".DebugBack::memToHR(memory_get_usage($real))."},Max{".DebugBack::memToHR(memory_get_peak_usage($real))."}";
	}
	
	public static function memToHR($size)
	{
		$unit=array('b','kb','mb','gb','tb','pb');
		return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.(isset($unit[$i])?$unit[$i]:" unidades desconocidas");
	}
	
	public static function generarReporteDeMemoriaAlFinalizar() {
		$arr_debug = debug_backtrace();
		$real = true;
		$texto = DebugBack::memToHR(memory_get_peak_usage($real))."\t".$_SERVER['REQUEST_URI']."\n";
		// Existen casos en los que el config no esta cargado necesariamente y como el metodo es estatico puede que la ruta a logs no exista como RUTA_LOGS
		$f = fopen("/var/log/logAplicacion/mem.txt", "a+");
		if( $f ) {
			fwrite($f, $texto);
			fclose($f);
		}
	}

        /**
         * Funcion que permite guardar en el log de factura
         * @param type $value
         * @return type
         */
        public static function facturaLogger($value){
            if(!self::LOG_FAC){
                return;
            }
            set_include_path(get_include_path() . PATH_SEPARATOR . dirname(dirname(__FILE__))."/fun/apache-log4php-2.3.0/src/main/php");

            if (!class_exists("LoggerAutoloader")) {
                   include('Logger.php');
            }
            Logger::configure(array(
                    'rootLogger' => array(
                            'appenders' => array('default'),
                            'level' => "TRACE"
                    ),
                    'appenders' => array(
                            'default' => array(
                                    'class' => 'LoggerAppenderFile',
                                    'layout' => array(
                                            'class' => 'LoggerLayoutPattern',
                                                    'params' => array(
                                                         'conversionPattern' => "%date [%t] %p %C.%M[%L] %m%newline",
                                                     )
                                    ),
                                    'params' => array(
                                            'file' => RUTA_LOGS.'/Factura_log',
                                            'append' => true
                                    )
                            )
                    )
            ));

            $logger = Logger::getLogger('myLoggerFactura');
            $logger->info($value);
        }
	
}

// En caso de querer calcular cuanto consume en memoria cada script de php al finalizar se puede descomentar esta linea
//register_shutdown_function('DebugBack::generarReporteDeMemoriaAlFinalizar');

?>