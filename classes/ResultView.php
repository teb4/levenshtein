<?php
    require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/classes/Log.php';    
    class ResultView{
        private $from;
        private $to;    
        private $logDataList;        
        public function __construct( $from, $to, array $logDataList ){
            $this->from = $from;
            $this->to = $to;    
            $this->logDataList = $logDataList;      
        }
        public function toHtml(){
            $log = new Log( $this->logDataList );
            return '
                Prescription Levenshtein<br /><br />
                
                <form action="index.php" method="post">
                    <table>
                        <tr>
                            <td>От слова</td>
                            <td><input type="text" name="from" value="' . $this->from . '" /></td>
                        </tr>
                        <tr>
                            <td>К слову</td>
                            <td><input type="text" name="to" value="' . $this->to . '" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" value="Start" name="start"/></td>
                        </tr>
                        <tr>
                            <td><input type="hidden" name="action" value="start"></td>
                        </tr>
                    <table>                    
                </form>
                <br /><br />' . $log->toHtml(). '           
                <br /><br />
                Преобразование завершено<br /><br />               
            ';            
        }
    }
?>