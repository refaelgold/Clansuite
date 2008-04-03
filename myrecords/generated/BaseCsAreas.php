<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseCsAreas extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('cs_areas');
    $this->hasColumn('area_id', 'integer', 4, array (
  'alltypes' => 
  array (
    0 => 'integer',
  ),
  'ntype' => 'int(11)',
  'unsigned' => 0,
  'values' => 
  array (
  ),
  'primary' => true,
  'notnull' => true,
  'autoincrement' => true,
));
    $this->hasColumn('name', 'string', 255, array (
  'alltypes' => 
  array (
    0 => 'string',
  ),
  'ntype' => 'varchar(255)',
  'fixed' => false,
  'values' => 
  array (
  ),
  'primary' => false,
  'default' => 'New Area',
  'notnull' => true,
  'autoincrement' => false,
));
    $this->hasColumn('description', 'string', 255, array (
  'alltypes' => 
  array (
    0 => 'string',
  ),
  'ntype' => 'varchar(255)',
  'fixed' => false,
  'values' => 
  array (
  ),
  'primary' => false,
  'notnull' => true,
  'autoincrement' => false,
));
  }


}
?>