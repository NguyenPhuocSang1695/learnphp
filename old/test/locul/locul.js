document.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  const categoryId = urlParams.get("category_id") || 0;
  const productContainer = document.getElementById("product-list");

  fetch(`/php/get_products.php?category_id=${categoryId}`)
    .then((response) => response.json())
    .then((data) => {
      if (!Array.isArray(data) || data.length === 0) {
        productContainer.innerHTML = "<p>Không có sản phẩm nào.</p>";
        return;
      }

      productContainer.innerHTML = data
        .map(
          (product) => `
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="${
                          product.ImageURL
                        }" class="card-img-top" alt="${product.ProductName}">
                        <div class="card-body">
                            <h5 class="card-title">${product.ProductName}</h5>
                            <p class="card-text">${product.DescriptionBrief}</p>
                            <p class="card-text"><strong>Giá:</strong> ${new Intl.NumberFormat(
                              "vi-VN"
                            ).format(product.Price)} VNĐ</p>
                        </div>
                    </div>
                </div>
            `
        )
        .join("");
    })
    .catch((error) => {
      console.error("Lỗi khi tải dữ liệu:", error);
      productContainer.innerHTML = "<p>Lỗi khi tải sản phẩm.</p>";
    });
});
