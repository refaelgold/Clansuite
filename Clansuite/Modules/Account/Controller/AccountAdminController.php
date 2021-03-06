<?php

/**
 * Clansuite - just an eSports CMS
 * Jens-André Koch © 2005 - onwards
 * http://www.clansuite.com/
 *
 * This file is part of "Clansuite - just an eSports CMS".
 *
 * License: GNU/GPL v2 or any later version, see LICENSE file.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace Clansuite\Modules\Account\Controller;

/**
 * Clansuite_Module_Account_Admin
 *
 * @category    Clansuite
 * @package     Modules
 * @subpackage  Account
 */
class AccountAdminController extends ModuleController
{
    public function _initializeModule()
    {
        $this->getModuleConfig();
    }

    public function actionavatar_edit()
    {
        // Set Pagetitle and Breadcrumbs
        \Koch\View\Helper\Breadcrumb::add( _('Add Avatar'), '/users/admin/addavatar');

        // Get Render Engine
        $view = $this->getView();

        $md5_email = md5($_SESSION['user']['email']);
        $avatar_image = '';

        if ( is_file( ROOT_UPLOAD . 'images/avatars/avatar'.$md5_email.'png') ) {
            $avatar_image = ROOT_UPLOAD . 'images/avatars/avatar'.$md5_email.'png';
        } else {
            $avatar_image = ROOT_UPLOAD . 'images/avatars/no_avatar.png';
        }

        $view->assign('avatar_image', $avatar_image);

        $this->display();
    }

    public function actionavatar_delete()
    {

    }

    public function actionuserpicture_edit()
    {

    }

    public function actionuserpicture_remove()
    {

    }

    /**
     * Usercenter
     *
     * Shows own Profil, Messages, Personal Geustbooks, Abonnenments from the Form, Next Events and Matches, Votes etc.
     */
    public function actionusercenter()
    {
        // Set Pagetitle and Breadcrumbs
        \Koch\View\Helper\Breadcrumb::add( _('Usercenter'), '/users/admin/usercenter');

        // Get Render Engine
        $view = $this->getView();

        // Get the user data
        #SELECT * FROM ' . DB_PREFIX . 'users WHERE user_id = ?' );
        #$_SESSION['user']['user_id']

        #$view->assign( 'usercenterdata', $data );

        // Set Admin Layout Template
        $view->setLayoutTemplate('index.tpl');

        $this->display();
    }

    public function actionusercenter_edit()
    {

    }

    public function actionusercenterUpdate()
    {

    }

    public function actionSettings()
    {
        // Set Pagetitle and Breadcrumbs
        \Koch\View\Helper\Breadcrumb::add( _('Settings'), '/account/admin/settings');

        $settings = array();

        $settings['form'] = array('name'   => 'account_settings',
                                  'method' => 'POST',
                                  'action' => '/account/admin/settingsUpdate');

        $settings['account'][] = array( 'id' => 'resultsPerPage_show',
                                        'name' => 'resultsPerPage_show',
                                        'label' => 'Newsitems',
                                        'description' => _('Newsitems to show in Newsmodule'),
                                        'formfieldtype' => 'text',
                                        'value' => self::getConfigValue('resultsPerPage_show', '3'));

        $form = new Clansuite_Form($settings);

        #\Koch\Debug\Debug::printR($form);

        $form->addElement('submitbutton')->setName('Save');
        $form->addElement('resetbutton');

        // display form html
        #\Koch\Debug\Debug::printR($form->render());

        // assign the html of the form to the view
        $this->getView()->assign('form', $form->render());

        $this->display();
    }

    public function actionSettingsUpdate()
    {
        // Incomming Data
        // @todo get post via request object, sanitize
        $data = $this->request->getParameter('account_settings');

        // Get Configuration from Injector and write Config
        $this->getInjector()->instantiate('Clansuite_Config')->writeModuleConfig($data);

        // clear the cache / compiled tpls
        $this->getView()->clearCache();

        // Redirect
        $this->response->redirectNoCache('/account/admin', 2, 302, 'The config file has been successfully updated.');
    }
}
