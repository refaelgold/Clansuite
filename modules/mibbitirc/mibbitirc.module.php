<?php
   /**
    * Clansuite - just an eSports CMS
    * Jens-Andr� Koch � 2005 - onwards
    * http://www.clansuite.com/
    *
    * This file is part of "Clansuite - just an eSports CMS".
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
    *
    *    You should have received a copy of the GNU General Public License
    *    along with this program; if not, write to the Free Software
    *    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
    *
    * @license    GNU/GPL v2 or (at your option) any later version, see "/doc/LICENSE".
    *
    * @author     Jens-Andr� Koch <vain@clansuite.com>
    * @copyright  Jens-Andr� Koch (2005 - onwards)
    *
    * @link       http://www.clansuite.com
    * @link       http://gna.org/projects/clansuite
    * @since      File available since Release 0.2
    *
    * @version    SVN: $Id: index.module.php 2625 2008-12-09 00:04:43Z vain $
    */

// Security Handler
if (!defined('IN_CS')){die('Clansuite not loaded. Direct Access forbidden.');}

/**
 * Clansuite Module - Mibbit IRC
 *
 * @author  Jens-Andr� Koch <vain@clansuite.com>
 */
class Module_Mibbitirc extends Clansuite_ModuleController implements Clansuite_Module_Interface
{
    /**
     * Module_News -> Execute
     */
    public function execute(Clansuite_HttpRequest $request, Clansuite_HttpResponse $response)
    {
        # read module config
        $this->getModuleConfig();

        # proceed to the requested action
        $this->processActionController($request);
    }

    public function action_show()
    {
        $smarty = $this->getView();

        $mibbit_options['nick']        = preg_replace('/ /', '_', $_SESSION['user']['nick']);

        $mibbit_options['title']       = $this->getConfigValue('mibbit_irc_page_title',      'Live Chat');
        $mibbit_options['nick_prefix'] = $this->getConfigValue('mibbit_irc_nickname_prefix', 'cs_');
        $mibbit_options['server']      = $this->getConfigValue('mibbit_irc_server',          'irc.mibbit.com');
        $mibbit_options['channel']     = $this->getConfigValue('mibbit_irc_channel',         'mibbit_test');
        $mibbit_options['width']       = $this->getConfigValue('mibbit_irc_width',           '500');
        $mibbit_options['height']      = $this->getConfigValue('mibbit_irc_height',          '280');

        $smarty->assign('mibbit_options', $mibbit_options);
        $this->prepareOutput();
    }
}
?>