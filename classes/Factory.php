<?php
    class Factory{
        public static function createController( $request ){
            $result = null;
            if( $request[ 'action' ] == 'start' ){
                if( self::validInput( $request[ 'from' ], $request[ 'to' ] ) ){
                    $result = new ResultController( $request[ 'from' ], $request[ 'to' ] );
                }
                else{
                    $result = new DefaultController();                    
                }
            }
            else{
                $result = new DefaultController();
            }
            return $result;
        }
        private function validInput( $from, $to ){
            $result = false;
            if( ( trim( $from ) != '' ) && ( trim( $to ) != '' ) ){
                $result = true;
            }
            return $result;
        }
    }   
?>