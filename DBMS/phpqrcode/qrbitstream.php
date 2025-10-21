<?php
class QRbitstream {
    public $data = array();
    
    public function append(QRbitstream $arg) {
        if (is_null($arg)) {
            return -1;
        }
        
        if($arg->size() == 0) {
            return 0;
        }
        
        if($this->size() == 0) {
            $this->data = $arg->data;
            return 0;
        }
        
        $this->data = array_merge($this->data, $arg->data);
        return 0;
    }
    
    public function size() {
        return count($this->data);
    }
}
