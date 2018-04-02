<?php


class class_conex {

    const SEGUNDOS_CONSULTA_LENTA_HW = 5;
    const SEGUNDOS_CONSULTA_LENTA_REP = 15;


    private $linkConnect;
    public $errorMsg = '';
    private $recordCount = 0;
    private $iterador = 0;
    private $resLastQuery = array();
    public $EOF = false;
    public $databaseType;
    private $user;
    private $passwd;
    private $host;
    private $port; 
    private $dbname;
    private $cerrarConexion = false;
    private $logRollback = false;
    private $consultaPreparada = false;
    private $consultasPreparadas = array();
    private $connectStatus;
	
    // Los siguientes campos se agregan para evitar hacer fecth a una fila que ya fue traida de la base de datos.
    private $actualRow = null;
    private $actualRowNumber = -1;

    private $noloadbalance = false;

    function getLogRollback() {
        return $this->logRollback;
    }

    function setLogRollback($logRollback) {
        $this->logRollback = $logRollback;
    }
    
    function getCerrarConexion()
    {
        return $this->cerrarConexion;
    }

    function setCerrarConexion($cerrarConexion)
    {
        $this->cerrarConexion = $cerrarConexion;
    }
        
    public function getNoloadbalance()
    {
        return $this->noloadbalance;
    }

    public function setNoloadbalance($noloadbalance)
    {
        $this->noloadbalance = $noloadbalance;
    }

    public function setErrorMsg($errorMsg) {
        $this->errorMsg = $errorMsg;
    }

    /**
     * Devuleve el ultimo error generado por una colsulta
     * @return string
     */
    public function ErrorMsg() {
        return $this->errorMsg;
    }

    /**
     * Contructor de la clase
     * @param $user	Usuario para la conexion
     * @param $passwd	Clave de acceso para la conexio
     * @param $host	Host a donde se va a conectar
     * @param $port	Puerto clave para la conexion
     * @param $dbname	Nombre de la base de datos
     */
    public function __construct($user, $passwd, $host, $port, $dbname, $exit = true, $consultapreparada=false) {
        $this->user=$user;
        $this->passwd=$passwd; 
        $this->host=$host; 
        $this->port = $port; 
        $this->dbname=$dbname;
        $this->consultaPreparada=$consultapreparada;	
	
        $this->conectar($exit);
        
    }
	
    public function conectar( $exit = true )
    {
        $this->databaseType = 'postgres8:' . $this->dbname;
        $strCmd = 'host=' . $this->host . ' port=' . $this->port .
            ' dbname=' . $this->dbname . ' user=' . $this->user .
            ' password=' . $this->passwd;
      
        if (!$this->linkConnect = mysqli_connect($this->host, $this->user, $this->passwd, $this->dbname)) {            
            
            if ( !$exit ) {                
                $this->errorMsg = 'Error en la conexi�n';
                return false;
            }
            session_destroy();
            $this->errorMsg = 'Error en la conexi�n';
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
                echo '<script>parent.window.location = "' . PAGINA_ESTATICA_REDIRECCION_ERROR_BD . '";</script>';
                exit;
            }

            if (isset($_POST["xjxfun"])) {
                header("Content-Type:text/xml");
                $xml = '<?xml version="1.0" encoding="ISO-8859-1" ?><xjx><cmd cmd="js"><![CDATA[Sparent.window.location = "' . PAGINA_ESTATICA_REDIRECCION_ERROR_BD . '";]]></cmd></xjx>';
                echo $xml;
                exit;
            }

            if (!headers_sent()) {
                header('Location: ' . PAGINA_ESTATICA_REDIRECCION_ERROR_BD, true, 307);
                header("Connection: close");
                exit;
            }

            die($this->errorMsg);
        }
        
        if($this->consultaPreparada){
            //$this->PrepareQuery("inserttblbit", "Insert into tblbit (tipeve_cod,tbl_cod,bit_ser,bit_sen,usr_cod,bit_id) values ($1,$2,$3,$4,$5,$6)");    
            //$this->PrepareQuery("inserttblresusr", "INSERT into tblresusr ( res_cod, usr_cod ) VALUES ($1,$2)");                
            //$this->PrepareQuery("insertobs", "INSERT INTO tblobsres (res_cod,tipdet_cod_obs,obsres_obs,tipdet_cod_est,usr_cod,detres_cod) VALUES ($1,$2,$3,$4,$5,$6)");                    
        }
          
    }

    /**
	 * Para cuando se intente hacer echo a un objeto de esta clase no salga error de conversion.
	 * @return string
	 */
	public function __toString()
	{
		return "Conexion Decameron";
	}

    function __destruct() {

        /* Atributos */
        unset($this->linkConnect);
        unset($this->errorMsg);
        unset($this->recordCount);
        unset($this->iterador);
        unset($this->resLastQuery);
        unset($this->EOF);
        unset($this->databaseType);
        unset($this->actualRow);
        unset($this->actualRowNumber);
    }

    /**
     * Ejecuta una consulta sql
     * @param $sqlQuery Consulta sql
     * @param $nRows	Limite
     * @param $offSet	Comenzar desde el registro
     * @return result
     */
    public function SelectLimit($sqlQuery, $nRows = 0, $offSet = 0) {
	
        $this->actualRow = null;
        $this->actualRowNumber = -1;
        $result = false;
		
        if ( !is_string($sqlQuery) || trim($sqlQuery) == "" ) {
            $this->EOF = true;
            DebugBack::debugError("Intentado llamar a una consulta vacia o invalida \$sqlQuery:($sqlQuery).", 'log', true, 3);
            return false; // para evitar enviar consultas vacias o erroneas a la bd
        }

        if ($nRows) {
            $sqlQuery .= ' LIMIT ' . $nRows;
            if ($offSet) {
                $sqlQuery .= ' OFFSET ' . $offSet;
            }
        }
		
        /*$datosCliente = "";

        
        $datosCliente = $this->datosCliente();
        
        $sqlQuery = "{$cabecera}$sqlQuery $datosCliente"; // Va aqui si esta comendato NO LOAD
        */
		
//		if( $this->enModificacion ) {
//			// todas las consultas de ahi en adelante deben enviarse con NO LOAD BALANCE
//			if(defined("AMBIENTE") && AMBIENTE!="PRODUCCION") {
//				$sqlQuery = "/*NO LOAD BALANCE*/ $datosCliente $sqlQuery";
//			}else {
//				$sqlQuery = "/*NO LOAD BALANCE*/ $sqlQuery";
//			}
//		}else {
//
//			// Veriricar si la consulta que se esta enviando es de UPDATE/DELETE/INSERT, marcar la clase de conexion como en MODIFICACION
//			if( preg_match( "/\s*(INSERT|UPDATE|DELETE)\s/i", $sqlQuery, $matches ) === false ) {
//				DebugBack::debugError("Error en la expresion regular al buscar MOD a la base de datos");
//			}else {
//				if( count($matches) > 1 ) {
//					$this->enModificacion = true;
//				}
//			}
//		}
		
//		DebugBack::debugError("Iniciando consulta: ".$sqlQuery."\n", 'log', false, 3);
		
        $tInicio = time();
        echo $sqlQuery;
        $this->resLastQuery = mysqli_query($this->linkConnect, $sqlQuery);
        var_export($this->resLastQuery);
        $php_error = error_get_last();
        if( !is_resource($this->linkConnect) && !is_null($php_error) ) {
            $php_error = implode(",", $php_error)."\n";
            DebugBack::debugError("Se encontro un problema de recurso de base de datos (".  var_export($this->linkConnect, true).") con {$php_error} al ejecutar {$sqlQuery}", 'log', true, 3);
        }else {
            $php_error = "";
        }
        $tFin = time();
        $segundosDuracion = $tFin - $tInicio;
        if ($this->resLastQuery===false) {
            $this->errorMsg = mysqli_error($this->linkConnect);
            $this->connectStatus = mysqli_ping($this->linkConnect);            
            if($this->connectStatus !== PGSQL_CONNECTION_OK){
                $flagRva = (isset($GLOBALS['idPadre']) && $GLOBALS['idPadre'] != '') ? true : false;
                $this->errorMsg .= $this->makeConnectionError($flagRva);
                DebugBack::debugError("ATENCION!:\nSe cerro la conexion a la base de datos.\nFecha:".date('Y-m-d H:i:s')."\nError:".$this->errorMsg."\nConsulta:$sqlQuery\n", 'log', false);
            }
            $this->EOF = true;
            if( trim($sqlQuery) != "" ) DebugBack::debugError("Consulta con error: ".$sqlQuery."\nError: {$this->errorMsg}\n{$php_error}", 'log', true, 3);
            return false;
        } else {
            if ( ($this->host===constant("NOMBRE_HOST") && $segundosDuracion > self::SEGUNDOS_CONSULTA_LENTA_HW) || ($this->host===constant("HOST_REPORTES") && $segundosDuracion > self::SEGUNDOS_CONSULTA_LENTA_REP) ) {
                DebugBack::debugError("CONSULTA LENTA, ".$sqlQuery."\ntiempo de ejecucion [{$segundosDuracion} sgs]: F[".date("i:s",$tFin)."] - I[".date("i:s",$tInicio)."] = ".date("i:s",$segundosDuracion), 'log', true, 3);
            }
//            $_x = preg_match( "/\s*(INSERT|UPDATE|DELETE)\s/i", $sqlQuery, $matches );
//            if( $_x !== false && count($matches)>1 )
//            {
//                DebugBack::debugError("CONSULTA MOD: $sqlQuery", 'log', true, 3);
//            }
            $this->recordCount = mysqli_num_rows($this->resLastQuery);
            $this->EOF = ($this->recordCount <= 0);
        }

        $result = $this->Clonar($result);

        return $result;
    }
    
    
    
    public function datosCliente () {
        
        $stack = ""; 
        $arr_debug = debug_backtrace();
        if( is_array($arr_debug) && count($arr_debug)>=2 )
        {
            $arr = $arr_debug[1]; // 0 seria esta misma funcion
            $stack = ", PATH: "
                    .(isset($arr['file'])?$arr['file']:"")
                    ."[".(isset($arr['line'])?$arr['line']:"")."] "
                    .(isset($arr['class'])?$arr['class']:"")."->"
                    .(isset($arr['function'])?$arr['function']:"");
        }elseif( is_array($arr_debug) && count($arr_debug)==1 )
        {
            $arr = $arr_debug[0]; // 0 seria esta misma funcion
            $stack = ", PATH: "
                    .(isset($arr['file'])?$arr['file']:"")
                    ."[".(isset($arr['line'])?$arr['line']:"")."] "
                    .(isset($arr['class'])?$arr['class']:"")."->"
                    .(isset($arr['function'])?$arr['function']:"");
        }else {
            $stack = ", PATH:".__FILE__."[desconocida]";
        }
        
        $datosCliente = "/* SHOST:".(isset($_SERVER['SERVER_ADDR'])?$_SERVER['SERVER_ADDR']:"UNKNOW")
            .", RHOST:".(isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:"UNKNOW")
            .", HWUSER:".(isset($_SESSION['ses_usr_cod'])?$_SESSION['ses_usr_cod']:"UNKNOW")
            ."$stack"
            .", AMBIENTE:".AMBIENTE
            ." */";
        
        return $datosCliente;
        
    }
    
    
    /**
     * Ejecutar una consulta sql
     * @param $sqlQuery	Consulta sql
     * @return result
     */
    public function Execute($sqlQuery) {
		if( !isset($sqlQuery) ) {
			DebugBack::debugError("Tratando de ejecutar Execute de la clase de conexion sin ninguna consulta", 'log', true, 10);
			return false;
		}
        return $this->SelectLimit($sqlQuery);
    }
	
    public function hayTransaccion() {
        $stat = pg_transaction_status($this->linkConnect);
//        DebugBack::debugError("Tratando de detectar estado de la transaccion: $stat, PGSQL_TRANSACTION_INTRANS: ".PGSQL_TRANSACTION_INTRANS." PGSQL_TRANSACTION_INERROR: ".PGSQL_TRANSACTION_INERROR);
        if( $stat === PGSQL_TRANSACTION_INTRANS		// idle, in a valid transaction block
                || $stat === PGSQL_TRANSACTION_INERROR	// idle, in a failed transaction block
//                || $stat === PGSQL_TRANSACTION_ACTIVE	// is reported only when a query has been sent to the server and not yet completed, no deberia pasar en HW por ser sincrono
        ) {
                return true;
        }

        return false;
    }

    /**
     * Mueve el apuntador del resultado de una consulta al siguiente registro
     */
    public function MoveNext() {
        $this->actualRow = null;
        $this->actualRowNumber = -1;
        if ($this->iterador < ($this->recordCount - 1))
            $this->iterador++;
        else
            $this->EOF = true;
    }

    /**
     * Mueve el apuntador del resultado de una consulta al siguiente registro
     */
    public function MovePrev() {
            $this->actualRow = null;
            $this->actualRowNumber = -1;
        if ($this->iterador > 0)
            $this->iterador--;
    }

    /**
     * Mueve el apuntador de un resultado al primer registro
     * @return unknown_type
     */
    public function MoveFirst() {
        $this->actualRow = null;
        $this->actualRowNumber = -1;
        $this->iterador = 0;
        $this->EOF = false;
    }

    /**
     * Mueve el apuntador de un resultado al ultimo registro de una consulta
     */
    public function MoveLast() {
        $this->actualRow = null;
        $this->actualRowNumber = -1;
        $this->iterador = $this->RecordCount() - 1;
    }

    /**
     * Mueve el apuntador de una consulta al registro que uno quiera
     * @param $to Numero del registro al cual se quiere mover
     */
    public function Move($to) {
        $this->actualRow = null;
        $this->actualRowNumber = -1;
        $this->iterador = $to - 1;
    }

    /**
     * Obtiene el valor de una columna en un registro
     * @param $nameRow
     * @return string
     */
    public function Fields($nameRow) {
        if ($this->iterador < $this->RecordCount()) {
            if( $this->actualRowNumber != $this->iterador )
            {
                // Evitamos un nuevo fetch cuando ya se ha realizado alguna vez para esta consulta para este iterador
                $this->actualRow = mysqli_fetch_array($this->resLastQuery, $this->iterador);
                $this->actualRowNumber = $this->iterador;
            }else
            {
                // Si es la misma no hacemos nada
            }
            if (!isset($this->actualRow[$nameRow])) {
                $this->actualRow[$nameRow] = null;
            }
            return $this->actualRow[$nameRow];
        }
    }

	/**
	 * Se mantiene por historico durante un par de revisiones en caso de que el cambio muestre problemas
	 * @deprecated
	 * @param String $nameRow
	 * @return null
	 */
    public function Fields_old($nameRow) {
        if ($this->iterador < $this->RecordCount()) {
            $row = mysqli_fetch_array($this->resLastQuery, $this->iterador);
            
            if (!isset($row[$nameRow])) {
                $row[$nameRow] = null;
            }
            return $row[$nameRow];
        }
    }

    /**
     * Devuelve el numero de registros afectados por la ultima consulta
     * @return integer
     */
    public function RecordCount() {
        return $this->recordCount;
    }

    /**
     * Inicia una transaccion
     */
    public function StartTrans() {
        if( $this->hayTransaccion() ) {
            DebugBack::debugError("Begin de transaccion anidada !!!!! REVISAR - ".AMBIENTE." desde ".$_SERVER['HTTP_HOST'], 'email', true, 10);
        }
        $this->Execute('BEGIN TRANSACTION;');
        $this->Execute('/*NO LOAD BALANCE*/ SELECT now();');
    }

    /**
     * Completa una transaccion
     */
    public function CompleteTrans( $nada = true, $esperarReplicacion = true ) {
        $this->Execute('COMMIT;');
        if( $esperarReplicacion )
            $this->esperaReplicacion();
    }
	
    /**
     * Destruye una transaccion
     */
    public function RollbackTrans() {
        $this->Execute('ROLLBACK;');
        if ( $this->logRollback ) {
            $stack = "";
            $arr_debug = debug_backtrace();
            if( is_array($arr_debug) && count($arr_debug)>=2 )
            {
                $arr = $arr_debug[1]; // 0 seria esta misma funcion
                $stack = ", PATH: "
                        .(isset($arr['file'])?$arr['file']:"")
                        ."[".(isset($arr['line'])?$arr['line']:"")."] "
                        .(isset($arr['class'])?$arr['class']:"")."->"
                        .(isset($arr['function'])?$arr['function']:"");
            }elseif( is_array($arr_debug) && count($arr_debug)==1 )
            {
                $arr = $arr_debug[0]; // 0 seria esta misma funcion
                $stack = ", PATH: "
                        .(isset($arr['file'])?$arr['file']:"")
                        ."[".(isset($arr['line'])?$arr['line']:"")."] "
                        .(isset($arr['class'])?$arr['class']:"")."->"
                        .(isset($arr['function'])?$arr['function']:"");
            }else {
                $stack = ", PATH:".__FILE__."[desconocida]";
            }
            error_log("Se detecto un rollback durante un proceso monitoreado: $stack");
        }
    }

    /**
     * Cierra una conexion a la base de datos
     */
    public function Close() {
        mysq_close($this->linkConnect);
    }

    /**
     * Clona un objeto para crear hilos
     * @param $result
     * @return object
     */
    private function Clonar($result) {
        $result = clone $this;
        return $result;
    }

    public function getLinkConnect() {
        return $this->linkConnect;
    }

    public function FetchAssoc() {
        return mysqli_fetch_assoc($this->resLastQuery);
    }

    public function AffectedRows() {
        return mysqli_affected_rows($this->resLastQuery);
    }

    public function PrepareQuery($nombreQuery, $sqlQuery) {
        if( !array_key_exists ($nombreQuery, $this->consultasPreparadas) ){
            $datosCliente = $this->datosCliente();
            $_x = mysqli_prepare($this->linkConnect, $nombreQuery, $sqlQuery. " " .$datosCliente);
            if($_x === false) {
                $this->errorMsg = mysqli_error($this->linkConnect);
                DebugBack::debugError("Consulta preparada con error: ".$nombreQuery."\nError: {$this->errorMsg}\n", 'log', true, 3);
            }
            $this->consultasPreparadas[$nombreQuery] = $_x;
            return $_x;
        }
        else{
            return $this->consultasPreparadas[$nombreQuery];
        }
        
    }

    public function PrepareExecute($nombreQuery, $arrayQuery) {
        $result = clone $this;
        $result->actualRow = null;
        $result->actualRowNumber = -1;

        $tInicio = time();
        $result->resLastQuery = mysqli_execute($this->linkConnect, $nombreQuery, $arrayQuery);
        
        $tFin = time();
        $segundosDuracion = $tFin - $tInicio;
        
        if ($result->resLastQuery===false) {
            $this->errorMsg = mysqli_error($this->linkConnect);
            $this->EOF = true;
            DebugBack::debugError("Argumentos de consulta preparada con error: ".$nombreQuery."\nError: {$this->errorMsg}\n", 'log', true, 3);
            return false;
        } else {
            if ( ($this->host===constant("NOMBRE_HOST") && $segundosDuracion > self::SEGUNDOS_CONSULTA_LENTA_HW) || ($this->host===constant("HOST_REPORTES") && $segundosDuracion > self::SEGUNDOS_CONSULTA_LENTA_REP) ) {
                $datosCliente = $this->datosCliente();
                DebugBack::debugError("CONSULTA LENTA, CONSULTA PREPARADA $nombreQuery - $datosCliente\ntiempo de ejecucion [{$segundosDuracion} sgs]: F[".date("i:s",$tFin)."] - I[".date("i:s",$tInicio)."] = ".date("i:s",$segundosDuracion), 'log', true, 3);
            }
        }
        
        $result->recordCount = mysqli_num_rows($result->resLastQuery);
        $result->EOF = ($result->recordCount <= 0);
        
        return $result;
    }

    public function PrepareParams($sqlQuery, $arrayQuery) {
        return mysqli_prepare($this->linkConnect, $sqlQuery, $arrayQuery);
    }

    public function NumRows() {
        return mysqli_num_rowsm_rows($this->resLastQuery);
    }

    public function FetchRow() {
        return mysqli_fetch_row($this->resLastQuery);
    }

    /**
     * Insercion a tabla de la base de Datos por medio de un arreglo
     * indicar en cada indice del arreglo el nombre del campo a insertar
     */
    public function arrayToPostgress($array, $table, $magicQuotes=0, $key="") {

        if (!is_array($array)) {
            echo "No es un arreglo para insertar en la tabla";
            return false;
        }
        $sql = "SELECT attname FROM pg_attribute WHERE attrelid = ('$table'::regclass) and attnum > 0";
        if (!$res = $this->Execute($sql))
            exit("Error en la sentencia");

        while (!$res->EOF) {
            $tableRow[] = $res->Fields('attname');
            $res->MoveNext();
        }


        $fields = "";
        $values = "";
        foreach ($array as $key => $value) {
            if ((in_array($key, $tableRow))) {
                $fields.= ( $fields != "" ? $key . "," : "(" . $key . ",");
                $values.= ( $values != "" ? ",'$value'" : "'$value'");
            } else {
                echo "No se encontro el campo $key en la tabla $table";
                return false;
            }
        }
        $fields = substr($fields, 0, -1) . ")";
        $sql = "INSERT INTO $table $fields VALUES ($values)";
        $this->Execute($sql);
    }
	
	/**
	 * Retorna el numero de columnas en la ultima consulta realizada
	 * @author Alan Acosta <alan.acosta@decameron.com>
	 * @return Integer
	 */
	public function NumFields() {
            return mysqli_num_fields($this->resLastQuery);
	}

    /**
     * Convierte el resultado de una consulta en una matriz asociativa
     * @return array
     */
    public function toArray() {
        $arreglo = array();
        $camposName = array();

        //Verificamos los campos que saco la consulta
        $campos = mysqli_num_fields($this->resLastQuery);
        for ($i = 0; $i < $campos; $i++) {
            $camposName[$i] = pg_field_name($this->resLastQuery, $i);
        }

        //Armamos el array
        for ($i = 0; $i < $this->recordCount; $i++) {
            $row = mysqli_fetch_array($this->resLastQuery, $i);
            foreach ($camposName AS $key => $valor) {
                $arreglo[$i][$valor] = $row[$valor];
            }
        }

        unset($camposName);
        unset($campos);
        unset($i);
        unset($row);
        unset($key);
        unset($valor);
        return $arreglo;
    }
    
    /**
     * Verifica que los servidores esclavos de bd se encuentren actualizados, de lo contrario espera a que lo est�n.
     */
    public function esperaReplicacion()
    {
        $timeIni = microtime(true);
        $master_xlocation='';
        $processId = obtenerProcesoId();
        $sql='select pg_current_xlog_location();';
        $rds_objetos =  $this->SelectLimit($sql);
        usleep ( 200 );//Todas la transacciones esperan antes de validar posici�n de esclavos
	   
        if ($rds_objetos!==false && !$rds_objetos->EOF) {
            $master_xlocation= $rds_objetos->Fields("pg_current_xlog_location");         
            $lisParametros = array();
            $sql="show pool_nodes;";
            $rds_objetos =  $this->SelectLimit($sql);
            while ($rds_objetos!==false && !$rds_objetos->EOF) {                 
                if($rds_objetos->Fields("role") === 'standby' && $rds_objetos->Fields("status")==='2' ){
                    $lisParametros[]=$rds_objetos->Fields("hostname");
                }
                $rds_objetos->MoveNext();
            }
            $contador =0;
            do{
                $contador++;
                $sql="SELECT *,  pg_xlog_location_diff('".$master_xlocation."',replay_location) as diff FROM  function_posicion_esclavos();";
                $rds_objetos =  $this->SelectLimit($sql);
	            $esperar=false;
                while (!$esperar && $rds_objetos!==false && !$rds_objetos->EOF)
                {
                    $ip=$rds_objetos->Fields("client_addr");
                    if ( in_array( $ip,$lisParametros)  ){
                        if ($rds_objetos->Fields("diff")>0){
                            $esperar = true;
                            if( $this->cerrarConexion ) {                                  
                                $this->Close();
                            }
                            usleep ( 200+(50*$contador) );                                
                            if( $this->cerrarConexion ) {
                                $this->conectar( );
                            }
                        }
                    }
                    $rds_objetos->MoveNext();
                }
                if (!$esperar) {
                    logScripts($processId, __CLASS__."::".__METHOD__ ." | ".$contador, $timeIni, microtime(true),"FIN", '', '1',array('obliga'=>true) );
                    return true;
                }
            }while( $contador <= 1000 ); 
        }
        logScripts($processId, __CLASS__."::".__METHOD__ ." | ".$contador, $timeIni, microtime(true),"FIN", '', '1',array('obliga'=>true) );
    }
    
    /**
     * Funci�n que construye un mensaje cuando la conexi�n a base de datos no
     * se encuentra y por ende no puede buscar un objeto de tipo 'mensaje' para ser
     * retornado en el sistema.
     * @return string $mensaje Una cadena indicando que hubo un error en la conexi�n
     */
    private function makeConnectionError($flagRva){
        $idioma = $_SESSION['ses_idi_cod'];
        $mensaje = '';
        switch ((int)$idioma) {
            case 1://ES
                $mensaje = " Ha ocurrido un error general del sistema, por favor contactarse con el departamento de Tecnolog�a";
                if ($flagRva) {
                     $mensaje .= " y es necesario que se verifique el estado de la reserva en la central";
                }
            break;
        
            case 2://EN
                $mensaje = " A general system error has ocurred, please contact with the Technology department";
                if ($flagRva) {
                     $mensaje .= " and it requires that the reserve status is verified in the reservation central";
                }
            break;
            
            case 4://FR
                $mensaje = " Une erreur de syst�me g�n�ral a eu lieu, s'il vous pla�t contacter le D�partement de la technologie";
                if ($flagRva) {
                     $mensaje .= " et est n�cessaire pour le statut de r�serve est v�rifi�e dans la centrale";
                }
            break;
        
            case 5://PT
                $mensaje = " Um erro geral de sistema tenha ocorrido, entre em contato com o departamento de Tecnologia";
                if ($flagRva) {
                     $mensaje .= " e � necess�rio para o status de reserva � verificado na central";
                }
            break;
        }
        return $mensaje;
    }
    
    public function getRecordCount() {
        return $this->recordCount;
    }
}
