<?php
namespace App\Color;

class MinecraftColor {

    private static $array = [
        "&0" => "#000000",
        "&1" => "#0000AA",
        "&2" => "#00AA00",
        "&3" => "#00AAAA",
        "&4" => "#AA0000",
        "&5" => "#AA00AA",
        "&6" => "#FFAA00",
        "&7" => "#AAAAAA",
        "&8" => "#555555",
        "&9" => "#5555FF",
        "&a" => "#55FF55",
        "&b" => "#55FFFF",
        "&c" => "#FF5555",
        "&d" => "#FF55FF",
        "&e" => "#FFFF55",
        "&f" => "#FFFFFF"
    ];

    private static $none = [
        "&k", "&l", "&m", "&n", "&o", "&r",
    ];

    public static function color($text) {
        foreach(self::$array as $key => $value) {
            $str = str_replace($key, $value, $text);
            if($str !== $text) {
                return $value;
            }
        }

        return "";
    }

    public static function stripColor($text) {
        foreach(self::$array as $key => $value) {
            $text = str_replace($key, "", $text);
        }

        foreach(self::$none as $key) {
            $text = str_replace($key, "", $text);
        }

        return $text;
    }

}
