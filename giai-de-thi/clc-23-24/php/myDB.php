<?php
class myDB
{
    public $svname = "localhost";
    public $username = "root";
    public $password = "";
    public $dbname = "myDB";
    public $conn;
    // Nhận vào 4 giá trị svname, username, pass, dbname 
    function __contructor($svname, $username, $pass, $dbname)
    {
        $this->svname = $svname;
        $this->username = $username;
        $this->password = $pass;
        $this->dbname = $dbname;
    }

    function connectDB()
    {
        $this->conn = new mysqli($this->svname, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Kết nối không thành công: " . $this->conn->connect_error);
        }
        echo "Kết nối thành công";
    }

    // Query là câu lệnh truy vấn, vidu: $query = "select * from SP" 
    function runQuery($query)
    {
        $result = $this->conn->query($query);
        return $result;
    }

    function closeDB()
    {
        $this->conn->close();
    }
}
