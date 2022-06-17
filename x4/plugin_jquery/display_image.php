<?php

$File_image = File::instance_of_first_existing_file(File::_create_try_list(Request::$requested_clean_path));
if ($File_image->exists) {
    X4::$content = $File_image->get_content();
    X4::$mime = Utilities::mime_content_type_by_filename($File_image->path);
}

X4::plugins_event_close();

Response::deliver(X4::$content);
