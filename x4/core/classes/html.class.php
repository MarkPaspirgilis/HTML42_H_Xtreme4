<?php

class Html {

    public static function a($params) {
        $html = '<a';
        $config = array(
            'innerhtml' => '',
            'attr' => array(),
        );
        if (isset($params['link'])) {
            $config['href'] = BASEURL . $params['link'];
        }
        if (isset($params['innerhtml'])) {
            $config['innerhtml'] = $params['innerhtml'];
        }
        if (isset($params['innertext'])) {
            $config['innerhtml'] = trim(strip_tags($params['innertext']));
        }
        if(isset($config['href'])) {
            $config['attr']['href'] = $config['href'];
        }
        foreach ($config['attr'] as $key => $value) {
            $html .= ' ' . $key . '="' . $value . '"';
        }
        $html .= '>';
        $html .= $config['innerhtml'];
        $html .= '</a>';
        return $html;
    }

}
