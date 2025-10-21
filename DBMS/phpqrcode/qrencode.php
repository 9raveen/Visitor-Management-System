<?php
class QRencode {
    public static function encode($string, $filename = false, $level = QR_ECLEVEL_L, $size = 3, $margin = 4) {
        $enc = new QRinput($level);
        $enc->appendString($string);
        
        $tab = $enc->encodeMask(-1);
        
        return QRimage::png($tab, $filename, $size, $margin);
    }
    
    public function encodeMask($mask) {
        $width = QRspec::getWidth($this->version);
        $frame = QRspec::newFrame($this->version);
        
        $this->width = $width;
        $this->frame = $frame;
        
        return $this->frame;
    }
}
