import './bootstrap';
import '../../public/assets/libs/lazyload/lazysizes.min';

document.addEventListener("DOMContentLoaded", function () {
    const menu = document.querySelector(".pc-menu");
    const header = document.querySelector("header");
    const menuMobile = document.querySelector(".menu-mobile");

    window.addEventListener("scroll", function () {
        const isMobile = window.innerWidth < 768;
        const threshold = isMobile ? 120 : 140;

        // Xử lý menu PC
        if (menu) {
            if (window.scrollY > threshold) {
                menu.classList.add("fixed");
                header.classList.remove("h-[191px]", "h-[210px]");
                header.classList.add(isMobile ? "h-[225px]" : "h-[191px]");
            } else {
                menu.classList.remove("fixed");
                header.classList.remove("h-[191px]", "h-[225px]");
            }
        }

        // Xử lý menu mobile
        if (menuMobile && isMobile) {
            if (window.scrollY > 176) {
                menuMobile.classList.add("fixed", "top-0", "left-0", "right-0", "z-40", "bg-white");
            } else {
                menuMobile.classList.remove("fixed", "top-0", "left-0", "right-0", "z-40", "bg-white");
            }
        }
    });

    // Nút trở lại trên cùng
    const backToTop = document.getElementById("backToTop");
    if (backToTop) {
        window.addEventListener("scroll", function () {
            if (window.scrollY > 200) {
                backToTop.classList.remove("opacity-0", "invisible");
                backToTop.classList.add("opacity-100", "visible");
            } else {
                backToTop.classList.remove("opacity-100", "visible");
                backToTop.classList.add("opacity-0", "invisible");
            }
        });
        backToTop.addEventListener("click", function () {
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    // Chọn tất cả nút "Thêm vào giỏ hàng"
    const addToCartButtons = document.querySelectorAll(".add-to-cart");
    const closeModal = document.querySelector(".close-modal");
    const iconWrapper = document.getElementById("modal-icon-wrapper");
    const iconSuccess = document.getElementById("icon-success");
    const iconError = document.getElementById("icon-error");
    const cartLink = document.getElementById("modal-cart-link");

    addToCartButtons.forEach((button) => {
        button.addEventListener("click", function (event) {
            event.preventDefault();

            let productId = this.dataset.id;
            let quantity = 1;

            fetch("/cart/add", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                },
                body: JSON.stringify({
                    id: productId,
                    quantity: quantity,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    const modal = document.getElementById("modal-alert-cart");
                    const modalTitle = modal.querySelector("#modal-title");
                    const modalMessage = modal.querySelector(".text-sm.text-gray-500");

                    if (data.success) {
                        modalTitle.textContent = "Thêm vào giỏ hàng thành công";
                        modalMessage.textContent = "Quý khách đặt mua nhiều sản phẩm cùng một đơn hàng để được phí vận chuyển tốt hơn";

                        // ✅ Đổi màu icon wrapper + ẩn/hiện svg
                        iconWrapper.classList.remove("bg-red-300/30");
                        iconWrapper.classList.add("bg-green-300/30");
                        iconSuccess.classList.remove("hidden");
                        iconError.classList.add("hidden");

                        cartLink.classList.remove("bg-red-600");
                        cartLink.classList.add("bg-green-600");
                    } else {
                        modalTitle.textContent = "Không thể thêm vào giỏ hàng";
                        modalMessage.textContent = data.message || "Đã xảy ra lỗi, vui lòng thử lại.";

                        // ✅ Đổi màu sang đỏ + hiện svg lỗi
                        iconWrapper.classList.remove("bg-green-300/30");
                        iconWrapper.classList.add("bg-red-300/30");
                        iconSuccess.classList.add("hidden");
                        iconError.classList.remove("hidden");

                        cartLink.classList.remove("bg-green-600");
                        cartLink.classList.add("bg-red-600");
                    }

                    modal.classList.remove("hidden");
                    setTimeout(() => {
                        modal.classList.add("hidden");
                    }, 5000);
                })
                .catch((error) => console.error("Error:", error));
        });
    });

    // Đóng modal khi nhấn ngoài vùng
    if (closeModal) {
        closeModal.addEventListener("click", function () {
            document.getElementById("modal-alert-cart").classList.add("hidden");
        });
    }
});
