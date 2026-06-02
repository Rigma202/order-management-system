
document.addEventListener("DOMContentLoaded", function () {
    const addBtn = document.getElementById("addRow");
    const tbody = document.getElementById("orderItems");

    addBtn.addEventListener("click", function () {

        const firstRow = document.querySelector(".order-row");
        const newRow = firstRow.cloneNode(true);
        newRow.querySelector(".product").value = "";
        newRow.querySelector(".qty").value = 1;
        newRow.querySelector(".price").innerText = "₹ 0.00";

        tbody.appendChild(newRow);
        updateProductOptions();
    });

    tbody.addEventListener("click", function (e) {
        if (e.target.classList.contains("removeRow")) {
            const rows = document.querySelectorAll(".order-row");

            if (rows.length > 1) {
                e.target.closest("tr").remove();
                calculateTotal();
                updateProductOptions();
            }
        }
    });

});

document.addEventListener("change", function (e) {

    if (e.target.classList.contains("product")) {
        updateProductOptions();
    }
    if (e.target.classList.contains("product") || e.target.classList.contains("qty")) {

        const row = e.target.closest("tr");
        const productSelect = row.querySelector(".product");
        const qty = row.querySelector(".qty").value;
        const price = productSelect.selectedOptions[0]?.dataset.price || 0;
        const subtotal = price * qty;
        row.querySelector(".price").innerText = "₹ " + parseFloat(subtotal).toFixed(2);

        calculateTotal();
    }

});

function calculateTotal() {
    let total = 0;
    document.querySelectorAll(".order-row").forEach(row => {
        const sub = row.querySelector(".price").innerText.replace("₹", "");
        total += parseFloat(sub || 0);
    });

    document.getElementById("totalAmount").innerText = total.toFixed(2);
}


document.getElementById("orderForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let customer_id = $("#customer_id").val();

    let items = [];

    $(".order-row").each(function () {

        let product_id = $(this).find(".product").val();
        let qty = $(this).find(".qty").val();
        let priceText = $(this).find(".price").text().replace("₹", "").trim();
        let subtotal = parseFloat(priceText);

        if (product_id && qty > 0) {
            items.push({
                product_id: product_id,
                quantity: qty,
                price: subtotal
            });
        }
    });

    let total = $("#totalAmount").text();
console.log(total,items);

    $.ajax({
        url: "/orders",
        type: 'POST',
        data: {
            customer_id: customer_id,
            total_amount: total,
            items: items
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
                Swal.fire({
                title: 'Order Created!',
                text: 'Your order has been created successfully.',
                icon: 'success',
                confirmButtonText: 'OK'
                }).then(() => {
                window.location.href = "/orders";
                });

        },
        error: function (xhr) {

            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $('.text-danger').text('');

                if (errors.customer_id) {
                    $('#customer_error').text(errors.customer_id[0]);
                }
                if (errors.items) {
                    $('#items_error').text(errors.items[0]);
                }

                if (errors['items.0.product_id']) {
                    alert(errors['items.0.product_id'][0]);
                }
            }
        }
    });
});
function updateProductOptions() {

    let selectedProducts = [];
    document.querySelectorAll(".product").forEach(select => {
        if (select.value) {
            selectedProducts.push(select.value);
        }
    });
    document.querySelectorAll(".product").forEach(select => {
        const currentValue = select.value;
        select.querySelectorAll("option").forEach(option => {
            if (!option.value) return;
            option.disabled = false;
            if (
                option.value !== currentValue &&
                selectedProducts.includes(option.value)
            ) {
                option.disabled = true;
            }
        });

    });
}
