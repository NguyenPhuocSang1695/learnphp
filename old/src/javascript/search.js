function testFunction() {
  let productId = document.getElementById("product_id").value.trim();
  let productName = document.getElementById("product_name").value.trim();
  let maxPrice = document.getElementById("price").value.trim();

  let query = `../php/search.php?product_id=${productId}&product_name=${productName}&price=${maxPrice}`;

  fetch(query)
    .then((response) => response.json())
    .then((data) => {
      let tableBody = document.getElementById("product-list");
      tableBody.innerHTML = ""; // Xóa kết quả cũ

      if (data.length > 0) {
        data.forEach((product) => {
          let row = `<tr>
                        <td>${product.product_id}</td>
                        <td>${product.product_name}</td>
                        <td>${product.price.toLocaleString()} VND</td>
                    </tr>`;
          tableBody.innerHTML += row;
        });
      } else {
        tableBody.innerHTML = "<tr><td colspan='3'>No products found</td></tr>";
      }
    })
    .catch((error) => console.error("Error fetching data:", error));
}
