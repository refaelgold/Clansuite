<?php
/**
 * Index Module
 *
 *
 * LICENSE:
 *
 *    This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *    You should have received a copy of the GNU General Public License
 *    along with this program; if not, write to the Free Software
 *    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @license    GNU/GPL, see COPYING.txt
 *
 * @author     Jens-Andre Koch <vain@clansuite.com>
 * @copyright  Jens-Andre Koch (2005-$Date$)
 *
 * @link       http://www.clansuite.com
 * @link       http://gna.org/projects/clansuite
 * @since      File available since Release 0.2
 *
 * @version    SVN: $Id$
 */

// Security Handler
if (!defined('IN_CS')){ die('Clansuite not loaded. Direct Access forbidden.' );}

/**
 * Clansuite Module: Index
 *
 * Purpose: This class is the PageController which has many pages to deal with.
 *
 * Class was rewritten for Version 0.2
 */
class module_index extends controller_base #implements clansuite_module
{
    function __construct(Phemto $injector=null)
    {
        parent::__construct(); # run constructor on controller_base
    }

    /**
     * Controller of Modul
     *
     * switches between $_REQUEST['action'] Vars to the functions
     */
    public function execute($request, $response)
    {
        switch ($request->getParameter('action'))
        {
            case 'mvc':
                $this->mvc();
                break;
            case 'show':
                $this->show();
                break;
            case 'index':
                $this->index();
                break;
            default:
                $this->show();
                break;
        }
    }

    /**
     *  Test the MVC Framework
     *  by calling the URL "index.php?mod=index&action=mvc"
     */
    function mvc()
    {
        $index_view = new module_index_view;            # initialize the view
        $index_view->showUserData('1');                 # call view function for output
        # the requested user_id would be a get or post input variable
        echo 'Clansuite Framework - MVC is working!';   # give status and exit
        exit;
    }

    /**
     * index() redirects to show()
     */

    function index()
    {
       # class internal redirect to another function
       $this->show();
    }


    /**
     * Show the Index / Entrance -> welcome message etc.
     */
    function show()
    {
        /***
         * To set a Render Engine use the following method:
         * $this->setRenderEngine('smarty');
         *
         * You can define a specific view_type like (smarty, json, rss, php)
         *    -- or leave it away, then smarty is used as fallback!
         *
         */
        #$this->setRenderEngine('smarty');

        /**
         * Directly assign something to the output
         */
        #$this->output   .= 'This writes directly to the OUTPUT. Action show() was called.';

       /**
        * Usage of method: setTemplate($templatename)
        *
        * 1. you can specify a complete template-filename (including its path)
        * 2. if you NOT use this method,
        * we try to automatically detect the template-file by using module and action as templatename.
        *
        * the template lookup will take place in the following paths:
        *    a) in the activated "layout theme" folder (according to the user-session)
        *        example: usertheme = "standard" and $this->template = 'modulename/filename.tpl';
        *         then lookup of template in /standard/modulename/filename.tpl
        *    b) the modul-directory/templatefolder/rendererfolder/actionname.tpl
        *
        * As a result of this direct connection of URL to TPL, it's possible to
        * code in a very straightforward way:  index.php?mod=something&action=any
        * would result in a template-search in /modules/something/templates/any.tpl
        *
        * Even an empty module function would result in an rendering - a good starting point i guess!
        *
        */
        # Direct Path Assignments
        # a) call the template in root_tpl (themefolder) + path
        # This is also automagically called, when no template was set!
        #$this->setTemplate('index/show.tpl');
        # OR
        # b) directly call template in module path
        #$this->setTemplate( ROOT_MOD . '/index/templates/show.tpl' );

        # Starting the View
        $this->setView($this->getRenderEngine());

        # Prepare the Output
        $this->prepareOutput();
    }
}

/**
 * We don't need the following classes.
 * They are here for understanding the MVC Pattern.
 * Demonstration is done via function $module_index->mvc();
 */

/**
 * Module Index - View Class
 * V = View in MVC
 *
 * Purpose: View selects the Model for the choosen view(action)
 *          and assembles/prepares that view(action) with Model-Informations for Output
 *          When a Model-Object is fetched, the View calls a certain method on it to extract the data.
 *          Like $users = $userobject->findUserByID($id);
 *
 */
class module_index_view
{
     public function showUserData($user_id)
     {
        // instantiate the module_index_model
        $index_model = new module_index_model;
        // fetch data-object from the model
        $user_object = $index_model->findUserbyID($user_id);
        // perform actions on the fetched data
        #ucfirst($user_object);
        // assign data-object to view and output
        foreach ($user_object as $user_object_data)
        {
            echo '<br /><strong>'. $user_object_data .'</strong><br />';
        }        
     }
}

/**
 * Module Index - Model Class
 * M = Model in MVC
 *
 * Purpose: Select Data from Database and return Model-Informations (complete objects) to the View-Layer
 *          Like return $user;
 */
class module_index_model
{
    /**
     * test function for demonstrating the mvc approach
     * this would normally execute a sql query to fetch something from database
     * here we just cheat a little and pass data along as a return value
     */
    public function findUserById($user_id)
    {
        // SQL logic to get User Infos for a certain $user_id
        $user_data = array('name' => 'john wayne', 'town' => 'berlin');
        //returns User-ROW!
        return $user_data;
    }
}
?>