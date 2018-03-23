<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author gabriel.martinez
 */
interface ModelProperties {
  static function getFields(); 

  static function getFieldsToRemove();
  
  static function getPrimaryKey();
  
  static function getTableName();
  
  static function getConnection();
}

?>
