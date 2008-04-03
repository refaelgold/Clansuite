<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseCsUsers extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('cs_users');
    $this->hasColumn('user_id', 'integer', 4, array (
  'alltypes' => 
  array (
    0 => 'integer',
  ),
  'ntype' => 'int(10) unsigned',
  'unsigned' => 1,
  'values' => 
  array (
  ),
  'primary' => true,
  'notnull' => true,
  'autoincrement' => true,
));
    $this->hasColumn('email', 'string', 150, array (
  'alltypes' => 
  array (
    0 => 'string',
  ),
  'ntype' => 'varchar(150)',
  'fixed' => false,
  'values' => 
  array (
  ),
  'primary' => false,
  'notnull' => false,
  'autoincrement' => false,
));
    $this->hasColumn('nick', 'string', 25, array (
  'alltypes' => 
  array (
    0 => 'string',
  ),
  'ntype' => 'varchar(25)',
  'fixed' => false,
  'values' => 
  array (
  ),
  'primary' => false,
  'notnull' => true,
  'autoincrement' => false,
));
    $this->hasColumn('passwordhash', 'string', 40, array (
  'alltypes' => 
  array (
    0 => 'string',
  ),
  'ntype' => 'varchar(40)',
  'fixed' => false,
  'values' => 
  array (
  ),
  'primary' => false,
  'notnull' => true,
  'autoincrement' => false,
));
    $this->hasColumn('new_passwordhash', 'string', 40, array (
  'alltypes' => 
  array (
    0 => 'string',
  ),
  'ntype' => 'varchar(40)',
  'fixed' => false,
  'values' => 
  array (
  ),
  'primary' => false,
  'notnull' => true,
  'autoincrement' => false,
));
    $this->hasColumn('code', 'string', 255, array (
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
    $this->hasColumn('joined', 'integer', 4, array (
  'alltypes' => 
  array (
    0 => 'integer',
  ),
  'ntype' => 'int(11)',
  'unsigned' => 0,
  'values' => 
  array (
  ),
  'primary' => false,
  'default' => '0',
  'notnull' => true,
  'autoincrement' => false,
));
    $this->hasColumn('timestamp', 'integer', 4, array (
  'alltypes' => 
  array (
    0 => 'integer',
  ),
  'ntype' => 'int(11)',
  'unsigned' => 0,
  'values' => 
  array (
  ),
  'primary' => false,
  'default' => '0',
  'notnull' => true,
  'autoincrement' => false,
));
    $this->hasColumn('disabled', 'integer', 1, array (
  'alltypes' => 
  array (
    0 => 'integer',
    1 => 'boolean',
  ),
  'ntype' => 'tinyint(1)',
  'unsigned' => 0,
  'values' => 
  array (
  ),
  'primary' => false,
  'default' => '0',
  'notnull' => true,
  'autoincrement' => false,
));
    $this->hasColumn('activated', 'integer', 1, array (
  'alltypes' => 
  array (
    0 => 'integer',
    1 => 'boolean',
  ),
  'ntype' => 'tinyint(1)',
  'unsigned' => 0,
  'values' => 
  array (
  ),
  'primary' => false,
  'default' => '0',
  'notnull' => true,
  'autoincrement' => false,
));
    $this->hasColumn('status', 'integer', 1, array (
  'alltypes' => 
  array (
    0 => 'integer',
    1 => 'boolean',
  ),
  'ntype' => 'tinyint(4)',
  'unsigned' => 0,
  'values' => 
  array (
  ),
  'primary' => false,
  'default' => '0',
  'notnull' => true,
  'autoincrement' => false,
));
    $this->hasColumn('country', 'string', 5, array (
  'alltypes' => 
  array (
    0 => 'string',
  ),
  'ntype' => 'varchar(5)',
  'fixed' => false,
  'values' => 
  array (
  ),
  'primary' => false,
  'notnull' => true,
  'autoincrement' => false,
));
    $this->hasColumn('language', 'string', 12, array (
  'alltypes' => 
  array (
    0 => 'string',
  ),
  'ntype' => 'varchar(12)',
  'fixed' => false,
  'values' => 
  array (
  ),
  'primary' => false,
  'notnull' => true,
  'autoincrement' => false,
));
    $this->hasColumn('timezone', 'string', 8, array (
  'alltypes' => 
  array (
    0 => 'string',
  ),
  'ntype' => 'varchar(8)',
  'fixed' => false,
  'values' => 
  array (
  ),
  'primary' => false,
  'notnull' => false,
  'autoincrement' => false,
));
    $this->hasColumn('theme', 'string', 255, array (
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