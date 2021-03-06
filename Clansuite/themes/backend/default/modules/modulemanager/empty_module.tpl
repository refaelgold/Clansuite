<?php
   /**
    * Clansuite - just an E-Sport CMS
    * Jens-Andre Koch, Florian Wolf � 2005-2007
    * http://www.clansuite.com/
    *
    * File:         {$name}.module.php
    * Requires:     PHP 5.1.4+
    *
    * Purpose:      Clansuite Module Class - {$name}
    *               {$description}
    *
    */

/**
 * This is the Clansuite Module Class - {$class_name}
 *
 * Description:  {$description}
 *
 * @package     clansuite
 * @category    module
 * @subpackage  {$class_name}
 */
class {$class_name}
{ldelim}
    public $output          = '';
    public $additional_head = '';
    public $suppress_wrapper= '';

    /**
     * @desc General Function Hook of {$name}-Modul
     *
     * 1. Set Pagetitle and Breadcrumbs
     * 2. $_REQUEST['action'] determines the switch
     * 3. function title is added to page title, to complete the title
     * 4. switch-functions are called
     *
     * @return: array ( OUTPUT, ADDITIONAL_HEAD, SUPPRESS_WRAPPER )
     */

    function auto_run()
    {ldelim}

        global $lang, $trail, $perms;
        $params = func_get_args();

        // Set Pagetitle and Breadcrumbs
        $trail->addStep($lang->t('{$title}'), 'index.php?mod={$name}');

        //
        switch ($_REQUEST['action'])
        {ldelim}

            default:
            case 'show':
                $trail->addStep($lang->t('Show'), 'index.php?mod={$name}&amp;action=show');
                $this->show();
                break;

            case 'instant_show':
                $this->output .= call_user_func_array( array( $this, 'instant_show' ), $params );
                break;

        {rdelim}

        return array( 'OUTPUT'          => $this->output,
                      'ADDITIONAL_HEAD' => $this->additional_head,
                      'SUPPRESS_WRAPPER'=> $this->suppress_wrapper );
    {rdelim}

    /**
     * Action -> Show
     * Direct Call by URL/index.php?mod={$name}&action=show
     *
     * @global $cfg, $db, $tpl, $error, $lang, $functions, $security, $input, $perms, $users;
     */

    function show()
    {ldelim}
        global $cfg, $db, $tpl, $error, $lang, $functions, $security, $input, $perms, $users;

         // Add $lang-t() translated text to the output.
        $this->output .= $lang->t('You have created a new module, that currently handles this message');
    {rdelim}

    /**
     * Instant Show
     *
     * Content of a module can be instantly displayed by adding the
     * {ldelim}mod name="{$name}" sub="admin" func="instant_show" params="mytext"{rdelim}
     * block into a template.
     *
     * You have to add the lines as shown above into the case block:
     * $this->output .= call_user_func_array( array( $this, 'instant_show' ), $params );
     *
     * @global $cfg, $db, $tpl, $error, $lang, $functions, $security, $input, $perms, $users
    */

    function instant_show($my_text)
    {ldelim}
        global $cfg, $db, $tpl, $error, $lang, $functions, $security, $input, $perms, $users;

        // Add $lang-t() translated text to the output.
        $this->output .= $lang->t($my_text);
    {rdelim}
{rdelim}
?>
