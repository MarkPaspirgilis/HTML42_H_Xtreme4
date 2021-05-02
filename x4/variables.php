<?php

$project_filepath = str_replace(DIRECTORY_SEPARATOR, '/', $_SERVER['SCRIPT_FILENAME']);
$project_filename = @end(explode('/', $project_filepath));
$project_folderpath = str_replace($project_filename, '', $project_filepath);

define('DIR_ROOT', $project_folderpath);
define('DIR_X4', $dir);

define('DIR_CORE', DIR_X4 . 'core/');
define('DIR_CORE_CLASSES', DIR_CORE . 'classes/');
define('DIR_CORE_MODES', DIR_CORE . 'modes/');

define('DIR_VIEWS', DIR_ROOT . 'views/');

define('FILE_STRUCTURE', DIR_ROOT . 'structure.json');
define('FILE_ENVIRONMENT', DIR_ROOT . 'environment');


define('HOUR', 3600);
define('DAY', HOUR * 24);
define('WEEK', DAY * 7);


define('ENV', strtolower(trim(file_get_contents(FILE_ENVIRONMENT))));
