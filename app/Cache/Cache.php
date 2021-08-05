<?php
namespace App\Cache;

class Cache {

    public static function getUsername($uuid) {
        if(file_exists(storage_path('app/uuid/'.$uuid.'.json'))) {
            $json = file_get_contents(storage_path('app/uuid/'.$uuid.'.json'));
            $json = json_decode($json, true);
            if((time() - strtotime($json['time'])) > 3600) {
                $json = file_get_contents('https://api.mojang.com/user/profiles/'.$uuid.'/names');
                if(empty($json)) {
                    $json = file_get_contents(storage_path('app/uuid/'.$uuid.'.json'));
                    $json = json_decode($json, true);
                    return $json['name'];
                }

                $json = json_decode($json, true);
                if(isset($json['error'])) {
                    $json = file_get_contents(storage_path('app/uuid/'.$uuid.'.json'));
                    $json = json_decode($json, true);
                    return $json['name'];
                }

                $name = $json[count($json) -1]['name'];
                $json = [];
                $json['id'] = $uuid;
                $json['name'] = $name;
                self::saveJson($json);
                return $json['name'];
            } else {
                return $json['name'];
            }
        } else {
            $json = file_get_contents('https://api.mojang.com/user/profiles/'.$uuid.'/names');
            if(empty($json))
                return $uuid;

            $json = json_decode($json, true);
            if(isset($json['error']))
                return $uuid;

            $name = $json[count($json) -1]['name'];
            $json = [];
            $json['id'] = $uuid;
            $json['name'] = $name;
            self::saveJson($json);
            return $json['name'];
        }
    }

    public static function getUUID($username) {
        foreach(glob(storage_path('app/uuid/*')) as $file) {
            $json = file_get_contents($file);
            $json = json_decode($json, true);
            if($json['name'] !== $username)
                continue;

            if((time() - strtotime($json['time'])) > 3600) {
                $json = file_get_contents('https://api.mojang.com/users/profiles/minecraft/'.$username);
                if(empty($json)) {
                    unlink(storage_path('app/uuid/'.$file));
                    return $username;
                }

                $json = json_decode($json, true);
                if(isset($json['error'])) {
                    unlink(storage_path('app/uuid/'.$file));
                    return $username;
                }

                self::saveJson($json);
                return $json['id'];
            } else {
                return $json['id'];
            }
        }

        $json = file_get_contents('https://api.mojang.com/users/profiles/minecraft/'.$username);
        if(empty($json))
            return $username;

        $json = json_decode($json, true);
        if(isset($json['error']))
            return $username;

        self::saveJson($json);
        return $json['id'];
    }

    public static function saveJson($json) {
        $array = [
            'id' => $json['id'],
            'name' => $json['name'],
            'time' => date('d-m-Y H:m:s')
        ];

        file_put_contents(storage_path('app/uuid/'.$json['id'].'.json'), json_encode($array));
    }

}
