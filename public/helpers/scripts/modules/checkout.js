import AlertCustom from "./alert.js";
export default function checkout() {
  $(document).on("change", 'input[name="orderexp"]', function (e) {
    e.preventDefault();
    var $this = $(this);
    var block = $this.closest(".monaSaveUserBlock");
    var $check = $this.val();
    if ($check === "yes") {
      block.addClass("show");
      block.find(".monaSaveUserFields").addClass("show");
    } else {
      block.removeClass("show");
      block.find(".monaSaveUserFields").removeClass("show");
    }
    jQuery("body").trigger("update_checkout");
  });

  $(document).on("change", 'input[name="checkshipping"]', function (e) {
    e.preventDefault();
    var $this = $(this);
    var $check = $this.val();
    if ($check === "yes") {
      $this.closest(".c-form-block").addClass("show");
      $(".checkout-field-user").addClass("show");
    } else {
      $this.closest(".c-form-block").removeClass("show");
      $(".checkout-field-user").removeClass("show");
    }
  });

  $(document).on("click", ".mona_popup_coupon", function (e) {
    e.preventDefault();
    var coupon = $(this).data("coupon");
    var loading = $(this);
    if (!loading.hasClass("processing")) {
      $.ajax({
        url: mona_ajax_url.ajaxURL,
        type: "post",
        data: {
          action: "m_append_coupon",
          id: coupon,
        },
        error: function (request) {
          loading.removeClass("processing");
          AlertCustom("error", "Cảnh báo", request.data.mess);
        },
        beforeSend: function (response) {
          loading.addClass("processing");
        },
        success: function (result) {
          loading.removeClass("processing");
          if (result.success === true) {
            AlertCustom("success", "Thành công", result.mess);
            timeout = setTimeout(function () {
              window.location.reload();
            }, 2000);
            clearTimeout(timeout);
          } else {
            AlertCustom("error", "Cảnh báo", result.mess);
          }
        },
      });
    }
  });

  $(document).on(
    "change",
    'input[name="ship_to_different_address"]',
    function (e) {
      e.preventDefault();
      var $this = $(this);
      var block = $this.closest(".monaSaveUserBlock");
      var $check = $this.val();
      if ($check == "1") {
        block.addClass("show");
        block.find(".monaSaveUserFields").addClass("show");
      } else {
        block.removeClass("show");
        block.find(".monaSaveUserFields").removeClass("show");
      }
    }
  );

  $(document).on("click", ".paymentMethodItem", function (e) {
    $(document.body).trigger("wc_fragment_refresh");
    $(document.body).trigger("update_checkout");
  });

  $(document).on("click", ".monaCheckOutCouponButton", function (e) {
    e.preventDefault();
    var value = $(".monaCheckOutCoupon").val();
    var coupon_code = $(".checkout_coupon.woocommerce-form-coupon").find(
      "#coupon_code"
    );
    if (coupon_code) {
      coupon_code.val(value);
      coupon_code.closest("form").trigger("submit");
    }
  });

  $(document).on("click", ".mona_popup_coupon", function (e) {
    e.preventDefault();
    var coupon = $(this).data("coupon");
    var coupon_code = $(".checkout_coupon.woocommerce-form-coupon").find(
      "#coupon_code"
    );
    if (coupon_code) {
      coupon_code.val(coupon);
      coupon_code.closest("form").trigger("submit");
    }
  });

  function mona_cart_fragments(processing) {
    $.ajax({
      url: mona_ajax_url.ajaxURL,
      type: "post",
      data: {
        action: "mona_cart_fragments",
      },
      error: function (request) {
        processing.removeClass("processing");
      },
      beforeSend: function (response) {
        processing.addClass("processing");
      },
      success: function (result) {
        if (result && result.fragments) {
          $.each(result.fragments, function (key, value) {
            console.log(value);
            $(key).replaceWith(value);
          });
        }
        processing.removeClass("processing");
      },
    });
  }

  $(document).on("click", ".monaCheckOutRemakeByJ .count-btn", function (e) {
    $(document.body).trigger("wc_fragment_refresh");
    $(document.body).trigger("update_checkout");
    setTimeout(() => {
      var parent = $(this).closest(".c-col");
      var c_item = $(this).closest(".c-item");
      var product_price = parent.data("product_price");
      var value = parent.find(".count-input").val();
      if (value != "") {
        c_item.find(".c-price.final").html(
          new Intl.NumberFormat("vi-VN", {
            style: "currency",
            currency: "VND",
          }).format(product_price * value)
        );
      }
    }, 2000);
  });

  $(document).on("click", ".monaSaveUserOder", function (e) {
    e.preventDefault();
    var $this = $(this);
    var processing = $(this);
    var formData = $this.closest("form").serialize();
    if (!processing.hasClass("processing")) {
      $.ajax({
        url: mona_ajax_url.ajaxURL,
        type: "post",
        data: {
          action: "mona_user_save_order",
          form: formData,
        },
        error: function (request) {
          processing.removeClass("processing");
        },
        beforeSend: function (response) {
          processing.addClass("processing");
        },
        success: function (result) {
          AlertCustom("success", "Thành công", result.data.mess);
          if (result.success == true) {
            AlertCustom("success", "Thành công", result.data.mess);
          }
          processing.removeClass("processing");
        },
      });
    }
  });

  $(document).on("click", ".monaSaveUserShipping", function (e) {
    e.preventDefault();
    var $this = $(this);
    var processing = $(this);
    var formData = $this.closest("form").serialize();
    if (!processing.hasClass("processing")) {
      $.ajax({
        url: mona_ajax_url.ajaxURL,
        type: "post",
        data: {
          action: "mona_user_save_shipping",
          form: formData,
        },
        error: function (request) {
          processing.removeClass("processing");
        },
        beforeSend: function (response) {
          processing.addClass("processing");
        },
        success: function (result) {
          AlertCustom("success", "Thành công", result.data.mess);
          if (result.success == true) {
            AlertCustom("success", "Thành công", result.data.mess);
          }
          processing.removeClass("processing");
        },
      });
    }
  });

  $(document).on("click", ".monaSaveUserTime", function (e) {
    e.preventDefault();
    var $this = $(this);
    var processing = $(this);
    var formData = $this.closest("form").serialize();
    if (!processing.hasClass("processing")) {
      $.ajax({
        url: mona_ajax_url.ajaxURL,
        type: "post",
        data: {
          action: "mona_user_save_time",
          form: formData,
        },
        error: function (request) {
          processing.removeClass("processing");
        },
        beforeSend: function (response) {
          processing.addClass("processing");
        },
        success: function (result) {
          AlertCustom("success", "Thành công", result.data.mess);
          if (result.success == true) {
            AlertCustom("success", "Thành công", result.data.mess);
          }
          processing.removeClass("processing");
        },
      });
    }
  });

  $(document).on("click", ".monaSaveUserVat", function (e) {
    e.preventDefault();
    var $this = $(this);
    var processing = $(this);
    var formData = $this.closest("form").serialize();
    if (!processing.hasClass("processing")) {
      $.ajax({
        url: mona_ajax_url.ajaxURL,
        type: "post",
        data: {
          action: "mona_user_save_vat",
          form: formData,
        },
        error: function (request) {
          processing.removeClass("processing");
        },
        beforeSend: function (response) {
          processing.addClass("processing");
        },
        success: function (result) {
          AlertCustom("success", "Thành công", result.data.mess);
          if (result.success == true) {
            AlertCustom("success", "Thành công", result.data.mess);
          }
          processing.removeClass("processing");
        },
      });
    }
  });
}
