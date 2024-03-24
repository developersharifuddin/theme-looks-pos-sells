const fields = [
  "name",
  "name_bangla",
  "start_date",
  "end_date",
  "discount",
  "discount_type",
  "var_itemBB_id",
];

const buttonLoader = {
  saveOrder: `<button id="save_order" class="btn btn-sm btn-primary">Save Order</button>`,
  updateOrder: `<button id="update_order" class="btn btn-sm btn-primary">Update Order</button>`,
  addproduct: `<button onclick="addproduct()" id="addproduct" class="btn btn-sm btn-primary" disabled><i
                class="las la-plus"></i></button>`,

  preloader: `<button class="btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>`,
};

const publishers = () => {
  const publisherUrl = rootPath + "where_has_product";
  axios
    .get(publisherUrl)
    .then((response) => {
      var data = response.data;
      var html = `<option value="">-- select item --</option>`;
      html += data
        .map(function (publisher) {
          return `<option value="${publisher.id}">${publisher.name_bangla}</option>`;
        })
        .join("");
      $("#publisher").html(html);
      AIZ.plugins.bootstrapSelect("refresh");
    })
    .catch((error) => {
      AIZ.plugins.notify(
        "danger",
        "Something went wrong to load publisher. PLease try again!"
      );
    });
};

const products = (publisherId) => {
  const productUrl = rootPath + "filter_by_publisher/" + publisherId;
  axios
    .get(productUrl)
    .then((response) => {
      var data = response.data;
      var html = `<option value=""> -- select item -- </option>`;
      html += data
        .map(function (book) {
          return `<option value="${book.id}">${book.name_bangla}</option>`;
        })
        .join("");
      $("#book").html(html);
      $("#book").trigger("change");
      AIZ.plugins.bootstrapSelect("refresh");
    })
    .catch((error) => {
      AIZ.plugins.notify(
        "danger",
        "Something went wrong to load Product. PLease try again!"
      );
    });
};

const getBook = async function () {
  const productId = $("#book").val();
  const url = rootPath + "products/" + productId;
  var { data } = await axios.get(url);
  return data;
};

const addEvent_for_remove_table_item = () => {
  $(".removeItem").click(function () {
    $(this).parents("tr").remove();
    calculateAmount();
  });
};

const check_book_already_added = (bookId) => {
  var rows = $("#tableContainer>table>tbody>tr");
  for (row of rows) {
    if ($(row).data("id") == bookId) {
      return true;
    }
  }
  return false;
};

const addproduct = async () => {
  var hasDuplicate = check_book_already_added($("#book").val());
  var addproductContainer = document.getElementById(
    "add_book_button_container"
  );
  if (hasDuplicate) {
    return 0;
  }

  //   addproductContainer.innerHTML = buttonLoader.preloader;
  var publisher = $("#publisher :selected").text();
  var book = await getBook();
  var html = `<tr data-id="${book.id}">
            <td class="text-left">${publisher}</td>
            <td class="text-left">${book.name_bangla}</td>
            <td class="published_price text-right" data-published_price="${book.published_price}">${book.published_price}</td>
            <td class="discount text-right" data-discount="${book.discount}">${book.discount}</td>
            <td class="unit_price text-right" data-unit_price="${book.unit_price}">${book.unit_price}</td>
            <td class="text-right">${book.purchase_price}</td>
            <td class="text-center"><a href="javascript:void(0)" class="removeItem text-danger" style="font-size:25px"><i class="las la-trash"></i></a></td>
        </tr>`;
  $("#tableContainer>table>tbody").append(html);
  addproductContainer.innerHTML = buttonLoader.addproduct;
  addEvent_for_remove_table_item();
  calculateAmount();
};

const calculateAmount = () => {
  var rows = $("#tableContainer>table>tbody>tr");
  var unit_price = 0;
  var total_price = 0;
  var discount = $("#discount").val() ? $("#discount").val() : 0;
  var discount_amount = 0;
  var discount_type = $("#discount_type").val();
  for (row of rows) {
    unit_price += $(row).find(".unit_price").data("unit_price");
  }

  if (discount_type == 1) {
    discount_amount = (unit_price * discount) / 100;
  } else {
    discount_amount = discount;
  }

  total_price = unit_price - discount_amount;
  total_price = total_price.toFixed();
  console.log(unit_price);
  $("#total_unit_price").val(unit_price);
  $("#total_book").val(rows.length);
  $("#total_price").val(total_price);
};

const validation = () => {
  for (let item of fields) {
    var value = $(`#${item}`).val();
    if (item == "end_date") continue;
    if (!value) {
      $(`#${item}`).addClass("is-invalid");
    }
  }
};

const dataset = () => {
  var productId = [];
  const Order = {
    name: $("#name").val(),
    name_bangla: $("#name_bangla").val(),
    start_date: $("#start_date").val(),
    end_date: $("#end_date").val(),
    discount_amount: $("#discount").val(),
    discount_type: $("#discount_type").val(),
    total_amount: $("#total_price").val(),
    total_unit_price: $("#total_unit_price").val(),
    image: $("#image").val(),
    var_itemBB_id: $("#var_itemBB_id").val(),
  };

  for (row of $("#tableContainer>table>tbody>tr")) {
    productId.push($(row).data("id"));
  }

  return {
    Order,
    productId,
  };
};

$("#publisher").change(function () {
  products(this.value);
});

$(document).ready(function () {
  publishers();

  for (let item of fields) {
    $(document).on("input", `#${item}`, function () {
      if ($(this).hasClass("is-invalid")) {
        $(this).removeClass("is-invalid");
      }
    });
  }
});

$("#book").change(function () {
  if (this.value) {
    $("#addproduct").prop("disabled", false);
  } else {
    $("#addproduct").prop("disabled", true);
  }
});

$("#discount_type").change(function () {
  calculateAmount();
});

$(document).on("input", "#discount", function () {
  calculateAmount();
});

$(document).on("change", "#start_date", function () {
  var start_date = $("#start_date").val();
  var end_date = $("#end_date").val();
  if (!end_date) {
    return 0;
  }

  if (start_date > end_date) {
    $("#end_date").addClass("is-invalid");
    AIZ.plugins.notify("danger", "End date must be greater than start date");
  }
});

$(document).on("change", "#end_date", function () {
  var start_date = $("#start_date").val();
  var end_date = $("#end_date").val();

  if (!end_date) {
    return 0;
  }

  if (start_date > end_date) {
    $("#end_date").addClass("is-invalid");
    AIZ.plugins.notify("danger", "End date must be greater than start date");
  }
});

const saveOrder = () => {
  validation();
  if ($(".is-invalid").length) {
    AIZ.plugins.notify("danger", "Invalid Order Information");
    return 0;
  }
  var rows = $("#tableContainer>table>tbody>tr").length;
  if (rows <= 1) {
    AIZ.plugins.notify("danger", "Minimun quantity of book is 2");
    return 0;
  }

  $("#save_order_container").html(buttonLoader.preloader);
  axios
    .post(saveUrl, dataset())
    .then((response) => {
      $("#save_order_container").html(buttonLoader.saveOrder);

      AIZ.plugins.notify("success", "Successfully Order created");

      setInterval(() => {
        window.location.href = indexUrl;
      }, 600);
    })
    .catch((error) => {
      $("#save_order_container").html(buttonLoader.saveOrder);
      AIZ.plugins.notify("danger", "Given data was invalid");
      $("#save_order").click(saveOrder);
    });
};

const updateOrder = () => {
  validation();
  if ($(".is-invalid").length) {
    AIZ.plugins.notify("danger", "Invalid Order Information");
    return 0;
  }
  var rows = $("#tableContainer>table>tbody>tr").length;
  if (rows <= 1) {
    AIZ.plugins.notify("danger", "Minimun quantity of book is 2");
    return 0;
  }

  $("#update_order_container").html(buttonLoader.preloader);
  axios
    .put(updateUrl, dataset())
    .then((response) => {
      $("#update_order_container").html(buttonLoader.updateOrder);
      AIZ.plugins.notify("success", "Order updated successfully");
      setTimeout(() => {
        // window.location.reload();
        window.location.href = indexUrl;
      }, 600);
    })
    .catch((error) => {
      $("#update_order_container").html(buttonLoader.updateOrder);
      AIZ.plugins.notify("danger", "Something went wrong please try again");
      $("#update_order").click(updateOrder);
    });
};

$("#save_order").click(saveOrder);
$("#update_order").click(updateOrder);
