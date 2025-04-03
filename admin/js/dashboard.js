document
  .getElementById("imageURL")
  .addEventListener("change", function (event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = function () {
      const imagePreview = document.createElement("img");
      imagePreview.src = reader.result;
      imagePreview.style.maxWidth = "200px";
      imagePreview.style.marginTop = "10px";
      document.body.appendChild(imagePreview);
    };
    reader.readAsDataURL(file);
  });
