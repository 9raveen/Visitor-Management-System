<?php
class QRsplit {
    public static function splitString($string, $hint) {
        if($hint != QR_MODE_8 && $hint != QR_MODE_KANJI) {
            return array($hint, $string);
        }
        return array(QR_MODE_8, $string);
    }
}
