<?php

/**
 * Clansuite - just an eSports CMS
 * Jens-Andr� Koch � 2005 - onwards
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

/**
 * Clansuite_Reporter is an extended in-browser HtmlReporter for Simpletest.
 *
 * Features:
 * - paint passes as dots only
 * - paint passes with classname
 * - paint passes with message
 */
class Reporter extends HtmlReporter
{
    public function paintFail($message)
    {
        #parent::paintFail($message);
        print '<p><span class="fail">Fail</span>: ';
        $breadcrumb = $this->getTestList();
        print '<b>' . $breadcrumb['2'] . "-&gt;" . $breadcrumb['3'] . '()</b>';
        print "<br /> Reason : &raquo; $message &laquo; </p>\n";
    }

    public function paintPass($message)
    {
        #$this->paintPass_DotsOnly($message);
        #$this->paintPass_Message($message);
        $this->paintPass_Classname($message);
    }

    public function paintPass_Message($message)
    {
        parent::paintPass($message);
        print "<span class=\"pass\">Pass</span>: ";
        $breadcrumb = $this->getTestList();
        array_shift($breadcrumb);
        print implode("-&gt;", $breadcrumb);
        print "->$message<br /><br />\n";
    }

    public function paintPass_DotsOnly($message)
    {
       #parent::paintPass($message);
        $breadcrumb = $this->getTestList();
        array_shift($breadcrumb);
        $testsubject_classname = $breadcrumb['1'] . '-&gt;' . $breadcrumb['2']; // combine classname + methodname
        $dot = '<span class="pass">.</span>';
        print '<a href="#hint" class="tooltip" title="' .$testsubject_classname. '">' . $dot . '</a>';
    }

    public function paintPass_Classname($message)
    {
        parent::paintPass($message);
        $breadcrumb = $this->getTestList();
        array_shift($breadcrumb);
        $testsubject_classname = $breadcrumb['1'] . '-&gt;' . $breadcrumb['2'] . '()'; // combine classname + methodname
        echo '<span class="pass">'.$testsubject_classname.'</span><br />';
    }

    /**
     * Paints a PHP error.
     * @param string $message Message is ignored.
     */
    public function paintError($message)
    {
        // Explicitly call grandparent, not HtmlReporter::paintError.
        SimpleScorer::paintError($message);
        print "<span class=\"fail\">Exception</span>: <br />\n";
        $breadcrumb = $this->getTestList();
        array_shift($breadcrumb);
        print implode(" -&gt; ", $breadcrumb);
        print "<br />\n<strong>" . $this->htmlEntities($message) . "</strong><br />\n";
        print "<pre>\n";
    }

    public function getCss()
    {
        echo 'body { font:14px Consolas; }
              a.tooltip {text-decoration:none;}'
             . parent::getCss() .
             ' .pass { color: green; }
               .fail { font-weight: bold; }';
    }

}
