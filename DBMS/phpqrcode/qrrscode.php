<?php
class QRrsCode {
    public static function init_rs($symsize, $gfpoly, $fcr, $prim, $nroots, $pad) {
        foreach(range(0, $symsize-1) as $i) {
            $gf_exp[$i] = 0;
        }
        
        $NN = $symsize-1;
        $gf_exp[$NN] = 0;
        
        return array($gf_exp, $NN);
    }
}
