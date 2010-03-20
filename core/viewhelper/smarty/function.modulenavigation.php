<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage Clansuite Plugins / Smarty View Helper
 */

/**
 * Smarty ModuleNavigation
 * Displays a Module Navigation Element
 * depends on module configuration file.
 *
 * Examples:
 * <pre>
 * {modulnavigation}
 * </pre>
 *
 * Type:     function<br>
 * Name:     modulenavigation<br>
 * Purpose:  display modulenavigation<br>
 * @author   Jens-Andr� Koch <vain@clansuite.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GPL 2 / any later version
 * @param array $params
 * @param Smarty $smarty
 * @return string
 */
function smarty_function_modulenavigation($params, $smarty)
{
    # determine the path of the modulenavigation description file
    $modulenavigation_file = ROOT_MOD. Clansuite_Module_Controller_Resolver::getModuleName() . DS .
                                       Clansuite_Module_Controller_Resolver::getModuleName() . '.menu.php';

    # check if file exists
    if( is_file($modulenavigation_file) )
    {
        # then load
        require ($modulenavigation_file);

        # and assing the modulenavigation array as smarty variable
        $smarty->assign('modulenavigation', $modulenavigation);

        # load the generic modulenavigation template
        return $smarty->fetch('modulenavigation-generic.tpl');
    }
    else # if no file was found - say so
    {
        $smarty->assign('modulename', Clansuite_Module_Controller_Resolver::getModuleName());

        $errormessage = $smarty->fetch('modulenavigation_not_found.tpl');

        trigger_error($errormessage);
    }
}
?>
