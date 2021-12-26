<?php
    class Database
    {
        protected $connection = null;
    
        public function __construct()
        {
            try {
                $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
                if ( mysqli_connect_errno()) {
                    throw new Exception("Could not connect to database.");   
                }
            } catch (Exception $e) {
                throw new Exception($e->getMessage());   
            }           
        }
    
        public function select($query = "" , $paramtypes = null, $paramvalues = null)
        {
            try {
                $stmt = $this->executeStatement( $query , $paramtypes, $paramvalues );
                $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);               
                $stmt->close();
    
                return $result;
            } catch(Exception $e) {
                throw New Exception( $e->getMessage() );
            }
            return false;
        }

        public function execute($query = "" , $paramtypes = null, $paramvalues = null)
        {
            try {
                $stmt = $this->executeStatement( $query , $paramtypes, $paramvalues );
                $result = $stmt->affected_rows > 0;   
                $stmt->close();
    
                return $result;
            } catch(Exception $e) {
                throw New Exception( $e->getMessage() );
            }
            return false;
        }
    
        private function executeStatement($query = "" , $paramtypes = null, $paramvalues = null)
        {
            try {
                $stmt = $this->connection->prepare( $query );
    
                if($stmt === false) {
                    throw New Exception("Unable to do prepared statement: " . $query);
                }
    
                if( $paramtypes &&  $paramvalues) {
                    $stmt->bind_param($paramtypes, ...$paramvalues);
                }
    
                $stmt->execute();
    
                return $stmt;
            } catch(Exception $e) {
                throw New Exception( $e->getMessage() );
            }   
        }
    }
?>