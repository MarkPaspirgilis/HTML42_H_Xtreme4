<?php

class CitypluginAPI {

    public static function request($endpoint, $data = null) {
        $response = null;
        if (CitypluginCore::$internal) {
            $request_data = array(
                'endpoint' => trim($endpoint),
                'data' => $data,
                'key' => CitypluginCore::$key,
                'secret' => CitypluginCore::$secret,
            );
            $request_data_hashed = base64_encode(json_encode($request_data));
            $command = 'php ' . CitypluginCore::$internal_dir . 'execute.php ' . $request_data_hashed;
            $response = shell_exec($command);
            if ($response && is_string($response) && !empty($response)) {
                $response = @json_decode($response, true);
            }
        } else {
            debug('EXTERNAL API IN PROGRESS');
        }
        return $response;
    }

}
