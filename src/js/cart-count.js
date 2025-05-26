function updateCartCount() {
  fetch("../php/get_cart_count.php")
    .then((response) => response.json())
    .then((data) => {
      const cartCountElement = document.querySelector(".cart-count");
      if (cartCountElement) {
        cartCountElement.textContent = data.count;
      }
    })
    .catch((error) => console.error("Error:", error));
}

// Cập nhật số lượng khi trang được tải
document.addEventListener("DOMContentLoaded", updateCartCount);
