<?php
    class DefaultView{
        public function toHtml(){
            return '
                <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
                <html>
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                        <title>Prescription Levenshtein</title>
                    </head>
                    <body>                    
                        Prescription Levenshtein<br /><br />

                        <form action="index.php" method="post">
                            <table>
                                <tr>
                                    <td>От слова</td>
                                    <td><input type="text" name="from" /></td>
                                </tr>
                                <tr>
                                    <td>К слову</td>
                                    <td><input type="text" name="to" /></td>
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
                    </body>
                </html>
            ';            
        }
    }
?>