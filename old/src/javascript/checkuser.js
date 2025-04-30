function loginUser() {
  const username = document.getElementById("username").value.trim();
  const password = document.getElementById("password").value;

  if (!username || !password) {
    alert("Vui lòng nhập đầy đủ thông tin.");
    return;
  }

  fetch("../php/checkuser.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `username=${encodeURIComponent(
      username
    )}&password=${encodeURIComponent(password)}`,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("Đăng nhập thành công!");
        window.location.href = "../index.php"; // chuyển hướng đến trang chính
      } else {
        alert(data.message || "Sai tên đăng nhập hoặc mật khẩu.");
      }
    })
    .catch((error) => {
      console.error("Lỗi:", error);
      alert("Đã xảy ra lỗi khi đăng nhập.");
    });
}
