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
    *
    * @version    SVN: $Id: clansuite.xdebug.php 2540 2008-10-02 00:14:21Z vain $
    */
    
# Define security constant
if (!defined('IN_CS')){ die( 'Clansuite not loaded. Direct Access forbidden.' );}
?>
    <div id="content" class="narrowcolumn">
        <div id="content_middle">
            <div class="accordion">
                <h2 class="headerstyle">
                    <img src="../images/64px-Tango_Globe_of_Letters.svg.png" border="0" style="vertical-align:middle" alt="installstep image" />
                    <?=$language['STEP3_HEADING']?>
                </h2>
                <?php if ($error != '' ) { ?>
                <fieldset class="error_red">
                    <legend>Error</legend>
                    <strong><?=$error ?></strong>
                </fieldset>
                <?php } ?>
                <p><?=$language['STEP3_ENTER_CONNECTION_DATA'] . $cms_array[0]; ?></p>
                <form action="index.php" method="post" accept-charset="UTF-8">
                    <fieldset>
                        <legend> <?=$language['STEP3_DATABASE_ACCESS_INFORMATION']; ?></legend>
                        <input type="hidden" name="db_type" value="mysql" />
                        <ol class="formular">
                            <li>
                                <label class="formularleft" for="db_host"><?=$language['DB_HOST']?></label>
                                <input class="formularright" type="text" id="db_host" name="config[database][db_host]" value="<?=$values['db_host']?>" />
                            </li>
                            <li>
                                <label class="formularleft" for="db_type"><?=$language['DB_TYPE']?></label>
                                <input class="formularright" type="text" id="db_type" name="config[database][db_type]" value="<?=$values['db_type']?>" />
                            </li>
                            <li>
                                <label class="formularleft" for="db_username"><?=$language['DB_USERNAME']?></label>
                                <input class="formularright" type="text" id="db_username" name="config[database][db_username]" value="<?=$values['db_username']?>" />
                            </li>
                            <li>
                                <label class="formularleft" for="db_password"><?=$language['DB_PASSWORD']?></label>
                                <input class="formularright" type="text" id="db_password" name="config[database][db_password]" value="<?=$values['db_password']?>" />
                            </li>
                            <li>
                                <label class="formularleft" for="db_name"><?=$language['DB_NAME']?></label>
                                <input class="formularright" type="text" id="db_name" name="config[database][db_name]" value="<?=$values['db_name']?>" />
                            </li>
                            <li>
                                <label class="formularleft" for="db_create_database"><?=$language['DB_CREATE_DATABASE']?></label>
                                <input class="formularright" type="checkbox" id="db_create_database" name="config[database][db_create_database]"
                                <? if($values['db_create_database'] == '1') { ?> checked="checked" <? } ?> />
                            </li>
                            <li>
                                <label class="formularleft" for="db_prefix"><?=$language['DB_PREFIX']?></label>
                                <input class="formularright" type="text" id="db_prefix" name="config[database][db_prefix]" value="<?=$values['db_prefix']?>" />
                            </li>
                        </ol>
                    </fieldset>
                    <div id="content_footer">
                        <div class="navigation">
                            <span style="font-size:10px;">
                                <?=$language['CLICK_NEXT_TO_PROCEED']?><br />
                                <?=$language['CLICK_BACK_TO_RETURN']?>
                            </span>
                            <div class="alignright">
                                <input type="submit" value="<?=$language['NEXTSTEP']?>" class="ButtonGreen" name="step_forward" />
                            </div>
                            <div class="alignleft">
                                <input type="submit" value="<?=$language['BACKSTEP']?>" class="ButtonRed" name="step_backward" />
                                <input type="hidden" name="lang" value="<?=$_SESSION['lang']?>" />
                            </div>
                        </div><!-- div navigation end -->
                    </div> <!-- div content_footer end -->
                </form>
            </div> <!-- div accordion end -->
        </div> <!-- div content_middle end -->
     </div> <!-- div content end -->
