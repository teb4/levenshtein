<?php
    class Prescription{
        private $route;
        private $distance;
        public function __construct( $distance, $route ){
            $this->distance = $distance;
            $this->route = $route;
        }        
        public function getRoute(){
            return $this->route;
        }
        public function getDistance(){
            return $this->distance;
        }
    }    
?>