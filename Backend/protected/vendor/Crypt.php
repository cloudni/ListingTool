<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/3/16
 * Time: 15:20
 */

class Crypt {
    static function urlsafe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_','='),$data);
        return $data;
    }

    static function urlsafe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
}