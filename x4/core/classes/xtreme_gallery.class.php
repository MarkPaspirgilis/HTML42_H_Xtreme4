<?php

class XtremeGallery {

    public static function generate($items = array()) {
        $gallery = array();
        $items = Utilities::ensure_array($items);
        foreach($items as $item) {
            $gallery_item = array();
            if(isset($item['image'])) {
                $File_image = File::instance($item['image']);
                if($File_image->exists) {
                    $gallery_item['image'] = $File_image->path;
                    if(isset($item['name']) && !empty($item['name'])) {
                        $gallery_item['name'] = trim($item['name']);
                    }
                    if(isset($item['description']) && !empty($item['description'])) {
                        $gallery_item['description'] = trim($item['description']);
                    }
                }
            }
            if(!empty($gallery_item)) {
                array_push($gallery, $gallery_item);
            }
        }
        return '<div data-xtreme-gallery=\'' . json_encode($gallery) . '\'></div>';
    }
    
    public static function folder_images($folder) {
        $images = array();
        $folder_path = null;
        if(is_dir($folder)) {
            $folder_path = $folder;
        } else if(is_dir(DIR_ROOT . $folder)) {
            $folder_path = DIR_ROOT . $folder;
        }
        if($folder_path) {
            $folder_path = File::n($folder_path);
            foreach(File::ls($folder_path, true, true) as $image_path) {
                $rel_path = str_replace(DIR_ROOT, '', $image_path);
                array_push($images, array('image' => $rel_path));
            }
        }
        return $images;
    }

}
