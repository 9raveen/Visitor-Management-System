<?php
class QRinput {
    public $items;
    private $version;
    private $level;
    
    public function __construct($version = 0, $level = QR_ECLEVEL_L) {
        $this->version = $version;
        $this->level = $level;
    }
    
    public function getVersion() {
        return $this->version;
    }
    
    public function setVersion($version) {
        $this->version = $version;
    }
    
    public function appendString($data) {
        $this->items[] = $data;
    }
}
