$(() => {
  const showAlert = () => {
    setTimeout(() => {
      $(".alert-count").fadeIn(1500);
    }, 100);

    setTimeout(() => {
      $(".alert-count").fadeOut(2000);
    }, 3000);
  };

  const cartCountReload = () => {
    $.ajax({
      url: "/shop/cart/count",
      method: "POST",
      success(data) {
        if (data.status) {
          $("#cart-item-count").html(data.value);
          if ($("#cart-pjax").length) {
            cartReload();
          }
        }
      },
    });
  };

  const cartReload = () =>
    $.pjax.reload("#cart-pjax", {
      push: false,
      timeout: 5000,
    });

  const productAdd = (el) =>
    $.ajax({
      url: el.attr("href"),
      success(data) {
        if (data.status) {
          cartCountReload();
        } else {
          showAlert();
        }
      },
    });

  $("#catalog-pjax, #view-product").on("click", " .btn-add-cart",  function (e) {    
      productAdd($(this));
      return false;
    }
  );

$("#catalog-pjax").on("click", ".product-card", function (e) {
  if ($(e.target).hasClass("btn-add-cart")) {     
    productAdd($(e.target));
    return false;
  }

  const url = $(this).data("url");
  if (url) {
    location.assign(url);
  }
});

  $("#cart-pjax").on(
    "click",
    ".btn-item-remove, .btn-item-del, .btn-item-add, .btn-item-clear, .btn-cart-clear",
    function (e) {
      e.preventDefault();
      productAdd($(this));
      return false;
    }
  );

  $("#cart-pjax").on("pjax:end", () => {
    if ($(".alert-cart-empty").length) {
      $(".btn-order-create").addClass("d-none");
    }
  });

  cartCountReload();
});
