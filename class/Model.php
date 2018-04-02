<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author gabriel.martinez
 * Modifica: Mauricio Garcia
 */

abstract class Model implements ModelProperties {

	private $action;
	private $registerBit = false;
	private $lastDbErrorMsg = "";

	public function __construct() {
		$this->registerBit = false;
	}

	public static function getClassName() {
		return get_called_class();
	}

	public function getLastDbErrorMsg() {
		return $this->lastDbErrorMsg;
	}

	public function registerBitacora($value = "") {
		if ($value != "") {
			$this->registerBit = false;
		} else {
			$this->registerBit = true;
		}
	}

	public function buscarCoincidencias($where = array(), $notin = "") {
		$sql = "SELECT COUNT(" . static::getPrimaryKey() . ") AS conteo FROM " .
						static::getTableName() . " WHERE TRUE ";
		if (count($where) > 0) {
			foreach ($where as $key => $value) {
				$sql.= " AND " . $key . " = '" . pg_escape_string($value) . "'";
			}
		}
		if ($notin != "") {
			$sql.= " AND " . static::getPrimaryKey() . " NOT IN ('" . $notin . "')";
		}
		//echo $sql."<br>";
		$rs = static::getConnection()->Execute($sql);
		return $rs->Fields("conteo");
	}
        
        // Para parametros de busqueda solamente enteros
        public function buscarCoincidenciasInteger($where = array(), $notin = "") {
		$sql = "SELECT COUNT(" . static::getPrimaryKey() . ") AS conteo FROM " .
						static::getTableName() . " WHERE TRUE ";
		if (count($where) > 0) {
			foreach ($where as $key => $value) {
                            if( $value === "" ) {
                                $sql.= " AND " . $key . " IS NULL ";
                            } else {
				$sql.= " AND " . $key . " = " . pg_escape_string($value) . "";
                            }
			}
		}
		if ($notin != "") {
			$sql.= " AND " . static::getPrimaryKey() . " NOT IN ('" . $notin . "')";
		}
		//echo $sql."<br>";
		$rs = static::getConnection()->Execute($sql);
		return $rs->Fields("conteo");
	}

	public static function buscar($cod) {
		$sql = "SELECT * FROM " . static::getTableName() . " " .
						"WHERE " . static::getPrimaryKey() . " = '" .
						pg_escape_string($cod) . "'";
		$rs = static::getConnection()->Execute($sql);

		if ($rs) {
			$class = static::getClassName();
			$model = new $class();
			foreach (static::getFields() as $campo) {
				$fn = "set" . ucfirst($campo);
				$model->$fn($rs->Fields($campo));
			}
			return $model;
		} else {
			return null;
		}
	}

	public static function grupoBuscar($condition, $orderBy = "") {
		$sql = "SELECT * FROM " . static::getTableName() . " " .
						"WHERE " . $condition . " " . $orderBy;

		$rs = static::getConnection()->Execute($sql);
		$result = array();
		while (!$rs->EOF) {
			$class = static::getClassName();
			$model = new $class();
			foreach (static::getFields() as $campo) {
				$fn = "set" . ucfirst($campo);
				$model->$fn($rs->Fields($campo));
			}
			array_push($result, $model);
			$rs->MoveNext();
		}
		return $result;
	}

	public static function getValue($function, $field, $where = array()) {
		switch ($function) {
			case 'MIN':
				$fn = "MIN";
				break;
			case 'MAX':
				$fn = 'MAX';
				break;
			default :
				$fn = 'COUNT';
				break;
		}
		$sql = "SELECT " . $fn . "(" . $field . ") AS retorno FROM " . 
						static::getTableName() . " WHERE TRUE ";
		if (count($where) > 0) {
			foreach ($where as $key => $value) {
				$sql.= " AND " . $key . " " . pg_escape_string($value);
			}
		}
		$rs = static::getConnection()->Execute($sql);
		return $rs->Fields("retorno");
	}

	public static function where($condition) {
		$sql = "SELECT * FROM " . static::getTableName();

		if ($condition != null && $condition != "") {
			$sql .= " WHERE " . $condition;
		}
		$result = array();
                
                $rs = static::getConnection()->Execute($sql);

		while (!$rs->EOF) {
			$class = static::getClassName();
			$model = new $class();
			foreach (static::getFields() as $campo) {
				$fn = "set" . ucfirst($campo);
				$model->$fn($rs->Fields($campo));
			}
			array_push($result, $model);
			$rs->MoveNext();
		}

		return $result;
	}

	public function insertar() {
		$this->action = "Insertar";
		$fieldsToRemove = static::getFieldsToRemove();
                array_push($fieldsToRemove, static::getPrimaryKey());

		$listaCampos = array_diff(static::getFields(), $fieldsToRemove);
		$sql = "INSERT INTO " . static::getTableName() . " ( " . implode(",", $listaCampos) . ") ";

		$values = array();
		foreach ($listaCampos as $campo) {
			$fn = "get" . ucfirst($campo);
			$val = $this->$fn();
			array_push($values, ($val == null || $val == '-1') ? 'null' : "'" . pg_escape_string($val) . "'");
		}

		$sql .= " VALUES (" . implode(",", $values) . ") RETURNING " . static::getPrimaryKey();
		$response = $this->audit($sql);
		$fnpk = "set" . ucfirst(static::getPrimaryKey());
		$this->$fnpk($response["priKey"]);
		return $response;
	}

	public function actualizar() {
		$this->action = "Modificar";

		$fieldsToRemove = static::getFieldsToRemove();
		array_push($fieldsToRemove, static::getPrimaryKey());

		$listaCampos = array_diff(static::getFields(), $fieldsToRemove);

		$sql = "UPDATE " . static::getTableName() . " SET ";

		$values = array();
		foreach ($listaCampos as $campo) {
			$fn = "get" . ucfirst($campo);
			$val = $this->$fn();
			$data = $campo . "=" . (($val == null || $val == '-1') ? 'null' : "'" . pg_escape_string($val) . "'");
			array_push($values, $data);
		}

		$fnpk = "get" . ucfirst(static::getPrimaryKey());
		$pk = $this->$fnpk();

		$sql .= " " . implode(",", $values) . " WHERE " . static::getPrimaryKey() . "='" .
						$pk . "'";
		return $this->audit($sql, $pk);
	}

	public function eliminar() {
		$this->action = "Eliminar";

		$fnpk = "get" . ucfirst(static::getPrimaryKey());
		$pk = $this->$fnpk();

		$sql = "DELETE FROM " . static::getTableName() . " WHERE " .
						static::getPrimaryKey() . "= '" . pg_escape_string($pk) . "'";

		return $this->audit($sql, $pk);
	}

	private function audit($qrySQL, $priKey = 0) {
		$msj = "";
		$timeIni = microtime(true);
		$processId = obtenerProcesoId();
		logScripts($processId, __CLASS__ . "::" . __METHOD__, 0, 0, "INICIO", '', '1');
		try {
                      //  static::getConnection()->StartTrans();
                if ($this->action !== "Eliminar") {
                    $obj = static::getConnection()->Execute($qrySQL);
                } else {
                    $obj = true;
                }

			if (!$obj) {
				$this->lastDbErrorMsg = static::getConnection()->ErrorMsg();
				
				switch ($this->action) {
					case "Eliminar": $msj = "err_eliminarElemento";
						break;
					case "Insertar": $msj = "err_insertarElemento";
						break;
					case "Modificar": $msj = "err_modificarElemento";
						break;
					default: $msj = "err_noEspecificado";
						break;
				}
                               // static::getConnection()->RollbackTrans();
			} else {
				if ($priKey == 0) { // insercion
					if (!$obj->EOF) {
						$priKey = $obj->Fields(static::getPrimaryKey());
					}
				}
				if ($this->registerBit == true) {
					$this->exito = ingresarBitacora(
									static::getConnection(), static::getTableName(), static::getPrimaryKey(), $this->action, $priKey);
                                        if ($this->action === "Eliminar") {
                                            $obj = static::getConnection()->Execute($qrySQL);
                                            if (!$obj) {
                                                $msj = "err_eliminarElemento";
                                            }
                                        }
				} else {
					$this->exito = true;
				}

				if (!$this->exito) {
					$msj = "err_guardarBitacora";
                                     //   static::getConnection()->RollbackTrans();                                        
				}
			}
			return array("priKey" => $priKey, "msj" => $msj);
		} catch (Exception $e) {
			//echo 'Excepci�n capturada: ',  $e->getMessage();
			return;
		}
		logScripts($processId, __CLASS__ . "::" . __METHOD__, $timeIni, microtime(true), "FIN", '', '1');
	}

	/**
	 * filtrarResultados
	 * 
	 * Permite realizar la paginacion de elementos de una consulta.
	 * 
	 * @param string $funcionXAJAX Nombre de la Funcion dinamica de paginacion
	 * @param array $header Columnas a ser consultadas en el Filtro
	 * @param string $qryTbl Sentencia SQL de Filtrado
	 * @param integer $offset Limit de la Consulta
	 * @param string $orden Campo de Ordenamiento
	 * @param string $dir Orden Ascendente / Descendente
	 * @return \paginacion
	 */
	public function filtrarResultados($funcionXAJAX, $header, $qryTbl, $offset="", 
					$orden="", $dir="",$limit=false) {
		$timeIni = microtime(true);
		$processId = obtenerProcesoId();
		logScripts($processId, __CLASS__ . "::" . __METHOD__ . " FXAJAX::" .
						$funcionXAJAX, 0, 0, "INICIO", '', '1');
		$offset = ($offset != '') ? $offset : 0;
                $orden = ($orden != '') ? $orden : "codigo";
                if(!is_null($dir)) {
                    $dir = ($dir) ? $dir : "a";
                }else {
                    $dir = null;
                }
		$cabecera = array();
		foreach ($header as $key => $value) {
			$cabecera[$key] = array('cabecera' => $value);
		}
                $cabecera[$orden]['orden'] = $dir;
		$page = new paginacion(static::getConnection());
                //echo $limit.'limit';

                if ($limit==false) $page->setLimit('10');
                if ($limit==true) $page->setLimit('0');
                                        
		$page->setSql($qryTbl);
		$page->setOffset($offset);
		$page->setFuncionAjax($funcionXAJAX);
		$page->setCabecera($cabecera);
		$page->getDatos();
           
		logScripts($processId, __CLASS__ . "::" . __METHOD__, $timeIni, microtime(true), "FIN", '', '1');
		return $page;
	}
        
        /**
	 * filtrarResultadosConsultaPreparada
	 * 
	 * Permite realizar la paginacion de elementos de una consulta.
	 * 
	 * @param string $funcionXAJAX Nombre de la Funcion dinamica de paginacion
	 * @param array $header Columnas a ser consultadas en el Filtro
	 * @param string $qryTbl Sentencia SQL de Filtrado
	 * @param array $bindArray Arreglo con los datos para la consulta preparada
	 * @param integer $offset Limit de la Consulta
	 * @param string $orden Campo de Ordenamiento
	 * @param string $dir Orden Ascendente / Descendente
	 * @return \paginacion
	 */
	public function filtrarResultadosConsultaPreparada($funcionXAJAX, $header, $qryTbl, $bindArray = array(), $offset="", 
					$orden="", $dir="",$limit=false,$fetch=true) {
		$timeIni = microtime(true);
		$processId = obtenerProcesoId();
		logScripts($processId, __CLASS__ . "::" . __METHOD__ . " FXAJAX::" .
						$funcionXAJAX, 0, 0, "INICIO", '', '1');
		$offset = ($offset != '') ? $offset : 0;
                $orden = ($orden != '') ? $orden : "codigo";
                if(!is_null($dir)) {
                    $dir = ($dir) ? $dir : "a";
                }else {
                    $dir = null;
                }
		$cabecera = array();
		foreach ($header as $key => $value) {
			$cabecera[$key] = array('cabecera' => $value);
		}
                $cabecera[$orden]['orden'] = $dir;
		$page = new paginacion(static::getConnection());
                //echo $limit.'limit';

                if ($limit==false) $page->setLimit('10');
                if ($limit==true) $page->setLimit('0');
                                        
		$page->setSql($qryTbl);
		$page->setOffset($offset);
		$page->setFuncionAjax($funcionXAJAX);
		$page->setCabecera($cabecera);
		$page->setBindArray($bindArray);
                $page->getDatosConsultaPreparada(array(), $fetch);
                
		logScripts($processId, __CLASS__ . "::" . __METHOD__, $timeIni, microtime(true), "FIN", '', '1');
		return $page;
	}
        
        
    /**
     * Carga un arreglo en los campos del Modelo. Por defecto para el caso de los strings
     * se cargan en mayuscula. Para cargarlos como vienen de la base de datos y guardarlos tal
     * y como lo ingresa el usuario, agregue el campo en la funcion camposMayusMinus del modelo
     * 
     * protected function camposMayusMinus() {
     *  return array(<CAMPOS QUE PERMITEN MAYUSCULAS/MINUSCULAS>);
     * }
     * 
     * Nota: Si los datos que se desean cargar en el modelo son resultado de una consulta a la
     * base de datos, setear codifica en false para no danar los acentos
     * 
     * @param array $params
     * @return boolean
     */
    public function loadParams($params, $codifica = true)
    {
        if (!is_array($params)) {
            return false;
        }
        
        $camposMayusMinus = method_exists($this, 'camposMayusMinus') ? $this->camposMayusMinus() : array();
        $fields = static::getFields();
        
        foreach ($fields as $field) {
            if (!key_exists($field, $params)) {
                continue;
            }
                
            $fn = "set" . ucfirst($field);
            
            if (is_string($params[$field]) && array_search($field, $camposMayusMinus) === false) {
                if ($codifica) {
                    $valor = trim(mb_strtoupper(utf8_decode($params[$field]), 'ISO-8859-1'));
                } else {
                    $valor = trim(mb_strtoupper($params[$field], 'ISO-8859-1'));
                }
            } else {
                $valor = $params[$field];
            }
            
            $this->$fn($valor);
        }
        return true;
    }
    
    /**
     * Setea los campos en Null
     */
    public function limpiarDTO()
    {
        $fields = static::getFields();
        
        foreach ($fields as $field) {
            $fn = "set" . ucfirst($field);
            $this->$fn(null);
        }
    }
    
    /**
     * Si el campo indicado en el array es null, se setea con el valor por defecto
     * @param array $params Arreglo asociativo array ( 'campo' => 'valor por defecto')
     */
    public function setDefaultValue($params)
    {
        if (!is_array($params)) {
            return;
        }
        
        foreach ($params as $field => $value) {
            $fn = "set" . ucfirst($field);
            $fnGet = "get" . ucfirst($field);
            
            $valorActual = $this->$fnGet();
            
            if (method_exists($this, $fn) && (is_null($valorActual) || $valorActual == '-1' )) {
                $this->$fn($value);
            }
        }
    }
}
