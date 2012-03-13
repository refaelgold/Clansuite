<?php
   /**
    * Koch Framework
    * Jens-Andr� Koch � 2005 - onwards
    * http://www.clansuite.com/
    *
    * This file is part of "Koch Framework".
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
    * @author     Jens-Andr� Koch <vain@clansuite.com>
    * @copyright  Jens-Andr� Koch (2005 - onwards)
    * @link       http://www.clansuite.com
    *
    * @version    SVN: $Id$
    */

namespace Koch\Filter\Filters;

use Koch\Filter\FilterInterface;
use Koch\MVC\HttpRequestInterface;
use Koch\MVC\HttpResponseInterface;
use Koch\Localization\Localization;
use Koch\Router\TargetRoute;

# Security Handler
if(defined('IN_CS') === false)
{
    exit('Koch Framework not loaded. Direct Access forbidden.');
}

/**
 * Koch Framework - Filter for Setting the Module Language.
 *
 * Purpose: Sets the TextDomain for the requested Module
 *
 * @category    Koch
 * @package     Core
 * @subpackage  Filters
 */
class SetModuleLanguage implements FilterInterface
{
    /* @var Koch\Localization */
    private $locale = null;

    public function __construct(Localization $locale)
    {
        # set instance of localization to class
        $this->locale = $locale;
    }

    public function executeFilter(HttpRequestInterface $request, HttpResponseInterface $response)
    {
        $modulename = TargetRoute::getController();

        $this->locale->loadTextDomain('LC_ALL', $modulename, $this->locale->getLocale(), $modulename);
    }
}
?>