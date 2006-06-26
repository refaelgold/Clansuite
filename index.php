<?php
/**
* INDEX
*
* PHP versions 5.1.4
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
* @author     Florian Wolf <xsign.dll@clansuite.com>
* @author     Jens-Andre Koch <vain@clansuite.com>
* @copyright  2006 Clansuite Group
* @license    see COPYING.txt
* @version    SVN: $Id: index.php 156 2006-06-14 08:45:48Z xsign $
* @link       http://gna.org/projects/clansuite
* @since      File available since Release 0.1
*/

//----------------------------------------------------------------
// Load public config
//----------------------------------------------------------------
include ('public.config.php');

//--------------------------------------------------------
// SETUP EVERYTHING
//--------------------------------------------------------
include 'core/prepend.php';

$tpl->display(TPL_ROOT . '/' . TPL_NAME . '/' . $cfg->tpl_wrapper_file);

//----------------------------------------------------------------
// Show Debug Console
//----------------------------------------------------------------
DEBUG ? $debug->show_console() : '';
?>