let currentPage = 1; // Trang hiện tại
const resultsPerPage = 5; // Giới hạn 5 sản phẩm/trang

document
  .getElementById("searchForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Ngăn reload trang
    currentPage = 1; // Reset về trang đầu khi tìm kiếm mới
    fetchProducts();
  });

function fetchProducts() {
  let productName = document.getElementById("productName").value.trim();
  let minPrice = document.getElementById("minPrice").value.trim();
  let maxPrice = document.getElementById("maxPrice").value.trim();

  minPrice = minPrice === "" ? 0 : parseFloat(minPrice);
  maxPrice = maxPrice === "" ? null : parseFloat(maxPrice); // Không giới hạn nếu không nhập

  fetch(`./aSearch.php?page=${currentPage}&limit=${resultsPerPage}`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ productName, minPrice, maxPrice }),
  })
    .then((response) => response.json())
    .then((data) => {
      let resultTable = document.getElementById("searchResults");
      resultTable.innerHTML = ""; // Xóa kết quả cũ

      if (data.products.length > 0) {
        data.products.forEach((product) => {
          let row = `<tr>
                      <td>${product.product_id}</td>
                      <td>${product.product_name}</td>
                      <td>${new Intl.NumberFormat().format(
                        product.price
                      )} VND</td>
                    </tr>`;
          resultTable.innerHTML += row;
        });

        // Hiển thị nút chuyển trang
        updatePagination(data.totalPages);
      } else {
        resultTable.innerHTML =
          "<tr><td colspan='3'>Không tìm thấy sản phẩm nào</td></tr>";
        document.getElementById("pagination").innerHTML = ""; // Ẩn phân trang nếu không có sản phẩm
      }
    })
    .catch((error) => console.error("Lỗi tìm kiếm:", error));
}

function updatePagination(totalPages) {
  let pagination = document.getElementById("pagination");
  pagination.innerHTML = `
        <button class="btn btn-success" onclick="changePage(-1)" ${
          currentPage === 1 ? "disabled" : ""
        }><</button>
        <span>Trang ${currentPage} / ${totalPages}</span>
        <button class="btn btn-success" onclick="changePage(1)" ${
          currentPage >= totalPages ? "disabled" : ""
        }>></button>
    `;
}

function changePage(direction) {
  currentPage += direction; // Chuyển trang
  fetchProducts(); // Tải dữ liệu trang mới
}
