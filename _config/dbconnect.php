<?php







class DatabaseConnection{







    private $servername;

    private $username;

    private $password;

    private $dbname;

    public $conn;







    public function __construct() {



        $this->db_connect();


      }



    function db_connect(){



        $this->servername = 'localhost';

        $this->username = 'gpz0wlayf67y';

        $this->password = 'I6fQbn@W4p@w';

        $this->dbname = 'school_app';





        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);



        return $this->conn;



    }









}



// DatabaseConnection end







?>