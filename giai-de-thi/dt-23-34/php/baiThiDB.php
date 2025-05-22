<?php
class baiThiDB
{
    public $svname;
    public $usname;
    public $pass;
    public $dbname;
    public $conn;

    function __construct($svname, $usname, $pass, $dbname)
    {
        $this->svname = $svname;
        $this->usname = $usname;
        $this->pass = $pass;
        $this->dbname = $dbname;
    }

    function connectDB()
    {
        $this->conn = new mysqli($this->svname, $this->usname, $this->pass, $this->dbname);
        if (!$this->conn) {
            die("Lỗi kết nối: " . mysqli_connect_error());
        } else {
            echo "Kết nối thành công" . "<br>";
        }
    }

    function closeDB()
    {
        $this->conn->close();
    }

    // Trả về kết quả truy vấn 
    function runQuery($query)
    {
        $res = $this->conn->query($query);
        return $res;
    }
}
