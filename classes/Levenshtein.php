<?php
    class Levenshtein{
        private $m;
        private $n;
        private $D;
        private $P;
        private $prescription;
        public function __construct( $S1, $S2 ){
            $this->m = mb_strlen( $S1, 'UTF-8' );           
            $this->n = mb_strlen( $S2, 'UTF-8' );               
            
            $this->D = array();
            $this->P = array();

            $this->setBaseValue();
            $this->generateMatrix( $S1, $S2 );
            $this->prescription = $this->generatePrescription();
        }
        public function getPrescription(){
            return $this->prescription;
        }
        private function setBaseValue(){
            // Базовые значения
            for( $i = 0; $i <= $this->m; $i++ ){
                $this->D[ $i ][ 0 ] = $i;
                $this->P[ $i ][ 0 ] = 'D';
            }

            for( $i = 0; $i <= $this->n; $i++ ){
                $this->D[ 0 ][ $i ] = $i;
                $this->P[ 0 ][ $i ] = 'I';
            }            
        }
        private function generateMatrix( $S1, $S2 ){
            for( $i = 1; $i <= $this->m; $i++ ){                
                for( $j = 1; $j <= $this->n; $j++ ){  
                    $cost = $a = $b = $c = 0;
                    $this->get( $cost, $a, $b, $c, $S1, $S2, $i, $j );
                    if( $a < $b && $a < $c ){    
                        $this->insert( $i, $j, $a );
                    }
                    else if( $b < $c ){
                        $this->delete( $i, $j, $b );
                    }
                    else{
                        $this->replaceOrMatch( $i, $j, $cost, $c );
                    }
                }
            }            
        }
        private function get( &$cost, &$a, &$b, &$c, $S1, $S2, $i, $j ){
            $prev_i = $i - 1;
            $prev_j = $j - 1;
            $cost = $this->getCost( $S1, $S2, $prev_i, $prev_j );
            $a = $this->D[ $i ][ $prev_j ];
            $b = $this->D[ $prev_i ][ $j ];
            $c = $this->D[ $prev_i ][ $prev_j ] + $cost;            
        }
        private function insert( $i, $j, $a ){
            $this->D[ $i ][ $j ] = $a + 1;
            $this->P[ $i ][ $j ] = 'I';            
        }
        private function delete( $i, $j, $b ){
            $this->D[ $i ][ $j ] = $b + 1;
            $this->P[ $i ][ $j ] = 'D';            
        }
        private function replaceOrMatch( $i, $j, $cost, $c ){
            $this->D[ $i ][ $j ] = $c;
            $this->P[ $i ][ $j ] = ( $cost == 1 ) ? 'R' : 'M';            
        }
        private function getCost( $S1, $S2, $prev_i, $prev_j ){
            return ( mb_substr( $S1, $prev_i, 1, 'UTF-8' ) != mb_substr( $S2, $prev_j, 1, 'UTF-8' ) ) ? 1 : 0;
        }
        private function generatePrescription(){
            //Восстановление предписания
            $route = '';
            $i = $this->m;
            $j = $this->n;
            do {
                $c = $this->P[ $i ][ $j ];
                $route .= $c;
                if( $c == 'R' || $c == 'M') {
                        $i--;
                        $j--;
                }
                else if( $c == 'D') {
                        $i--;
                }
                else {
                        $j--;
                }
            } while( ( $i != 0 ) || ( $j != 0 ) );
            return new Prescription( $this->D[ $this->m ][ $this->n ], strrev( $route ) );            
        }
    }
?>