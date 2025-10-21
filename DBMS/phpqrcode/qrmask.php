<?php
class QRmask {
    public $runLength = array();
    
    public function __construct() {
        $this->runLength = array_fill(0, QR_SPEC_WIDTH_MAX + 1, 0);
    }
    
    public function writeFormatInformation($width, &$frame, $mask, $level) {
        $blacks = 0;
        $format =  QRspec::getFormatInfo($mask, $level);

        for($i=0; $i<8; $i++) {
            if($format & 1) {
                $blacks += 2;
                $v = 0x85;
            } else {
                $v = 0x84;
            }
            
            $frame[8][$width-1-$i] = chr($v);
            if($i < 6) {
                $frame[$i][8] = chr($v);
            } else {
                $frame[$i+1][8] = chr($v);
            }
            $format = $format >> 1;
        }
        
        for($i=0; $i<7; $i++) {
            if($format & 1) {
                $blacks += 2;
                $v = 0x85;
            } else {
                $v = 0x84;
            }
            
            $frame[$width-7+$i][8] = chr($v);
            if($i == 0) {
                $frame[8][7] = chr($v);
            } else {
                $frame[8][6-$i] = chr($v);
            }
            
            $format = $format >> 1;
        }

        return $blacks;    
    }
}
