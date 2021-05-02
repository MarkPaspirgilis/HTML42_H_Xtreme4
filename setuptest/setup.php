<?php

$dir = str_replace(DIRECTORY_SEPARATOR, '/', __DIR__) . '/';

foreach (array(
'dist', 'classes', 'functions', 'views', 'templates',
 'views/index',
 'files',
) as $folder) {
    if (!is_dir($dir . $folder)) {
        mkdir($dir . $folder);
    }
}

#HTACCESS--File
if (!is_file($dir . '.htaccess')) {
    file_put_contents($dir . '.htaccess', lc_htaccess());
}

#execute.php
if (!is_file($dir . 'execute.php')) {
    $execute_content = lc_execute();
    file_put_contents($dir . 'execute.php', $execute_content);
}

#Structure JSON
if (!is_file($dir . 'structure.json')) {
    file_put_contents($dir . 'structure.json', lc_structure());
}

#Basic-Files
$basic_files = array(
    'classes/.gitkeep' => '',
    'functions/.gitkeep' => '',
    'files/.gitkeep' => '',
    'views/index/index.html' => '<h1>Example-Index</h1>',
    'environment' => 'dev',
    'templates/base.php' => lc_templates_base(),
);
foreach ($basic_files as $filepath => $filecontent) {
    if (!is_file($dir . $filepath)) {
        file_put_contents($dir . $filepath, $filecontent);
    }
}






#LOOOONG Contents

function lc_templates_base() {
    return '<!DOCTYPE html>
<html>
    <head>
        <title>Website</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body id="body">
        <div id="page">
            <header></header>
            <main></main>
            <footer></footer>
        </div>
    </body>
</html>';
}

function lc_execute() {
    return '<?php

$X4 = get_cfg_var(\'X4\');
if (!is_string($X4) || empty($X4))
    $X4 = ini_get(\'X4\');
if (!is_string($X4) || empty($X4))
    $X4 = null;
if (is_string($X4) && !empty($X4)) {
    $X4 = str_replace(\'\\\\\', \'/\', trim($X4));
    if (substr($X4, -1) != \'/\')
        $X4 .= \'/\';
}
#
if (is_dir($X4) && is_file($X4 . \'execute.php\') && is_file($X4 . \'version\')) {
    include $X4.\'execute.php\';
} else {
    echo \'500 - X4 not found\';
    die;
}
';
}

function lc_structure() {
    return '{
    "": {
        "redirect": "index",
        "status": 301
    },
    "index": {}
}';
}

function lc_htaccess() {
    return 'RewriteEngine On
RewriteCond %{REQUEST_URI} !^.*setup.php$
RewriteCond %{REQUEST_URI} !^.*dist.*$
RewriteRule ^.* execute.php [L]

<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE text/javascript
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/atom_xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
    AddOutputFilterByType DEFLATE application/x-shockwave-flash
</IfModule>';
}
