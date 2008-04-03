<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseCsNewsComments extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('cs_news_comments');
    $this->hasColumn('news_id', 'integer', 4, array (
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
    $this->hasColumn('comment_id', 'integer', 4, array (
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
  'default' => '0',
  'notnull' => true,
  'autoincrement' => false,
));
    $this->hasColumn('user_id', 'integer', 4, array (
  'alltypes' => 
  array (
    0 => 'integer',
  ),
  'ntype' => 'int(11) unsigned',
  'unsigned' => 1,
  'values' => 
  array (
  ),
  'primary' => false,
  'default' => '0',
  'notnull' => true,
  'autoincrement' => false,
));
    $this->hasColumn('body', 'string', null, array (
  'alltypes' => 
  array (
    0 => 'string',
    1 => 'clob',
  ),
  'ntype' => 'text',
  'fixed' => false,
  'values' => 
  array (
  ),
  'primary' => false,
  'notnull' => true,
  'autoincrement' => false,
));
    $this->hasColumn('added', 'timestamp', null, array (
  'alltypes' => 
  array (
    0 => 'timestamp',
  ),
  'ntype' => 'datetime',
  'values' => 
  array (
  ),
  'primary' => false,
  'default' => '0000-00-00 00:00:00',
  'notnull' => true,
  'autoincrement' => false,
));
    $this->hasColumn('pseudo', 'string', 25, array (
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
  'notnull' => false,
  'autoincrement' => false,
));
    $this->hasColumn('ip', 'string', 15, array (
  'alltypes' => 
  array (
    0 => 'string',
  ),
  'ntype' => 'varchar(15)',
  'fixed' => false,
  'values' => 
  array (
  ),
  'primary' => false,
  'notnull' => true,
  'autoincrement' => false,
));
    $this->hasColumn('host', 'string', 255, array (
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

    public function setUp()
    {
        $this->index('news_id', array('fields' => 'news_id'));
        $this->hasOne('CsNews', array('local' => 'news_id',
                                        'foreign' => 'news_id'
                                        #,
                                        #'onDelete' => 'CASCADE')
                                        ));
                                        
        $this->index('user_id', array('fields' => 'user_id'));
        $this->hasOne('CsUsers', array('local' => 'user_id',
                                        'foreign' => 'user_id'
                                        #,
                                        #'onDelete' => 'CASCADE')
                                        ));
                                        
        $this->index('comment_id', array('fields' => 'comment_id'));
    }

}
?>