function loginUser() {
  let username = document.getElementById("username").value;
  let password = document.getElementById("password").value;

  if (!username || !password) {
    alert("Vui lòng nhập đầy đủ thông tin đăng nhập!");
    return;
  }

  fetch("../php/checkuser.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({ username, password }),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("Server response:", data); // Debug phản hồi từ server

      if (data.status === 1) {
        console.log("Đăng nhập thành công! Chuyển hướng...");

        // Lưu username vào localStorage để trang index.php có thể lấy lại
        localStorage.setItem("username", data.username);

        setTimeout(() => {
          window.location.href = "../index.php";
        }, 1000);
      } else {
        alert("Đăng nhập thất bại: " + data.message);
      }
    })
    .catch((error) => console.error("Fetch error:", error));
}
