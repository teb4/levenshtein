<?php
    require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/classes/Prescription.php';
    require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/classes/Levenshtein.php';    
    class Model{
        public static function getLogDataList( $from, $to ){
            $result = array();
            $levenshtein = new Levenshtein( $from, $to );
            $prescription = $levenshtein->getPrescription();            
            $routeList = str_split( $prescription->getRoute() );
            $step = 1;
            $sourceIndex = 0;
            $source = $from;
            $dest = $to;
            foreach( $routeList as $operation ){
                switch( $operation ){
                    case 'M':
                        $value = self::getValue( $source, $sourceIndex );
                        $result[] = self::getLogRowData( $step, $source, $operation, $value, $source );
                        $sourceIndex++;                        
                        break;
                    case 'D':
                        $value = self::getValue( $source, $sourceIndex ); 
                        $next = self::delete( $source, $sourceIndex );
                        $result[] = self::getLogRowData( $step, $source, $operation, $value, $next );
                        $source = $next;
                        break;
                    case 'I':
                        $value = self::getValue( $dest, $sourceIndex ); 
                        $next = self::insert( $source, $dest, $sourceIndex );
                        $result[] = self::getLogRowData( $step, $source, $operation, $value, $next );                        
                        $source = $next;                        
                        $sourceIndex++;                        
                        break;
                    case 'R':
                        $value = self::getValue( $source, $sourceIndex ) . '<-' . self::getValue( $dest, $sourceIndex );
                        $next = self::replace( $source, $dest, $sourceIndex );
                        $result[] = self::getLogRowData( $step, $source, $operation, $value, $next );                        
                        $source = $next;
                        $sourceIndex++;                        
                        break;                    
                }
                $step++;                
            }
            return $result;
        }
        private static function getLogRowData( $step, $source, $operation, $value, $dest ){
            return array( 'step' => $step, 'source' => $source, 'operation' => $operation, 'value' => $value, 'dest' => $dest );
        }
        private static function getValue( $obj, $index ){
            return mb_substr( $obj, $index, 1, 'UTF-8' );
        }
        public static function replace( $source, $dest, $sourceIndex ){           
            $result = self::delete( $source, $sourceIndex );
            $result = self::insert( $result, $dest, $sourceIndex );
            return $result;
        }
        public static function delete( $source, $sourceIndex ){
            $result = '';
            $result = mb_substr( $source, 0, $sourceIndex, 'UTF-8' );
            $result .= mb_substr( $source, $sourceIndex + 1, mb_strlen( $source ) - $sourceIndex, 'UTF-8' );            
            return $result;
        }        
        private static function insert( $source, $dest, $sourceIndex ){
            $result = '';
            $result = mb_substr( $source, 0, $sourceIndex, 'UTF-8' );
            $result .= mb_substr( $dest, $sourceIndex, 1, 'UTF-8' );
            $result .= mb_substr( $source, $sourceIndex, mb_strlen( $source, 'UTF-8' ) - $sourceIndex, 'UTF-8' );            
            return $result;
        }        
    }
?>