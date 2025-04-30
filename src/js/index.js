document.addEventListener("DOMContentLoaded", function () {
  // Toggle menu for mobile devices
  const menuToggle = document.querySelector(".menu-toggle");
  const mainMenu = document.querySelector(".main-menu");

  if (menuToggle && mainMenu) {
    menuToggle.addEventListener("click", function () {
      mainMenu.classList.toggle("active");
    });
  }

  // Handle dropdown menus for mobile
  const dropdownLinks = document.querySelectorAll(".has-dropdown > a");

  dropdownLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      if (window.innerWidth <= 992) {
        e.preventDefault();
        const dropdown = this.nextElementSibling;
        dropdown.classList.toggle("active");
      }
    });
  });

  // Sticky header
  const header = document.querySelector(".header");
  let lastScrollTop = 0;

  window.addEventListener(
    "scroll",
    function () {
      let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

      if (scrollTop > lastScrollTop && scrollTop > 100) {
        // Scrolling down
        header.style.transform = "translateY(-100%)";
      } else {
        // Scrolling up
        header.style.transform = "translateY(0)";
      }

      lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    },
    false
  );

  // Cart functionality (example)
  const addToCartButtons = document.querySelectorAll(".add-to-cart");
  const cartCount = document.querySelector(".cart-count");
  let count = 0;

  if (addToCartButtons.length > 0 && cartCount) {
    addToCartButtons.forEach((button) => {
      button.addEventListener("click", function (e) {
        e.preventDefault();
        count++;
        cartCount.textContent = count;

        // Animation effect
        cartCount.classList.add("pulse");
        setTimeout(() => {
          cartCount.classList.remove("pulse");
        }, 300);

        // You could add more logic here like showing a notification
        showNotification("Sản phẩm đã được thêm vào giỏ hàng!");
      });
    });
  }

  // Notification function
  function showNotification(message) {
    // Create notification element
    const notification = document.createElement("div");
    notification.className = "notification";
    notification.textContent = message;

    // Add to the DOM
    document.body.appendChild(notification);

    // Trigger animation
    setTimeout(() => {
      notification.classList.add("show");
    }, 10);

    // Remove after a delay
    setTimeout(() => {
      notification.classList.remove("show");
      setTimeout(() => {
        document.body.removeChild(notification);
      }, 300);
    }, 3000);
  }

  // Newsletter form submission
  const newsletterForm = document.querySelector(".newsletter-form");

  if (newsletterForm) {
    newsletterForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const input = this.querySelector('input[type="email"]');
      const email = input.value.trim();

      if (email) {
        // Here you would typically make an AJAX call to your backend
        console.log("Email subscription:", email);
        showNotification("Cảm ơn bạn đã đăng ký nhận tin!");
        input.value = "";
      } else {
        showNotification("Vui lòng nhập địa chỉ email!");
      }
    });
  }

  // Window resize event
  window.addEventListener("resize", function () {
    if (window.innerWidth > 992) {
      // Reset mobile menu state when resizing to desktop
      if (mainMenu.classList.contains("active")) {
        mainMenu.classList.remove("active");
      }

      // Reset dropdown states
      const activeDropdowns = document.querySelectorAll(".dropdown.active");
      activeDropdowns.forEach((dropdown) => {
        dropdown.classList.remove("active");
      });
    }
  });

  // Add CSS for notifications
  const style = document.createElement("style");
  style.textContent = `
        .notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #333;
            color: #fff;
            padding: 12px 20px;
            border-radius: 4px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 9999;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.3s, transform 0.3s;
        }
        
        .notification.show {
            opacity: 1;
            transform: translateY(0);
        }
        
        .pulse {
            animation: pulse-animation 0.3s;
        }
        
        @keyframes pulse-animation {
            0% { transform: scale(1); }
            50% { transform: scale(1.5); }
            100% { transform: scale(1); }
        }
    `;
  document.head.appendChild(style);
});
