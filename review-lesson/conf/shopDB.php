<?php
class shopDB
{
    public $svname;
    public $usname;
    public $pass;
    public $dbname;
    public $conn;

    // Hàm khởi tjao nhận giá trị để kết cơ sở dữ liệu 
    function __construct($svname, $usname, $pass, $dbname)
    {
        $this->svname = $svname;
        $this->usname = $usname;
        $this->pass = $pass;
        $this->dbname = $dbname;
    }

    // Destruct tự động đóng khi đối tượng bị hủy 
    function __destruct()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    // Hàm kết nối với database
    function connectDB()
    {
        $this->conn = new mysqli($this->svname, $this->usname, $this->pass, $this->dbname);
        if (!$this->conn) {
            die("Lỗi kết nối: " . mysqli_connect_error());
        } else {
            echo "Kết nối thành công " . "<br>";
        }
    }

    // Hàm đóng kết nối 
    function closeDB()
    {
        $this->conn->close();
    }

    // Hàm trả về kết quả truy vấn 
    function runQuery($query)
    {
        $result = $this->conn->query($query);
        return $result;
    }

    // Hàm truy vấn nhiều nhiều cái 
    function runnMultipleQuery($query)
    {
        $res = $this->conn->multi_query($query);
        return $res;
    }

    public function getConnection()
    {
        return $this->conn;
    }

    // Hàm prepareAndExecute dùng để truy vấn tránh sql injection 
    function prepareAndExecute($query, $type, $params)
    {
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Lỗi truy vấn: " . $this->conn->error);
        }

        $stmt->bind_param($type, ...$params);

        $stmt->execute();
        return $stmt;
    }

    // Hàm lấy tất cả dữ liệu của query dưới dạng mảng 
    function fetchAll($query)
    {
        $result = $this->conn->query($query);
        $data = [];
        if (!$result) {
            die("Lỗi truy vấn: " . $this->conn->error);
        } else {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    // Hàm lấy số bản ghi bị ảnh hưởng sau thao tác INSERT/UPDATE/DELETE 
    function affectedRows()
    {
        return $this->conn->affected_rows;
    }
}

// Thêm nhiều dữ liệu (dùng hàm runnMultipleQuery) 
// $sql = "INSERT INTO MyGuests (firstname, lastname, email)
// VALUES ('John', 'Doe', 'john@example.com');";
// $sql .= "INSERT INTO MyGuests (firstname, lastname, email)
// VALUES ('Mary', 'Moe', 'mary@example.com');";
// $sql .= "INSERT INTO MyGuests (firstname, lastname, email)
// VALUES ('Julie', 'Dooley', 'julie@example.com')";
