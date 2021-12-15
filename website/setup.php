<?php

$dir = str_replace(DIRECTORY_SEPARATOR, '/', __DIR__) . '/';

foreach (array(
'dist', 'classes', 'functions', 'less', 'views', 'templates',
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
    'less/preview.less' => '',
    'files/.gitkeep' => '',
    'views/index/index.html' => '<h1>Example-Index</h1>',
    'environment' => 'dev',
    'templates/base.php' => lc_base(),
    'templates/header.php' => lc_templates_header(),
    'templates/footer.php' => lc_templates_footer(),
    'texts.ini' => lc_texts(),
    'translations.ini' => lc_translations(),
);
foreach ($basic_files as $filepath => $filecontent) {
    if (!is_file($dir . $filepath)) {
        file_put_contents($dir . $filepath, $filecontent);
    }
}






#LOOOONG Contents

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
    "index": {},
    
    "styles.css": {
        "type": "less",
        "files": [
            "less/variables.less",
            "less/mixins.less",
            "less/basics.less"
        ]
    },
    "preview.css": {
        "type": "less",
        "files": [
            "less/variables.less",
            "less/mixins.less",
            "less/basics.less",
            "less/preview.less"
        ]
    },
    
    "jquery.js": {
        "type": "javascript",
        "files": [
            "js/jquery.js",
            "js/jquery-ui.js",
            "js/jquery-touch-punch.js",
            "js/jquery-xtreme.js"
        ]
    },
    "script.js": {
        "type": "javascript",
        "files": [
            "js/xtreme.js"
        ]
    }
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

function lc_texts() {
    return '[base]
app[name] = "Website"
';
}

function lc_translations() {
    return '[de]

[en]

';
}

function lc_base() {
    return '<!DOCTYPE html>
<html>
    <head>
        <title>Website</title>
        <meta charset="<?= X4::$config[\'encoding\'] ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link media="all" href="<?= ASSET_PREFIX ?>preview.css" rel="stylesheet" />
        <link media="none" href="<?= ASSET_PREFIX ?>styles.css" rel="stylesheet" onload="media = \'all\'" />
    </head>
    <body id="body">
        <div id="page">
            <?= File::instance(\'templates/header.php\')->get_content() ?>
            <main>
                <article>#yield#</article>
            </main>
            <?= File::instance(\'templates/footer.php\')->get_content() ?>
        </div>
        <script src="script.js" async defer></script>
        <script src="jquery.js" async defer></script>
    </body>
</html>
';
}

function lc_templates_header() {
    return '<header>
    <div class="logo">Company</div>
    <nav>
        <ul>
            <?php
            $nav = array(
                \'index/index\' => \'Home\',
            );
            foreach ($nav as $nav_url => $nav_content) {
                echo \'<li>\';
                echo \'<a href="\' . ASSET_PREFIX . $nav_url . \'">\';
                echo $nav_content;
                echo \'</a>\';
                echo \'</li>\';
            }
            ?>
        </ul>
    </nav>
</header>';
}

function lc_templates_footer() {
    return '<footer>
    <div class="center_wrap">
        <div id="footer_navigation">
            <nav>
                <ul>
                    <?php
                    $navigation = array(
                        \'index/index\' => \'Home\',
                    );
                    foreach ($navigation as $link_href => $link_text) {
                        echo \'<li>\';
                        echo \'<a \';
                        echo \' href="\' . ASSET_PREFIX . $link_href . \'"\';
                        echo \'>\' . $link_text . \'</a>\';
                        echo \'</li>\';
                    }
                    ?>
                </ul>
            </nav>
        </div>
        <div class="copyright">
            copyright Company &copy; 2021
        </div>
    </div>
</footer>
';
}
