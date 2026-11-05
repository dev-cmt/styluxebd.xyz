document.addEventListener("DOMContentLoaded", function () {
    // Scroll-to-top button logic with passive event listener and throttling
    var backToTopButton = document.getElementById("scroll-to-top");
    if (backToTopButton) {
        let scrollTimeout;
        window.addEventListener(
            "scroll",
            function () {
                // Use requestAnimationFrame for throttling scroll event handling
                if (scrollTimeout) return;
                scrollTimeout = true;
                requestAnimationFrame(function () {
                    backToTopButton.style.display =
                        window.scrollY > 300 ? "block" : "none";
                    scrollTimeout = false;
                });
            },
            { passive: true },
        );

        backToTopButton.addEventListener("click", function (event) {
            event.preventDefault();
            window.scrollTo({ top: 0, behavior: "smooth" });
        });
    }
});

(function () {
    // Desktop sticky header
    const headerWrapper = document.getElementById(
        "header-final-header-wrapper",
    );
    if (headerWrapper) {
        const placeholder = document.createElement("div");
        const onScroll = () => {
            placeholder.style.height = headerWrapper.offsetHeight + "px";
            if (window.scrollY > 200) {
                if (!headerWrapper.classList.contains("is-sticky")) {
                    headerWrapper.parentNode.insertBefore(
                        placeholder,
                        headerWrapper,
                    );
                    headerWrapper.classList.add("is-sticky");
                }
            } else {
                if (headerWrapper.classList.contains("is-sticky")) {
                    if (document.body.contains(placeholder)) {
                        headerWrapper.parentNode.removeChild(placeholder);
                    }
                    headerWrapper.classList.remove("is-sticky");
                }
            }
        };
        window.addEventListener("scroll", onScroll, { passive: true });
    }
})();

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
let couponAppliedSubtotal = null;
function calculate_total() {
    let charge = Number(
        $('input[name="delivery_charge_id"]:checked').data("charge"),
    );
    let baseSubtotal =
        couponAppliedSubtotal !== null
            ? couponAppliedSubtotal
            : Number($(document).find("#subtotal").val());

    let final_total = baseSubtotal + charge;

    $(document).find("#delivery-charge-display").text(priceFormate(charge));
    $(document).find("#total-display").text(priceFormate(final_total));
    $(document).find("input#amount").val(final_total);
}
function priceFormate(amount) {
    if (Number.isInteger(amount)) {
        return amount.toFixed(0) + " TK";
    } else {
        return amount.toFixed(2) + " TK";
    }
}

$(document).on("change", 'input[name="delivery_charge_id"]', function () {
    $('input[name="delivery_charge_id"]').not(this).prop("checked", false);
    calculate_total();
});

$(document).on("click", "span.qtybtn", function () {
    var $button = $(this);
    var oldValue = $button.parent().find("input").val();
    var newVal = $button.hasClass("inc")
        ? parseFloat(oldValue) + 1
        : Math.max(parseFloat(oldValue) - 1, 1);
    $button.parent().find("input").val(newVal);

    let url = $button.closest("div").attr("data-href");
    let segment = $button.closest("div").attr("data-segment");

    if (typeof url !== "undefined") {
        $.ajax({
            url: url,
            method: "GET",
            data: { quantity: newVal, segment: segment },
            success: function (res) {
                if (res.success) {
                    toastr.success(res.msg);
                    $("div#cart-dropdown").html(res.html);
                    $(document).find("div.orderDetails").html(res.html2);
                    $(document).find("div.cart_other_details").html(res.html3);
                    couponAppliedSubtotal = null; // reset coupon if quantity changes
                } else {
                    toastr.error(res.msg);
                }
                calculate_total();
            },
        });
    }
});
// 🎟️ COUPON STUFF
$(document).on("click", "#couponBtn", function (e) {
    e.preventDefault();
    $("span.textdanger").remove();

    let code = $("#couponInput").val().trim();

    if (code.length > 0) {
        $.ajax({
            type: "GET",
            url: "/coupon-discount",
            data: { code: code },
            success: function (res) {
                if (res.success) {
                    toastr.success(res.msg);
                    couponAppliedSubtotal = parseFloat(res.final_amount) || 0;
                    $("#subtotal").val(couponAppliedSubtotal); // update input
                    calculate_total(); // update with new subtotal
                } else {
                    toastr.error(res.msg);
                }
            },
            error: function (response) {
                $.each(
                    response.responseJSON.errors,
                    function (field_name, error) {
                        $("[name=" + field_name + "]").after(
                            '<span class="textdanger" style="color:red">' +
                                error +
                                "</span>",
                        );
                    },
                );
            },
        });
    } else {
        toastr.error("Please enter a coupon code.");
    }
});

$(document).on("keypress", "#couponInput", function (e) {
    if (e.which === 13) {
        e.preventDefault();
        $("#couponBtn").trigger("click");
    }
});

$(document).ready(function () {
    calculate_total();
});

toastr.options = {
    debug: false,
    positionClass: "toast-bottom-right",
    onclick: null,
    fadeIn: 300,
    fadeOut: 1000,
    timeOut: 5000,
    extendedTimeOut: 1000,
};
