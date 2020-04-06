<?php

    /*
    *PDO database class
    *connect to database
    *create prepared stmt
    *bind Values
    *return rows & results
    */


    class Database{

        private $host   = DB_HOST;
        private $user   = DB_USER;
        private $pass   = DB_PASS;
        private $dbname = DB_NAME;

        private $dbh ;
        private $stmt ;
        private $error ;


        public function __construct()
        {
            $dsn = "mysql:host=".$this->host.";dbname=".$this->dbname;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION
            );

            try {
                $this->dbh = new PDO($dsn, $this->user , $this->pass , $options);
                // $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                echo $this->error;
            }

        }

        public function query($sql)
        {
            $this->stmt = $this->dbh->prepare($sql);
        }

        public function bind($params , $value , $type = null)
        {
            if (is_null($type)) {
        
                switch (true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                    break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                    break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                    break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }

            $this->stmt->bindValues($params , $value , $type);
        }

        public function execute()
        {
            return $this->stmt->execute();
        }

        public function resultSet()
        {
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function single()
        {
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

    }