document.addEventListener("DOMContentLoaded", function () {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    function saveCart() {
        localStorage.setItem("cart", JSON.stringify(cart));
        console.log("Cart saved:", cart);
    }

    function renderCart() {
        const cartContainer = document.getElementById("cart-items");
        const cartTotal = document.getElementById("cart-total");

        if (!cartContainer || !cartTotal) return;

        cartContainer.innerHTML = "";
        let total = 0;

        cart.forEach((item, index) => {
            total += item.price * item.quantity;
            const itemElement = document.createElement("div");
            itemElement.classList.add("cart-item");
            itemElement.innerHTML = `
                <p>${item.name} - $${item.price.toFixed(2)} x ${item.quantity}</p>
                <button class="remove-item" data-index="${index}">Remove</button>
            `;
            cartContainer.appendChild(itemElement);
        });

        cartTotal.textContent = `Total: $${total.toFixed(2)}`;
    }

    function addToCart(product) {
        const existingProduct = cart.find((item) => item.id === product.id);
        if (existingProduct) {
            existingProduct.quantity++;
        } else {
            cart.push(product);
        }
        saveCart();
        renderCart();
    }

    document.querySelectorAll(".add-to-cart").forEach((button) => {
        button.addEventListener("click", function () {
            const product = {
                id: this.dataset.id,
                name: this.dataset.name,
                price: parseFloat(this.dataset.price),
                quantity: 1,
            };

            console.log("Adding product:", product);
            addToCart(product);
        });
    });

    document.getElementById("cart-items")?.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove-item")) {
            const index = e.target.dataset.index;
            cart.splice(index, 1);
            saveCart();
            renderCart();
        }
    });

    document.getElementById("view-orders")?.addEventListener("click", function () {
        if (cart.length === 0) {
            alert("No orders placed yet!");
        } else {
            let orderDetails = cart.map(item => `${item.name} x ${item.quantity} - $${(item.price * item.quantity).toFixed(2)}`).join("\n");
            alert("Your Orders:\n" + orderDetails);
        }
    });

    document.getElementById("logout")?.addEventListener("click", function () {
        localStorage.removeItem("cart");
        alert("You have been logged out.");
        window.location.href = "login.html"; // Redirect to login page (change if needed)
    });

    renderCart();
});




