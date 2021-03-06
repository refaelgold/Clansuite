<?php

/**
 * php-cs-fixer - configuration file
 */

use Symfony\CS\FixerInterface;

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->ignoreVCS(true)
    ->notName('.php_cs')
    ->notName('php-cs-fixer.report.txt')
    ->notName('composer.*')
    ->notName('*.phar')
    ->notName('*.ico')
    ->notName('*.ttf')
    ->notName('*.gif')
    ->notName('*.swf')
    ->notName('*.jpg')
    ->notName('*.png')
    ->notName('*.exe')
    ->notName('step6.php') // this file contains javascript which is also modified by fixer (BUG!)
    ->notName('*classmap.php')
    ->notName('code-coverage-settings.dat') // SimpleTest CodeCoverage files
    ->notName('coverage.sqlite')
    ->notName('Utf8FallbackFunctions.php') // bug in php-cs-fixer, adds "public" to global functions
    ->exclude('img')
    ->exclude('cache')
    ->exclude('Cache')
    ->exclude('images')
    ->exclude('ckeditor')
    ->exclude('simpletest')
    ->exclude('tests\coverage-report')
    ->exclude('vendor')
    ->exclude('libraries')
    ->exclude('Libraries')
    ->exclude('nbproject') // netbeans project files
    ->in(__DIR__)
;

return Symfony\CS\Config\Config::create()
    ->finder($finder)
;