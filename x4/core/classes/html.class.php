<?php

class Html {

    public static $link_hrefs = array();

    public static function a($params) {
        $html = '<a';
        $config = array(
            'href' => '',
            'innerhtml' => '',
            'attr' => array(),
        );
        if (isset($params['link'])) {
            $params['href'] = BASEURL . $params['link'];
        }
        if (isset($params['innerhtml'])) {
            $config['innerhtml'] = $params['innerhtml'];
        }
        if (isset($params['innertext'])) {
            $config['innerhtml'] = trim(strip_tags($params['innertext']));
        }
        if (isset($params['href'])) {
            $config['attr']['href'] = $params['href'];
        }
        if (isset($params['attr'])) {
            foreach ($params['attr'] as $key => $value) {
                $config['attr'][$key] = $value;
            }
        }
        foreach ($config['attr'] as $key => $value) {
            $html .= ' ' . $key . '="' . $value . '"';
        }
        if (isset($config['attr']['href']) && !empty($config['attr']['href'])) {
            array_push(self::$link_hrefs, $config['attr']['href']);
        }
        $html .= '>';
        $html .= $config['innerhtml'];
        $html .= '</a>';
        return $html;
    }

}
