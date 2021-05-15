<h1>X4Admin - Pages</h1>

<table cellpadding="5" border="1">
    <thead>
        <tr>
            <td>Path</td>
            <td>Type</td>
            <td>Config</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach (X4Pages::loop_pages_structure() as $page_path => $page_config) { ?>
            <?php
            $page_types = array('html', 'text', 'plain');
            $type = !isset($page_config['type']) ? 'html' : $page_config['type'];
            $is_page = in_array($type, $page_types);
            ?>
            <?php if ($is_page) { ?>
                <tr>
                    <td>
                        <?= (empty($page_path) ? '*EMPTY-PATH*' : $page_path) ?>
                    </td>
                    <td>
                        <?= $type ?>
                    </td>
                    <td style="font-size: 9px;">
                        <table>
                            <?php foreach ($page_config as $config_key => $config_value) { ?>
                                <tr>
                                    <td><?= $config_key ?></td>
                                    <td>
                                        <?php
                                        if (is_numeric($config_value) || is_string($config_value)) {
                                            echo $config_value;
                                        } else {
                                            var_dump($config_value);
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    <tbody>
</table>
