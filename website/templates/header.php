<header>
    <div class="center_wrap">
        <?=
        Html::a(array(
            'link' => 'index/index',
            'innertext' => 'Meine Webseite',
            'attr' => array('class' => 'logo'),
        ))
        ?>
        <nav>
            <ul>
                <li class="nav_item_1">
                    <?= Html::a(array('link' => 'index/index', 'innertext' => 'Startseite', 'attr' => array('class' => 'index_link'))) ?>
                </li>
            </ul>
        </nav>
    </div>
</header>
