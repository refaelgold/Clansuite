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

namespace Clansuite\Modules\Forum\Controller;

use Clansuite\Core\Mvc\ModuleController;

/**
 * ForumAdminController
 *
 * @category    Clansuite
 * @package     Modules
 * @subpackage  Forum
 */
class ForumAdminController extends ModuleController
{
    public function _initializeModule()
    {
        $this->getModuleConfig();
    }

    public function actionshow()
    {
        // Set Pagetitle and Breadcrumbs
        \Koch\View\Helper\Breadcrumb::add( _('Show'), '/forum/show');

        // Set Layout Template
        $this->getView()->setLayoutTemplate('index.tpl');

        $this->display();
    }

    public function actionCreate_category()
    {
        // Set Pagetitle and Breadcrumbs
        \Koch\View\Helper\Breadcrumb::add( _('Create Category'), '/forum/create_category');

        // Set Layout Template
        $this->getView()->setLayoutTemplate('index.tpl');

        $this->display();
    }

    public function actionCreate_board()
    {
        // Set Pagetitle and Breadcrumbs
        \Koch\View\Helper\Breadcrumb::add( _('Create Board'), '/forum/create_board');

        // Set Layout Template
        $this->getView()->setLayoutTemplate('index.tpl');

        $this->display();
    }

    public function actionEdit_category()
    {
        // Set Pagetitle and Breadcrumbs
        \Koch\View\Helper\Breadcrumb::add( _('Edit Category'), '/forum/edit_category');

        // Set Layout Template
        $this->getView()->setLayoutTemplate('index.tpl');

        $this->display();
    }

    public function actionEdit_board()
    {
        // Set Pagetitle and Breadcrumbs
        \Koch\View\Helper\Breadcrumb::add( _('Edit Board'), '/forum/edit_board');

        // Set Layout Template
        $this->getView()->setLayoutTemplate('index.tpl');

        $this->display();
    }

    public function actionDelete_category()
    {
        // Set Pagetitle and Breadcrumbs
        \Koch\View\Helper\Breadcrumb::add( _('Delete Category'), '/forum/delete_category');

        // Set Layout Template
        $this->getView()->setLayoutTemplate('index.tpl');

        $this->display();
    }

    public function actionDelete_board()
    {
        // Set Pagetitle and Breadcrumbs
        \Koch\View\Helper\Breadcrumb::add( _('Delete Board'), '/forum/delete_board');

        // Set Layout Template
        $this->getView()->setLayoutTemplate('index.tpl');

        $this->display();
    }

    public function actionSettings ()
    {
        // Set Pagetitle and Breadcrumbs
        \Koch\View\Helper\Breadcrumb::add( _('Settings'), '/forum/admin/settings');

        $settings = array();

        $settings['form']   = array(    'name' => 'forum_settings',
                                        'method' => 'POST',
                                        'action' => '/forum/admin/settingsUpdate');

        $settings['forum'][] = array(
                                        'id' => 'list_max',
                                        'name' => 'list_max',
                                        'description' => _('list_max'),
                                        'formfieldtype' => 'text',
                                        'value' => self::getConfigValue('list_max', '30'));

        $settings['forum'][] = array(
                                        'id' => 'char_max',
                                        'name' => 'char_max',
                                        'description' => _('Maximum Textcharacter'),
                                        'formfieldtype' => 'text',
                                        'value' => self::getConfigValue('char_max', '999'));

        $settings['forum'][] = array(
                                        'id' => 'allow_bb_code',
                                        'name' => 'allow_bb_code',
                                        'description' => _('Allow BBCode'),
                                        'formfieldtype' => 'selectyesno',
                                        'value' => array( 'selected' => self::getConfigValue('allow_bb_code', '1')));

        $settings['forum'][] = array(
                                        'id' => 'allow_html',
                                        'name' => 'allow_html',
                                        'description' => _('Allow HTML'),
                                        'formfieldtype' => 'text',
                                        'value' => self::getConfigValue('allow_html', '0'));

        $settings['forum'][] = array(
                                        'id' => 'allow_geshi_highlight',
                                        'name' => 'allow_geshi_highlight',
                                        'description' => _('Allow Geshi Highlighting'),
                                        'formfieldtype' => 'text',
                                        'value' => self::getConfigValue('allow_geshi_highlight', '1'));

        $form = new Clansuite_Form($settings);

        // display formgenerator object
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
        $data = $this->request->getParameter('forum_settings');

        // Get Configuration from Injector and write Config
        $this->getInjector()->instantiate('Clansuite_Config')->writeModuleConfig($data);

        // clear the cache / compiled tpls
        $this->getView()->clearCache();

        // Redirect
        $this->response->redirectNoCache('/forum/admin', 2, 302, 'The config file has been succesfully updated.');
    }
}
