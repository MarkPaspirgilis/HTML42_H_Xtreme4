<!DOCTYPE html>
<html>
    <head>
        <title>Website</title>
        <meta charset="<?= X4::$config['encoding'] ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link media="all" href="preview.css" rel="stylesheet" />
    </head>
    <body id="body">
        <div id="page">
            <?= File::instance('templates/header.php')->get_content() ?>
            <main>
                <article>#yield#</article>
            </main>
            <footer></footer>
        </div>
        <script>
            setTimeout(function () {
                var style = document.createElement('link');
                style.href = 'styles.css';
                style.media = 'all';
                style.rel = 'stylesheet';
                document.head.appendChild(style);
            }, 0);
        </script>
        <script src="script.js" async defer></script>
        <script src="jquery.js" async defer></script>
    </body>
</html>
