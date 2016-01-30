<?php
    namespace Database;
    class Hash{

        public $message;
        private $length;

        public $H1 = 0x6a09e667f3bcc908;
        public $H2 = 0xbb67ae8584caa73b;
        public $H3 = 0x3c6ef372fe94f82b;
        public $H4 = 0xa54ff53a5f1d36f1;
        public $H5 = 0x510e527fade682d1;
        public $H6 = 0x9b05688c2b3e6c1f;
        public $H7 = 0x1f83d9abfb41bd6b;
        public $H8 = 0x5be0cd19137e2179;

        function __construct($message){
            $this->message = hexdec(unpack("H*", $message)[1]);

            $this->length = strlen(decbin($this->message));
        }

        function CH($x, $y, $z){
            return ($x & $y) ^ ((~$x) & $z);
        }

        function Maj($x, $y, $z){
            return ($x & $y) ^ ($x & $z) ^ ($y ^ $z);
        }

        function bigsigma0($x){
            return ($x >> 28) ^ ($x >> 34) ^ ($x >> 39);
        }

        function bigsigma1($x){
            return ($x >> 14) ^ ($x >> 18) ^ ($x >> 41);
        }

        function smallsigma0($x){
        }

        function rotateRight($x, $time){
            if($time !== 0){
                $tmp = 0x8000000000000000;
                $bin = $x & 1;
                $tmp *= $bin;
                $tmp = ($x >> 1) + $tmp;
                $x = $this->rotateRight($tmp, $time - 1);
            }
            return $x;
        }
    }