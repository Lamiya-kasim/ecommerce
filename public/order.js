document.addEventListener("DOMContentLoaded", function () {
    fetch("http://127.0.0.1:8000/api/orders")
    .then(res => res.json())
    .then(orders => {
        let table = document.getElementById("orders-table");

        orders.forEach(order => {
            let row = document.createElement("tr");
            row.innerHTML = `
                <td>${order.customer_name}</td>
                <td>${order.customer_email}</td>
                <td>${order.customer_address}</td>
                <td>${order.payment_method}</td>
                <td>$${order.total_price.toFixed(2)}</td>
                <td>
                    ${order.items.map(item => `${item.product_name || item.name} (${item.quantity})`).join(", ")}
                </td>
            `;
            table.appendChild(row);
        });
    })
    .catch(error => console.error("Error fetching orders:", error));

});
