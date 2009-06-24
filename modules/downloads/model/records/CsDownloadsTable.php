<?php

/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class CsDownloadsTable extends Doctrine_Table
{
    public function fetchTopFiles($number)
    {
        return Doctrine_Query::create()
               ->select('m.*')
               ->from('CsDownloads m')
               #->orderby('m.download_rating DESC') # @todo rating table
               ->limit($number)
               ->fetchArray();
    }

    public function fetchLatestFiles($number)
    {
        return Doctrine_Query::create()
               ->select('m.*')
               ->from('CsDownloads m')
               #->orderby('m.added_date DESC')
               #->where('m.added_date < ?', time() ) # @todo added_date
               ->limit($number)
               ->fetchArray();
    }
}
?>