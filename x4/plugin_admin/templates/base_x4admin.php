<!DOCTYPE html>
<html>
    <head>
        <title>X4 Administration</title>
        <meta charset="<?= X4::$config['encoding'] ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link media="all" href="../styles.css" rel="stylesheet" />
    </head>
    <body id="body">
        <div id="page">
            <?= File::instance('templates/header.php')->get_content() ?>
            <main>
                <aside>
                    <ul>
                        <?php foreach ($GLOBALS['admin_navi'] as $url => $name) { ?>
                            <li>
                                <a href="<?= $url ?>"><?= $name ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </aside>
                <article>#yield#</article>
            </main>
            <footer></footer>
        </div>
        <script src="../x4admin_script.js" async defer></script>
        <script src="../jquery.js" async defer></script>
    </body>
</html>
