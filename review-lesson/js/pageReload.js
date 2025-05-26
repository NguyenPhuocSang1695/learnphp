window.addEventListener("pageshow", (event) => {
  if (event.persisted) {
    window.reload();
  }
});
