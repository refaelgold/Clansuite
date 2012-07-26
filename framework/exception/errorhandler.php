<?php

/**
 * Koch Framework
 * Jens-André Koch © 2005 - onwards
 *
 * This file is part of "Koch Framework".
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
 * along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 */

namespace Koch\Exception;

/**
 * Koch Framework - Class for Errorhandling
 *
 * Sets up a custom Errorhandler.
 * @see Clansuite\CMS::initialize_Errorhandling()
 *
 * @example
 * <code>
 * 1) trigger_error('Errormessage', E_ERROR_TYPE);
 *    E_ERROR_TYPE as string or int
 * 2) trigger_error('Errorhandler Test - This should trigger a E_USER_NOTICE!', E_USER_NOTICE);
 * </code>
 *
 * @category    Koch
 * @package     Core
 * @subpackage  Errorhandler
 */
class Errorhandler
{
    /**
     * Koch Framework - Error callback.
     *
     * This is basically a switch statement, defining the actions taken,
     * in case of serveral PHP error states.
     *
     * @link http://www.usegroup.de/software/phptutorial/debugging.html
     * @link http://www.php.net/manual/de/function.set-error-handler.php
     * @link http://www.php.net/manual/de/errorfunc.constants.php
     *
     * @param integer $errornumber  contains the error as integer
     * @param string  $errorstring  contains error string info
     * @param string  $errorfile    contains the filename with occuring error
     * @param string  $errorline    contains the line of error
     * @param string  $errorcontext
     */
    public static function errorhandler( $errornumber, $errorstring, $errorfile, $errorline, $errorcontext )
    {
        /**
         * do just return, if the error is suppressed,
         * due to (@)silencing-operator
         */
        if (error_reporting() === 0) {
            return;
        }

        /**
         * Assemble the error informations
         */

        # set the error time
        $errortime = date(DATE_FORMAT);

        /**
         * Definition of PHP Errortypes Array - with names for all the php error codes
         * @link http://php.net/manual/de/errorfunc.constants.php
         */
        $errorTypes = array (
            1     => 'E_ERROR',               # fatal run-time errors, like php is failing memory allocation
            2     => 'E_WARNING',             # Run-time warnings (non-fatal errors)
            4     => 'E_PARSE',               # compile-time parse errors - generated by the parser
            8     => 'E_NOTICE',              # Run-time notices (could be an indicator for an error)
            16    => 'E_CORE_ERROR',          # PHP Core reports errors in PHP's initial startup
            32    => 'E_CORE_WARNING',        # PHP Core reports warning (non-fatal errors)
            64    => 'E_COMPILE_ERROR',       # Zend Script Engine reports fatal compile-time errors
            128   => 'E_COMPILE_WARNING',     # Zend Script Engine reports compile-time warnings (non-fatal errors)
            256   => 'E_USER_ERROR',          # trigger_error() / user_error() reports user-defined error
            512   => 'E_USER_WARNING',        # trigger_error() / user_error() reports user-defined warning
            1024  => 'E_USER_NOTICE',         # trigger_error() / user_error() reports user-defined notice
            #2047  => 'E_ALL 2047 PHP <5.2.x', # all errors and warnings + old value of E_ALL of PHP Version below 5.2.x
            2048  => 'E_STRICT',              # PHP suggests codechanges to ensure interoperability / forwad compat
            4096  => 'E_RECOVERABLE_ERROR',   # catchable fatal error, if not catched it's an e_error (since PHP 5.2.0)
            #6143  => 'E_ALL 6143 PHP5.2.x',   # all errors and warnings + old value of E_ALL of PHP Version 5.2.x
            8191  => 'E_ALL 8191',            # PHP 6 -> 8191
            8192  => 'E_DEPRECATED',          # notice marker for 'in future' deprecated php-functions (since PHP 5.3.0)
            16384 => 'E_USER_DEPRECATED',     # trigger_error() / user_error() reports user-defined deprecated functions
            30719 => 'E_ALL 30719 PHP5.3.x',  # all errors and warnings - E_ALL of PHP Version 5.3.x
            32767 => 'E_ALL 32767 PHP6'       # all errors and warnings - E_ALL of PHP Version 6
        );

        # check if the error number exists in the errortypes array
        if (true === isset($errorTypes[$errornumber])) {
            # get the errorname from the array via $errornumber
            $errorname = $errorTypes[$errornumber];
        }

        # Handling the ErrorType via Switch
        switch ($errorname) {
            # What are the errortypes that can be handled by a user-defined errorhandler?
            case 'E_WARNING':
                $errorname .= ' [PHP Warning]';
                break;
            case 'E_NOTICE':
                $errorname .= ' [PHP Notice]';
                break;
            case 'E_USER_ERROR':
                $errorname .= ' [Koch Framework Internal Error]';
                break;
            case 'E_USER_WARNING':
                $errorname .= ' [Koch Framework Internal Error]';
                break;
            case 'E_USER_NOTICE':
                $errorname .= ' [Koch Framework Internal Error]';
                break;
            case 'E_ALL':
            case 'E_STRICT':
                $errorname .= ' [PHP Strict]';
                break;
            case 'E_RECOVERABLE_ERROR':
                $errorname .= ' [php not-unstable]';
                break;
            # when it's not in there, its an unknown errorcode
            default:
                $errorname .= ' Unknown Errorcode ['. $errornumber .']: ';
        }

        # make the errorstring more useful by linking it to the php manual
        $errorstring = preg_replace("/<a href='(.*)'>(.*)<\/a>/", '<a href="http://php.net/$1" target="_blank">?</a>', $errorstring);

        # shorten errorfile string by removing the root path
        $errorfile = str_replace(ROOT, '', $errorfile);

        # if DEBUG is set, display the error
        if ( defined('DEBUG') and DEBUG == 1 ) {
            /**
             * SMARTY ERRORS are thrown by trigger_error() - so they bubble up as E_USER_ERROR.
             *
             * In order to handle smarty errors with an seperated error display,
             * we need to detect, if an E_USER_ERROR is either incoming from
             * SMARTY or from a template_c file (extension tpl.php).
             */
            if((true === (bool) mb_strpos(mb_strtolower($errorfile), 'smarty')) or
               (true === (bool) mb_strpos(mb_strtolower($errorfile), 'tpl.php')))
            {
                # ok it's an Smarty Template Error - show the error via smarty_error_display inside the template
                echo self::smarty_error_display( $errornumber, $errorname, $errorstring, $errorfile, $errorline, $errorcontext );
            } else { # give normal Error Display
                # All Error Informations (except backtraces)
                echo self::yellowScreenOfDeath($errornumber, $errorname, $errorstring, $errorfile, $errorline, $errorcontext );
            }
        }

        # Skip PHP internal error handler

        return true;
    }

    /**
     * Smarty Error Display
     *
     * This method defines the html-output when an Smarty Template Error occurs.
     * It's output is a shortened version of the normal error report, presenting
     * only the errorname, filename and the line of the error.
     * The parameters used for the small report are $errorname, $errorfile, $errorline.
     * If you need a full errorreport, you can add more parameters from the methodsignature
     * to the $errormessage output.
     *
     * Smarty Template Errors are only displayed, when Koch Framework is in DEBUG Mode.
     * @see clansuite_error_handler()
     *
     * A direct link to the template editor for editing the file with the error
     * is only displayed, when Koch Framework runs in DEVELOPMENT Mode.
     * @see addTemplateEditorLink()
     *
     * @param integer $errornumber contains the error as integer
     * @param string  $errorstring contains error string info
     * @param string  $errorfile   contains the filename with occuring error
     * @param string  $errorline   contains the line of error
     * @param $errorcontext $errorline contains context
     * @return string HTML with Smarty Error Text and Link.
     */
    private static function smarty_error_display($errornumber, $errorname, $errorstring, $errorfile, $errorline, $errorcontext)
    {
        $html = '';
        $html .= '<span>';
        $html .= '<h3><font color="#ff0000">&raquo; Smarty Template Error &laquo;</font></h3>';
        $html .= '<u>' . $errorname . ' (' . $errornumber . '): </u><br/>';
        $html .= '<b>' . wordwrap($errorstring, 50, "\n") . '</b><br/>';
        $html .= 'File: ' . $errorfile . '<br/>Line: ' . $errorline;
        $html .= self::getTemplateEditorLink($errorfile, $errorline, $errorcontext);
        $html .= '<br/></span>';

        return $html;
    }

    /**
     * getTemplateEditorLink
     *
     * a) determines the path to the invalid template file
     * b) provides the html-link to the templateeditor for this file
     *
     * @param $errorfile Template File with the Error.
     * @param $errorline Line Number of the Error.
     * @todo correct link to the templateeditor
     */
    private static function getTemplateEditorLink($errorfile, $errorline, $errorcontext)
    {
        # display the link to the templateeditor, if we are in DEVELOPMENT MODE
        # and more essential if the error relates to a template file
        if (defined('DEVELOPMENT') and DEVELOPMENT === 1 and (mb_strpos(mb_strtolower($errorfile), '.tpl') === true)) {
            # ok, it's a template, so we have a template context to determine the templatename
            $tpl_vars = $errorcontext['this']->getTemplateVars();

            # maybe the templatename is defined in tpl_vars
            if (true === isset($tpl_vars['templatename'])) {
                $errorfile = $tpl_vars['templatename'];
            } else { # else use resource_name from the errorcontext
                $errorfile = $errorcontext['resource_name'];
            }

            # construct the link to the tpl-editor
            $html = '<br/><a href="index.php?mod=templatemanager&amp;sub=admin&amp;action=editor';
            $html .= '&amp;file=' . $errorfile . '&amp;line=' . $errorline;
            $html .= '">Edit the Template</a>';

            # return the link

            return $html;
        }
    }

    /**
     * Yellow Screen of Death (YSOD) is used to display a Koch Framework Error
     *
     * @param int    $errornumber
     * @param string $errorname
     * @param string $errorstring
     * @param string $errorfile
     * @param int    $errorline
     * @param string $errorcontext
     */
    private static function yellowScreenOfDeath($errornumber, $errorname, $errorstring, $errorfile, $errorline, $errorcontext)
    {
        $short_errorstring = self::shortenStringMaxLength($errorstring, 70, '...');

        # Header
        $html = '<html><head>';
        $html .= '<title>Koch Framework Error</title>';
        $html .= '<link rel="stylesheet" href="' . WWW_ROOT_THEMES_CORE . 'css/error.css" type="text/css" />';
        $html .= '</head>';

        # Body
        $html .= '<body>';

        # Fieldset with Legend
        $html .= '<fieldset id="top" class="error_red">';
        $html .= '<legend>Koch Framework Error</legend>';

        # Add Errorlogo
        $html .= '<div style="float: left; margin: 5px; margin-right: 25px; padding: 20px;">';
        $html .= '<img src="' . WWW_ROOT_THEMES_CORE . 'images/Clansuite-Toolbar-Icon-64-error.png" style="border: 2px groove #000000;"/></div>';

        # Open Error Table
        $html .= '<table width="80%"><tr><td>';

        # Panel 1 - Errormessage
        $html .= '<div id="panel1" class="panel">';
        $html .= '<h3>Error <span class="small">' . $errorname . ' (' . $errornumber . ')</span></h3>';
        $html .= '<h4>' . $errorstring . '<br/>in file "' . $errorfile . '"&nbsp;on line ' . $errorline.'.</h4>';
        $html .= '</div>';

        # Panel 2 - Error Context
        $html .= '<div id="panel2" class="panel">';
        $html .= '<h3>Context</h3>';
        $html .= '<span class="small">You are viewing the source code of the file "' . $errorfile . '" around line ' . $errorline . '.</span><br/><br/>';
        $html .= self::getErrorContext($errorfile, $errorline, 8) . '</div>';

        # Panel 3 - Debug Backtracing
        $html .= self::getDebugBacktrace($short_errorstring);

        # Panel 4 - Environmental Informations at Errortime
        $html .= '<div id="panel4" class="panel">';
        $html .= '<h3>Server Environment</h3>';
        $html .= '<table width="95%">';
        $html .= '<tr><td colspan="2"></td></tr>';
        $html .= '<tr><td><strong>Date: </strong></td><td>' . date('r') . '</td></tr>';
        $html .= '<tr><td><strong>Remote: </strong></td><td>' . $_SERVER['REMOTE_ADDR'] . '</td></tr>';
        $html .= '<tr><td><strong>Request: </strong></td><td>' . htmlentities($_SERVER['QUERY_STRING'], ENT_QUOTES) . '</td></tr>';
        $html .= '<tr><td><strong>PHP: </strong></td><td>' . PHP_VERSION . ' ' . PHP_EXTRA_VERSION . '</td></tr>';
        $html .= '<tr><td><strong>Server: </strong></td><td>' . $_SERVER['SERVER_SOFTWARE'] . '</td></tr>';
        $html .= '<tr><td><strong>Agent: </strong></td><td>' . $_SERVER['HTTP_USER_AGENT'] . '</td></tr>';
        $html .= '<tr><td><strong>Clansuite: </strong></td><td>' . CLANSUITE_VERSION . ' ' . CLANSUITE_VERSION_STATE;
        $html .= ' (' . CLANSUITE_VERSION_NAME . ') [Revision #' . CLANSUITE_REVISION . ']</td></tr>';
        $html .= '</table></div>';

        # Panel 5 - Backlink to Bugtracker with Errormessage -> http://trac.clansuite.com/newticket
        $html .= self::getBugtrackerBacklinks($errorstring, $errorfile, $errorline, $errorcontext);

        # Close Error Table
        $html .= '</table>';

        # Add Footer with Support-Backlinks
        $html .= self::getSupportBacklinks();

        # Close all html elements
        $html .= '</fieldset><br /><br />';
        $html .= '</body></html>';

        return $html;
    }

    /**
     * getDebugBacktrace
     *
     * Transforms the output of php's  debug_backtrace() to a more readable html format.
     *
     * @return string $backtrace_string contains the backtrace
     */
    public static function getDebugBacktrace($trace = null)
    {
        # provide backtrace only when we are in Koch Framework DEBUG Mode, otherwise just return
        if ( defined('DEBUG') == false xor DEBUG == 0 ) {
            return;
        }

        # if a trace is incoming, then this trace comes from an exception
        if (isset($trace) === false) {
            # else (normally) the errorhandler has to fetch the backtrace
            $trace = debug_backtrace();

            /**
             * Now we get rid of several last calls in the backtrace stack
             * to get nearer to the relevant error position in the stack.
             *
             * What exactly happens is: we shift-off the last 3 calls to
             * 1) getDebugBacktrace()   [this method itself]
             * 2) yellowScreenOfDeath() [our exception and error display method]
             * 3) trigger_error()       [php core function call]
             */
            $trace = array_slice($trace, 3);
        }

        /**
         * Assemble the html for the backtrace panel
         */
        $html = '';
        $html .= '<div id="panel3" class="panel"><h3>Backtrace</h3>';
        $html .= '<table class="cs-backtrace-table" width="95%">';

        # table row 1 - header
        $html .= '<tr><th width="2%">Callstack</th><th>Function (recent function calls last)</th><th width="46%">Location</th></tr>';

        $backtraces_count = count($trace)-1;

        for ($i = 0; $i <= $backtraces_count; $i++) {
            $html .= '<tr>';

            # Position in the Callstack
            $html .= '<td align="center">'.(($backtraces_count-$i)+1).'</td>';

            if (isset($trace[$i]['class']) === false) {
                $html .= '<td>[PHP Core Function called]</td>';
            } else {
                # Function (Class::Method)
                $html .= '<td>' . $trace[$i]['class'] . '::' . $trace[$i]['function'] . '(';

                # Method Arguments
                if (true === isset($trace[$i]['args']) and empty($trace[$i]['args']) === false) {
                    $backtrace_counter_j = count($trace[$i]['args']) - 1;

                    for ($j = 0; $j <= $backtrace_counter_j; $j++) {
                        $html .= self::formatBacktraceArgument($trace[$i]['args'][$j]);

                        # if we have several arguments to loop over
                        if ($j !== $backtrace_counter_j) {
                            # we split them by comma
                            $html .= ', ';
                        }
                    }
                }

                $html .= ')</td>';
            }

            # Location with Link
            if (true === isset($trace[$i]['file'])) {
                $html .= '<td>' . self::getFileLink($trace[$i]['file'], $trace[$i]['line']) . '</td>';
            }

            $html .= '</tr>';
        }

        $html .= '</table></div>';

        return $html;
    }

    /**
     * formatBacktraceArgument
     *
     * Performs a type check on the backtrace argument and beautifies it.
     *
     * This formater is based on comments for debug-backtrace in the php manual
     * @link http://de2.php.net/manual/en/function.debug-backtrace.php#30296
     * @link http://de2.php.net/manual/en/function.debug-backtrace.php#47644
     *
     * @param backtraceArgument mixed The argument to identify the type upon and perform a string formatting on.
     *
     * @return string
     */
    public static function formatBacktraceArgument($backtraceArgument)
    {
        $args = '';

        switch (gettype($backtraceArgument)) {
            case 'boolean':
                $args .= '<span>bool</span> ';
                $args .= $backtraceArgument ? 'TRUE' : 'FALSE';
                break;
            case 'integer':
                $args .= '<span>int</span> ' . $backtraceArgument;
                break;
            case 'float':
                $args .= '<span>float</span> ' . $backtraceArgument;
                break;
            case 'double':
                $args .= '<span>double</span> ' . $backtraceArgument;
                break;
            case 'string':
                $args .= '<span>string</span> "';
                $args .= self::shortenStringMaxLength($backtraceArgument, 64, '..."');
                break;
            case 'array':
                $args .= '<span>array</span> ('.count($backtraceArgument).')';
                break;
            case 'object':
                $args .= '<span>object</span> ('.get_class($backtraceArgument).')';
                break;
            case 'resource':
                $args .= '<span>resource</span> ('.mb_strstr($backtraceArgument, '#').' - '. get_resource_type($backtraceArgument) .')';
                break;
            case 'NULL':
                $args .= '<span>null</span> ';
                break;
            default:
                $args .= 'Unknown';
        }

        return $args;
    }

    /**
     * getErrorContext displayes some additional lines of sourcecode around the line with error.
     *
     * This is based on a code-snippet posted on the php manual website by
     * @author dynamicflurry [at] gmail dot com
     * @link http://us3.php.net/manual/en/function.highlight-file.php#92697
     *
     * @param string $file  file with the error in it
     * @param int    $scope the context scope (defining how many lines surrounding the error are displayed)
     * @param int    $line  the line with the error in it
     *
     * @return string sourcecode of file
     */
    public static function getErrorContext($file, $line, $scope)
    {
        # ensure error context is only shown, when in debug mode
        if (defined('DEVELOPMENT') and DEVELOPMENT == 1  and defined('DEBUG') and DEBUG == 1) {
            # ensure that sourcefile is readable
            if (true === is_readable($file)) {
                # Scope Calculations
                $surrounding_lines          = round($scope/2);
                $errorcontext_starting_line = $line - $surrounding_lines;
                $errorcontext_ending_line   = $line + $surrounding_lines;

                # create linenumbers array
                $lines_array = range($errorcontext_starting_line, $errorcontext_ending_line);

                # colourize the errorous linenumber red
                $lines_array[$surrounding_lines] = '<span class="error-line">'.$lines_array[$surrounding_lines].'</span>';
                $lines_array[$surrounding_lines] .= '<span class="error-triangle">&#9654;</span>';

                # transform linenumbers array to string for later display, use spaces as separator
                $lines_html = implode($lines_array, ' ');

                # get ALL LINES syntax highlighted source-code of the file and explode it into an array
                $array_content = explode('<br />', highlight_file($file, true));

                # get the ERROR SURROUNDING LINES from ALL LINES
                $array_content_sliced = array_slice($array_content, $errorcontext_starting_line-1, $scope, true);

                $result = array_values($array_content_sliced);

                # now colourize the background of the errorous line RED
                #$result[$surrounding_lines] = '<span style="background-color:#BF0000;">'. $result[$surrounding_lines] .'</span>';

                /**
                 * transform the array into html string
                 * enhance readablility by imploding the array with spaces (formerly <br>; when inside <code>)
                 */
                $errorcontext_lines  = implode($result, ' ');

                $sprintf_html = '<table>
                                    <tr>
                                        <td class="num">'.CR.'%s'.CR.'</td>
                                        <td><pre>'.CR.'%s'.CR.'</pre></td>
                                    </tr>
                                </table>';

                # @todo consider using wordwrap() to limit too long source code lines?

                return sprintf($sprintf_html, $lines_html, $errorcontext_lines);
            }
        }
    }

    /**
     * Returns the Clansuite Support Backlinks as HTML string.
     *
     * @return string Clansuite Support Backlinks as HTML.
     */
    public static function getSupportBacklinks()
    {
        $html  = '<div id="support-backlinks" style="padding-top: 45px; float:right;">';
        $html  .= '<!-- Live Support JavaScript -->
                   <a class="btn" href="http://support.clansuite.com/chat.php" target="_blank">Contact Support (Start Chat)</a>
                   <!-- Live Support JavaScript -->';
        $html  .= '<a class="btn" href="http://trac.clansuite.com/newticket/">Bug-Report</a>
                   <a class="btn" href="http://forum.clansuite.com/">Support-Forum</a>
                   <a class="btn" href="http://docs.clansuite.com/">Manuals</a>
                   <a class="btn" href="http://clansuite.com/">visit clansuite.com</a>
                   <a class="btn" href="#top"> &#9650; Top </a>
                   </div>';

        return $html;
    }

    /**
     * Returns a link to the file:line with the error.
     *
     * a) returns a link in the xdebug file_link_format, e.h. opens your IDE
     * b) returns a link in clansuite format, e.g. opens editor module
     * c) returns NO link, just file:line
     *
     * @return string Link to file and line with error.
     */
    public static function getFileLink($file, $line)
    {
        $html = '';
        $fileLinkFormatString = '';
        $link = '';

        /***
         * a) "xdebug.file_link_format"
         *
         * This uses the file "xdebug.file_link_format" php.ini configuration directive,
         * which defines a link template (sprintf) for calling your Editor/IDE.
         */
        $fileLinkFormatString = ini_get('xdebug.file_link_format');

        if ($fileLinkFormatString != '') {
            # insert file:line into the fileLinkFormatString
            $link = strtr($fileLinkFormatString, array('%f' => $file, '%l' => $line));

            # shorten file string by removing the root path
            $file = str_replace(ROOT, '..' . DIRECTORY_SEPARATOR, $file);

            # build an edit link and insert the link
            $html .= sprintf(' in <a href="%s" title="Edit file">%s line %s</a>', $link, $file, $line);
        }
        /*elseif(DEVELOPMENT)
        {
            # link to our editor
            $fileLinkFormatString = 'index.php?module=editor&action=edit&file=%f&line=%l';

            # insert file:line into the fileLinkFormatString
            $link = strtr($fileLinkFormatString, array('%f' => $file, '%l' => $line));
            $html .= sprintf(' in <a href="%s" title="Edit file">%s line %s</a>', $link, $file, $line);
        }*/
        else {
            # shorten file string by removing the root path
            $file = str_replace(ROOT, '..' . DIRECTORY_SEPARATOR, $file);

            $html .= sprintf(' in %s line %s', $file, $line);
        }

        return $html;
    }

    /**
     * Adds a link to our bugtracker, for creating a new ticket with the errormessage
     *
     * @param  string $errorstring the errormessage
     * @return string html-representation of the bugtracker links
     */
    public static function getBugtrackerBacklinks($errorstring, $errorfile, $errorline, $errorcontext)
    {
        $message1 = '<div id="panel5" class="panel"><h3>' . 'Found a bug in Clansuite?' . '</h3>';
        $message2 = 'If you think this should work and you can reproduce the problem, please consider creating a bug report.';
        $message3 = 'Before creating a new bug report, please first try searching for similar issues, as it is quite likely that this problem has been reported before.';
        $message4 = 'Otherwise, please create a new bug report describing the problem and explain how to reproduce it.';

        $search_link = NL . NL . '<a class="btn" target="_blank" href="http://trac.clansuite.com/search?q=' . htmlentities($errorstring, ENT_QUOTES) . '&noquickjump=1&ticket=on">';
        $search_link .= '&#9658; Search for similar issue';
        $search_link .= '</a>';

        $newticket_link = '&nbsp;<a class="btn" target="_blank" href="'.self::getTracNewTicketURL($errorstring, $errorfile, $errorline).'">';
        $newticket_link .= '&#9658; Create new ticket';
        $newticket_link .= '</a>';

        return $message1 . $message2 . NL . $message3 . NL . $message4 . $search_link . $newticket_link . '</div>' . NL;
    }

    /**
     * Returns a New Ticket URL for a GET Request
     *
     * urlencode($errorstring);
     * urlencode($this->excetpion->getMessage(). chr(10));
     */
    public static function getTracNewTicketURL($summary, $errorfile, $errorline)
    {
        /**
         * This is the error description.
         * It's written in trac wiki formating style.
         *
         * @link http://trac.clansuite.com/wiki/WikiFormatting
         */
        $description = '[Error] ' . $summary . ' [[BR]] [File] ' . $errorfile . ' [[BR]] [Line] ' . $errorline;

        # options array for http_build_query
        $array = array(
            'summary'     => $summary,
            'description' => $description,
            'type'        => 'defect-bug',
            'milestone'   => 'Triage-Neuzuteilung',
            'version'     => CLANSUITE_VERSION,
            #'component'   => '',
            'author'      => isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : '',
        );

        return 'http://trac.clansuite.com/newticket/?' . http_build_query($array);
    }

    public static function shortenStringMaxLength($string, $maxlength = 50, $append_string = null)
    {
        # already way too short...
        if (mb_strlen($string) < $maxlength) {
            return;
        }

        # ok, lets shorten
        if (mb_strlen($string) > $maxlength) {
            /**
             * do not short the string, when maxlength would split a word!
             * that would make things unreadable.
             * so search for the next space after the requested maxlength.
             */
            $next_space_after_maxlength = mb_strpos($string, ' ', $maxlength);

            $shortened_string = mb_substr($string, 0, $next_space_after_maxlength) . ' ...';

            return $shortened_string . $append_string;
        }
    }
}