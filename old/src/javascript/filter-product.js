const filterProduct = (event) => {
  event.preventDefault(); // Ngăn chặn reload trang

  let selectedType = document.getElementById("select-type").value;
  let resultDiv = document.getElementById("result-filter");
  resultDiv.innerHTML = "<p>Đang tải...</p>"; // Hiển thị thông báo loading

  fetch(`./php/filter-product.php`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ selectedType }),
  })
    .then((response) => response.json())
    .then((data) => {
      resultDiv.innerHTML = ""; // Xóa thông báo cũ

      if (data.products && data.products.length > 0) {
        let resultList = "<ul>";
        data.products.forEach((product) => {
          resultList += `<li>${
            product.product_name
          } - ${new Intl.NumberFormat().format(product.price)} VND</li>`;
        });
        resultList += "</ul>";
        resultDiv.innerHTML = resultList;
      } else {
        resultDiv.innerHTML = "<p>Không tìm thấy sản phẩm nào!</p>";
      }
    })
    .catch((error) => {
      console.error("Lỗi:", error);
      resultDiv.innerHTML = "<p>Có lỗi xảy ra! Vui lòng thử lại.</p>";
    });
};

// Gán sự kiện khi form submit
document.querySelector("form").addEventListener("submit", filterProduct);
