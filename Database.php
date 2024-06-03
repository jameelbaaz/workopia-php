<?php 

    class Database{
        public $conn;

        /**
         * Constructor for Database class
         * 
         * @param array $config
         * @return void
         * 
         */
        public function __construct($config){
            $dsn="mysql:host={$config['host']}; port={$config['port']}; dbname={$config['dbname']}; ";
            $options=[
                PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ
            ];  

            try {
               $this->conn= new PDO($dsn, $config['username'], $config['password'], $options);
                //echo "Connected";
            } catch (PDOException $e) {
                throw new Exception("Database connection failed : {$e->getMessage()}");
            }
        }


        /**
         * Query the database
         * 
         * @param string $query
         * @return PDOStatement
         * @throws PDOEXceptions
         */
        public function query($query, $params=[]){
            try {
               $stmt= $this->conn->prepare($query);
            //    Bind named params
            foreach($params as $param=>$value){
                $stmt->bindValue(':' . $param, $value);
            }
               $stmt->execute();
               return $stmt;
            } catch (PDOException $e) {
                throw new Exception("Query failed to execute : {$e->getMessage()}");
            }
        }


    }