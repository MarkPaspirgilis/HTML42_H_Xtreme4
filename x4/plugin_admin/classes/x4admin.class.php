<?php

class X4Admin {

    public static function _admin_table_html($object, $filter = null, $first_row_is_head = false) {
        $html = '';
        if (is_object($object)) {
            $object = Utilities::ensure_array($object);
        }
        if (empty($object)) {
            $html = '<div class="">Object empty - can\'t render Table</div>';
        } else {
            if($first_row_is_head) {
                $head_row = reset($object);
                $object_amount = count($object);
                array_splice($object, 0, 1 - $object_amount);
            } else {
                $head_row = array();
                foreach (reset($object) as $key => $value) {
                    array_push($head_row, $key);
                }
            }
            $thead = '<thead>';
            $thead .= '<tr>';
            foreach ($head_row as $rowcaption) {
                $thead .= '<td>' . $rowcaption . '</td>';
            }
            $thead .= '</tr>';
            $thead .= '</thead>';
            //
            $tbody = '<tbody>';
            foreach ($object as $row) {
                if(isset($filter) && is_callable($filter) && !call_user_func($filter, $row)) {
                    continue;
                }
                $tbody .= '<tr>';
                foreach ($row as $key => $value) {
                    if (is_array($value) || is_object($value)) {
                        $tbody .= '<td class="nopaddingcell">' . self::_admin_table_html(array($value)) . '</td>';
                    } else {
                        $tbody .= '<td>' . $value . '</td>';
                    }
                }
                $tbody .= '</tr>';
            }
            $tbody .= '</tbody>';
            //
            $html = '<table class="admintable">' . $thead . $tbody . '</table>';
        }
        return '<div class="admintable_wrap">' . $html . '</div>';
    }

}
