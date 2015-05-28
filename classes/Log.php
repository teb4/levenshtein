<?php
    class Log{
        private $logDataList;
        public function __construct( array $logDataList ){
            $this->logDataList = $logDataList;
        }
        public function toHtml(){
            return '
                Протокол выполнения<br /><br />
                <table border>
                    <tr>
                        <th>
                            Шаг
                        </th>  
                        <th>
                            Исходное значение
                        </th>                        
                        <th>
                            Операция
                        </th>
                        <th>
                            Значение операции
                        </th>                
                        <th>
                            Результирующее значение
                        </th>                        
                    </tr>' . $this->getLogRows() . '
                    

                </table>                
            ';
        }
        private function getLogRows(){
            $result = '';
            foreach ( $this->logDataList as $logData ){
                $result .= $this->getLogRow( $logData[ 'step' ], $logData[ 'source' ], $logData[ 'operation' ], $logData[ 'value' ], $logData[ 'dest' ] );
            }
            return $result;     
        }
        private function getLogRow( $step, $source, $operation, $value, $dest ){
            return '
                    <tr>
                        <td>
                            ' . $step . '
                        </td>  
                        <td>
                            ' . $source . '
                        </td>                        
                        <td>
                            ' . $operation . '
                        </td>
                        <td>
                            ' . $value . '
                        </td>                
                        <td>
                            ' . $dest . '
                        </td>                                                
                    </tr>                
                ';
        }
    }
?>