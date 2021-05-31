<h1>X4Admin - Pages</h1>
<div class="admintable_wrap">
    <table class="admintable">
        <thead>
            <tr>
                <td>Path</td>
                <td>Type</td>
                <td>Config</td>
                <td></td>
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
                        <td>
                            <?= X4Admin::_admin_table_html(array($page_config)) ?>
                        </td>
                        <td data-change-pageconfig="<?= $page_path ?>"></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        <tbody>
    </table>
</div>
