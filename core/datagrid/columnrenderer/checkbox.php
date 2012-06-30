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
    * @author     Jens-Andr� Koch <vain@clansuite.com>
    * @copyright  Jens-Andr� Koch (2005-onwards)
    * @link       http://www.clansuite.com
    *
    * @version    SVN: $Id$
    */

namespace Koch\Datagrid\Columnrenderer;

# Security Handler
if (defined('IN_CS') === false) {
    exit('Koch Framework not loaded. Direct Access forbidden.');
}

/**
 * Datagrid Column Renderer Checkbox
 *
 * Renders cell with a checkbox
 *
 * @author Florian Wolf <xsign.dll@clansuite.com>
 */
class Checkbox extends ColumnRenderer implements ColumnRendererInterface
{
    /**
     * Render the value(s) of a cell
     *
     * @param Clansuite_Datagrid_Cell
     * @return string Return html-code
     */
    public function renderCell($oCell)
    {
        $oCheckbox = new Clansuite_Formelement_Checkbox();
        $oCheckbox->setName('Checkbox[]');
        $oCheckbox->setID('Checkbox-' . $oCell->getValue());
        $oCheckbox->setValue($oCell->getValue());
        $oCheckbox->setClass('DatagridCheckbox DatagridCheckbox-' . $oCell->getColumn()->getAlias());

        return $oCheckbox->render();

        #return sprintf('<input type="checkbox" value="%s" id="Checkbox-%s" name="Checkbox[]" />', $oCell->getValue(), $oCell->getValue());
    }
}
