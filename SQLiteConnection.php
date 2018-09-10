<?php
    class SQLiteConnection {
        public $pdo;
        
        function connect($path)
        {
             try{
                if($this->pdo ==  null){
                    $this->pdo = new PDO('sqlite:' . $path);
                }
                
                return $this->pdo;
            }
            catch(PDOException $ex)
            {
                echo $ex;
            }
        }

        function isConnected()
        {
            if($this->pdo == null)
            {
                return false;
            }

            return true;
        }
    }
?>
