<?php

/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class CsModulesTable extends Doctrine_Table
{
    /**
     * Doctrine_Query to fetch all Modules
     * and return an array prepared for dropdown display
     */
    public static function fetchAllModulesDropDown()
    {
        # fetch modules via doctrine query
        $modules = Doctrine_Query::create()
                                    ->select('m.name, m.module_id')
                                    ->from('CsModules m')
                                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                                    ->execute( array() );
        
		#create exlude array, these modules doen`t need categories
		$exclude_modules = array (
									'account',
									'captcha',
									'admin',
									'shoutbox',
									'guestbook',
									'filebrowser',
									'users',
									'messaging'
								  );
								  
        # transform array
        foreach($modules as $module)
        {
			if(in_array($module['name'], $exclude_modules))
			{
			continue;
            }
			else {
			$modules_dropdown_array[$module['module_id']] = $module['name'];
			}
        }
        
        return $modules_dropdown_array;
    }
}
?>