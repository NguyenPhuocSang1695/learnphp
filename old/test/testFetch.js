function testFetch() {
  fetch("../test/testFetch.php")
    .then((response) => response.json()) // Chuyển thẳng sang JSON
    .then((data) => {
      console.log("Raw response:", data);

      // Kiểm tra trạng thái đăng nhập và lưu vào localStorage
      if (data.isLogin) {
        localStorage.setItem("isLogin", "true");
      } else {
        localStorage.setItem("isLogin", "false");
      }

      console.log(
        "Trạng thái đăng nhập đã lưu:",
        localStorage.getItem("isLogin")
      );
    })
    .catch((error) => console.error("Fetch error:", error));
}

// Gọi hàm khi tải trang
document.addEventListener("DOMContentLoaded", testFetch);
