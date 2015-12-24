<?php
    class Message
    {
        public $fileName = "";
        public $userName = "";
        public $userEmail = "";
        public $messageTitle = "";
        public $content = "";
        public $date = "";

        public function __construct($fileName, $userName, $userEmail, $messageTitle, $content, $date)
        {
            $this->setFileName($fileName);
            $this->setUserName($userName);
            $this->setUserEmail($userEmail);
            $this->setMessageTitle($messageTitle);
            $this->setContent($content);
            $this->setDate($date);
        }

        public static function from($path){

        }

        public function getFileName(){
            return $this->fileName;
        }

        public function setFileName($fileName){
            $this->fileName = $fileName;
        }

        public function getUserName(){
            return $this->userName;
        }

        public function setUserName($userName){
            $this->userName = $userName;
        }

        public function getUserEmail(){
            return $this->userEmail;
        }

        public function setUserEmail($userEmail){
            $this->userEmail = $userEmail;
        }

        public function getMessageTitle(){
            return $this->messageTitle;
        }

        public function setMessageTitle($messageTitle){
            $this->messageTitle = $messageTitle;
        }

        public function getContent(){
            return $this->content;
        }

        public function setContent($content){
            $this->content = $content;
        }

        public function getDate(){
            return $this->date;
        }

        public function setDate($date){
            $this->date = $date;
        }

        static public function analyze($path){
            $all_data = array();
            if($fh = fopen($path, 'r')){
                $data_str = "";
                $tmp = "";
                while (($tmp = fgets($fh)) != null) {
                    $data_str .= $tmp;
                }

                $all_data = json_decode($data_str, true);
                fclose($fh);
            };

            return $all_data;
        }

        static public function storeJSON($path, $JSON){
            if($fh = fopen($path, 'w')){
                fwrite($fh, json_encode($JSON));
                fclose($fh);
                return true;
            }else{
                return false;
            }
        }
    }
?>