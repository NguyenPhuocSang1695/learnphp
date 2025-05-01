document.addEventListener("DOMContentLoaded", function () {
  const defaultInfo = document.getElementById("defaultInfo");
  const newInfo = document.getElementById("newInfo");
  const customerInfo = document.getElementById("customerInfo");

  function toggleInfo() {
    if (defaultInfo.checked) {
      // Disable input khi dùng mặc định
      customerInfo.querySelectorAll("input").forEach((input) => {
        input.disabled = true;
      });
    } else {
      // Enable input khi nhập mới
      customerInfo.querySelectorAll("input").forEach((input) => {
        input.disabled = false;
      });
    }
  }

  defaultInfo.addEventListener("change", toggleInfo);
  newInfo.addEventListener("change", toggleInfo);
  toggleInfo();
});
