document.getElementById("searchForm").addEventListener("submit", function (e) {
  e.preventDefault();

  // Lấy dữ liệu nhập vào
  const productName = document.getElementById("productName").value.trim();
  const minPrice = document.getElementById("minPrice").value;
  const maxPrice = document.getElementById("maxPrice").value;

  // Gửi request đến PHP
  fetch("../php/advanceSearch.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      productName,
      minPrice,
      maxPrice,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("Kết quả tìm kiếm:", data);
      displayResults(data);
    })
    .catch((error) => console.error("Lỗi tìm kiếm:", error));
});

// Hiển thị kết quả tìm kiếm
function displayResults(data) {
  const resultsTable = document.getElementById("searchResults");
  resultsTable.innerHTML = "";

  if (data.length === 0) {
    resultsTable.innerHTML =
      "<tr><td colspan='3'>Không tìm thấy sản phẩm</td></tr>";
    return;
  }

  data.forEach((product) => {
    const row = document.createElement("tr");
    row.innerHTML = `
            <td>${product.product_id}</td>
            <td>${product.product_name}</td>
            <td>${Number(product.price).toLocaleString()} VND</td>
        `;
    resultsTable.appendChild(row);
  });
}
