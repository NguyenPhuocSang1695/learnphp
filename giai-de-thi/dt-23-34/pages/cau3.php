<?php
require_once "../php/baiThiDB.php";
$db = new baiThiDB("localhost", "root", "", "BaiThiDB");
$db->connectDB();

// Xử lý thêm tài khoản 
// Nhận dữ liệu từ form 
if (isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $tendn = $_POST["txttendn"];
    $matkhau = $_POST["txtmatkhau"];

    $hashp = password_hash($matkhau, PASSWORD_DEFAULT);
    $ngaytao = date("Y-m-d");
    $tinhtrang = 0;
    $quyen = $_POST["txtquyen"];

    // Kiểm tra tài khoản tồn tại chưa 
    // $checkus = "select tenDangNhap from TAIKHOAN where tenDangNhap like $tendn";
    // if (!$checkus) {
    //     echo "tài khoản tồn tại";
    //     exit;
    // }

    // Câu lệnh chèn tk mới vào db 
    $query = "insert into TAIKHOAN (tenDangNhap, matKhau, ngayTaoTaiKhoan, tinhTrangTaiKhoan, maQuyen)
              value ('$tendn', '$hashp', '$ngaytao', '$tinhtrang', '$quyen')";
    // Thực thi truy vấn 
    $isAdd = $db->runQuery($query);
    if (!$isAdd) {
        echo "Thêm thất bại" . mysqli_error($db->conn);
    } else {
        echo "Thêm thành công";
    }
}

// Xử lý xóa tài khoản 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table,
        tr,
        td {
            border: 1px black solid;
        }

        table {
            border-collapse: collapse;

        }
    </style>
</head>

<body>
    <div class="container">
        <form action="./cau3.php" name="frmthemtk" method="post" onsubmit="checkRegEx()">
            <table>
                <tr>
                    <td colspan="2" align="center">
                        Thêm tài khoản
                    </td>
                </tr>
                <tr>
                    <td>Tên đăng nhập:</td>
                    <td><input type="text" name="txttendn" id="txttendn" required></td>
                </tr>
                <tr>
                    <td>Mật khẩu:</td>
                    <td><input type="password" name="txtmatkhau" id="txtmatkhau" required></td>
                </tr>
                <tr>
                    <td>Quyền tài khoản:</td>
                    <td>
                        <select name="txtquyen" id="" required>
                            <option value="">Chọn quyền tài khoản</option>
                            <?php
                            $sql = "select * from QUYEN";
                            $res = $db->runQuery($sql);
                            while ($row = $res->fetch_assoc()) {
                                echo '<option value = "' . $row["maQuyen"] . '">' . $row['tenQuyen'] . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center   ">
                        <input type="submit" name="submit" id="" value="Thêm tài khoản">
                    </td>
                </tr>
            </table>
        </form>


        <a href="./xoatk.php"><button>Xóa tk</button></a>
    </div>
    <script>
        function checkRegEx() {
            const patternUsname = /^TK\d{6}$/;
            const patternPasss = /^.{6,20}$/;

            let tenDangNhap = document.getElementById("txttendn").value;
            let matKhau = document.getElementById("txtmatkhau").value;
            // let quyen = document.getElementById("txtquyen").value;



            const resTDN = patternUsname.test(tenDangNhap);
            const resMK = patternPasss.test(matKhau);

            if (!resTDN && !resMK) {
                alert("Tên đăng nhập và mật khẩu không đạt yêu cầu.\n- Tên đăng nhập: TK + 6 chữ số\n- Mật khẩu: 6-20 ký tự bất kỳ");
                return false;
            } else if (!resTDN) {
                alert("Tên đăng nhập không đúng định dạng (TK + 6 chữ số)");
                return false;
            } else if (!resMK) {
                alert("Mật khẩu phải từ 6 đến 20 ký tự");
                return false;
            } else if (quyen === "") {
                alert("Vui lòng chọn quyền tài khoản");
                return false;
            }
            return true;
        }
    </script>

    <a href="../index.php">
        <button>
            quay về tc
        </button>
    </a>
</body>

</html>