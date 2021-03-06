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

// setup env(error/date/paths)
require_once 'bootstrap.php';

/**
 * Setup Simpletest
 */
require_once 'simpletest/unit_tester.php';
require_once 'simpletest/test_case.php';
require_once 'simpletest/reporter.php';
require_once 'simpletest/web_tester.php';

// hmm, we need to load this, to get rid of the "No runnable test cases in runAlltest" error
#require_once 'simpletest/autorun.php';

/**
 * Setup our Testsuite and Reporter
 */
require_once 'reporter.php';
require_once 'testsuite.php';
require_once 'unittester.php';

// start CodeCoverage
if (PERFORM_CODECOVERAGE == true) {
    require_once 'codecoverage.php';
    Clansuite_CodeCoverage::start();
}

// Tests -> instantiate Clansuite Testsuite
$testsuite = new ClansuiteTestsuite();
$success = false;

// Tests -> determine, if we are in commandline mode, then output pure text
if (TextReporter::inCli()) {

    // fetch reporter
    #require_once 'simpletest/extensions/colortext_reporter.php';
    require_once 'simpletest/extensions/junit_xml_reporter.php';
    ob_start();
    #$reporter = new TextReporter();
    #$reporter = new ColorTextReporter();
    $reporter = new JUnitXmlReporter();

    // hand reporter to the testsuite and run it
    $success = $testsuite->run($reporter);

    // write test results to xml file
    file_put_contents(__DIR__ . '/test-results.xml', ob_get_contents());
    ob_end_clean();

    // do not let the tests fail, the fail status is evaluated via xml file
    $success = true;
} else {
    // display nice html report
    $success = $testsuite->run(new Reporter);
}

// stop CodeCoverage
if (PERFORM_CODECOVERAGE == true) {
    Clansuite_CodeCoverage::stop();
    Clansuite_CodeCoverage::getReport();
}

// Tests -> exit with status
if (false === $success) {
    // Exit with error code to let the build fail, when the test is unsuccessfull.
    exit(1);
}
