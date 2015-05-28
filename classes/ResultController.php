<?php
    require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/classes/Model.php';    
    class ResultController{
        private $from;
        private $to;
        private $logDataList;        
        public function __construct( $from, $to ){
            $this->from = $from;
            $this->to = $to;
            $this->logDataList = Model::getLogDataList( $from, $to );            
        }
        public function getView(){
            return new ResultView( $this->from, $this->to, $this->logDataList );
        }        
    }
?>