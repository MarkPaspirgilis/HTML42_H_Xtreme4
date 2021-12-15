<!DOCTYPE html>
<html>
    <head>
        <title>Mein Title</title>
        <link rel="dns-prefetch" href="//<?= $_SERVER['SERVER_NAME'] ?>" />
        <link rel="shortcut icon" type="image/x-icon" href="<?= ASSET_PREFIX ?>images/favicon.png">
        <meta charset="<?= X4::$config['encoding'] ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link media="all" href="<?= ASSET_PREFIX ?>styles.css"  rel="stylesheet" />
    </head>
    <body id="body">
        <div id="page" data-url="<?= Request::$requested_clean_path ?>">
            <?= File::instance('templates/header.php')->get_content() ?>
            <main>
                <div class="center_wrap">
                    <article>#yield#</article>
                </div>
            </main>
            <?= File::instance('templates/footer.php')->get_content() ?>
        </div>
        <script src="<?= ASSET_PREFIX ?>script.js" async defer></script>
        <script src="<?= ASSET_PREFIX ?>jquery.js" async defer></script>
    </body>
</html>
