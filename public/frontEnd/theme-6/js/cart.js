$(document).ready(function () {
    $(document).on("click", ".add_to_cart, .order_now", function (e) {
        e.preventDefault();
        let product_id = $(this).data("id");
        let slug = $(this).data("slug");
        let stock = $(this).data("stock");
        let action = $(this).hasClass("order_now") ? "order" : "cart";
        let qty = parseInt($(".qty-input").val()) || 1;
        const hasVariant = $(this).data("has_variant");
        if (hasVariant) {
            window.location.href = getRoute("productUrl").replace(
                ":slug",
                slug,
            );
            return;
        }
        // console.log(qty);
        if (stock == 0) {
            Swal.fire({
                icon: "warning",
                title: "স্টক শেষ!",
                html: `
                            <p>দুঃখিত, এই প্রোডাক্টটি বর্তমানে স্টকে নেই।</p>
                            <p>প্রি-অর্ডার করতে আমাদের হটলাইনে যোগাযোগ করুন 😔</p>
                            <br>
                            <span>হটলাইন: <a href="tel:017XXXXXXXX"
                            style="text-decoration:none; display:inline-block;">
                                017XXXXXXXX
                            </a></span>
                        `,
                timerProgressBar: true,
                showCancelButton: false,
                confirmButtonText: "ঠিক আছে",
            });
            return;
        }
        $.ajax({
            url:
                action === "order" ? getRoute("buyNow") : getRoute("addToCart"),
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                id: product_id,
                qty: qty,
            },
            success: function (res) {
                if (res.status == true) {
                    Swal.fire({
                        icon: "success",
                        title: "Successfully!",
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false,
                    });

                    $(".header-final-cart-count").text(res.cart_count);

                    if (action === "order") {
                        window.location.href = getRoute("checkout");
                    }
                }
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "সমস্যা হয়েছে!",
                    text: xhr.responseJSON?.message ?? "আবার চেষ্টা করুন",
                });
            },
        });
    });

    $(document).on("click", ".remove-cart-item", function () {
        let id = $(this).data("id");
        let url = getRoute("removeCart");
        $.ajax({
            url: url,
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                id: id,
            },
            success: function (res) {
                if (res.status == true) {
                    $(".header-final-cart-count").text(res.cart_count);
                    toastr.options.positionClass = "toast-bottom-right";
                    toastr.success("প্রোডাক্ট ডিলিট হয়েছে");
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText); // helpful for debugging
            },
        });
    });

    $(document).on("click", ".qtybtn", function () {
        let parent = $(this).closest(".item-quantity");
        let id = parent.data("id");
        let input = parent.find(".quantity-input");
        let qty = parseInt(input.val());
        if ($(this).hasClass("inc")) qty++;
        if ($(this).hasClass("dec") && qty > 1) qty--;
        let url = getRoute("updateQty");
        input.val(qty);
        $.ajax({
            url: url,
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                id: id,
                qty: qty,
            },
            success: function (res) {
                if (res.status == true) {
                    loadCartDropdown();
                    $(".header-final-cart-count").text(res.cart_count);
                    // position change
                    toastr.options.positionClass = "toast-top-right";

                    // success message
                    toastr.success("প্রোডাক্ট আপডেট হয়েছে");
                }
            },
        });
    });
});
