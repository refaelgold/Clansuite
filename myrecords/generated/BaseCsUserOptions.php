<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseCsUserOptions extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('cs_user_options');   
    $this->hasColumn('option_id', 'integer', 4, array('alltypes' =>  array(  0 => 'integer', ), 'ntype' => 'int(11) unsigned', 'unsigned' => 1, 'values' =>  array(), 'primary' => true, 'default' => '0', 'notnull' => true, 'autoincrement' => false));
    $this->hasColumn('user_id', 'integer', 4, array('alltypes' =>  array(  0 => 'integer', ), 'ntype' => 'int(11) unsigned', 'unsigned' => 1, 'values' =>  array(), 'primary' => true, 'default' => '0', 'notnull' => true, 'autoincrement' => false));
  }


}
?>