<?php 
    class JWTOKEN {
        public $key = '';
        function CreateToken($array) {
            $times = json_encode(['type' => 'jwtoken', 'time' => $array['time']]);
            $Base64UrlTime = str_replace(['+', '/', '='], ['-', '-', ''], base64_encode($times));
            $this->key = $array['keys'];
            $info = json_encode(['id' => $array['info']['id'], 'username' => $array['info']['username']]);
            $Base64UrlInfo = str_replace(['+', '/', '='], ['-', '-', ''], base64_encode($info));
            $hash = hash_hmac('sha256', $Base64UrlTime.'.'.$Base64UrlInfo, $this->key, false);
            $jwtoken = $Base64UrlTime.'.'.$Base64UrlInfo.'.'.$hash;
            return $jwtoken;
        }

        function decodeToken($token, $keys) {
            $array = explode('.', $token);
            $times = $array[0];
            $userID = $array[1];
            $hash = $array[2];
            if (hash_equals(hash_hmac('sha256', $times.'.'.$userID, $keys, false), $hash) ){
                $decodeBase64Time = base64_decode($times, true);
                $decodeJS = json_decode($decodeBase64Time, true);
                if ($decodeJS['type'] == 'jwtoken' && $decodeJS['time'] >= time()) {
                    $id = base64_decode($userID);
                    return json_decode($id, true);
                } else {
                    return 0;
                }
                
            }   
            return $array;
        }
    }
?>