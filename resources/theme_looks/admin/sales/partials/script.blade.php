<script>
    // Define the addToCart function in the global scope
    function addToCart(event, productId, code) {
        event.preventDefault();

        const apiUrl = "/admin/newsales/getItemByBarcodeService";
        const loader = document.querySelector("#loader");
        const loadingCart = document.querySelector(".loadingCart");
        var addToCartButton = event.target;
        // Disable the button to prevent multiple clicks
        addToCartButton.disabled = true;
        let itemCounter = 1;
        if (document.getElementById("default")) {
            var defaultRow = document.getElementById("default").parentElement;
        }

        const barcode = code;
        loader.style.display = "block";

        console.log("Barcode:", barcode);

        axios
            .post(
                apiUrl, {
                    barcode
                , }, {
                    headers: {
                        "Content-Type": "application/json"
                    , }
                , }
            )
            .then(async (response) => {
                const data = await response;

                console.log(response.data);
                setTimeout(() => {
                    loader.style.display = "none";

                    setTimeout(() => {
                        addToCartButton.disabled = false;
                    }, 4000);

                    const nfp = document.querySelector("#nfp");
                    nfp.style.display = "none";

                    const item = response.data;

                    if (item && item.data) {
                        if (defaultRow) {
                            defaultRow.remove();
                        }

                        const existingRow = findExistingRow(item.data.id);

                        if (existingRow) {
                            const quantityInput = existingRow.querySelector(
                                '[name="product_qty[]"]'
                            );
                            const quantityValue = parseInt(quantityInput.value);
                            const newQuantity = quantityValue + parseInt(item.data.min_qty);
                            quantityInput.value = newQuantity;
                            updateTotalAmount(existingRow);
                        } else {
                            const cartContainer = document.querySelector("#itemTableBody");
                            const row = document.createElement("tr");
                            row.className = "bg-white border-bottom cart_container";
                            row.innerHTML = `  
                        <td class="p-0 m-0">${itemCounter}</td>
                        <td class="py-2 m-0 text-start" style="text-align:left">
                        <input type="hidden" name="product_id[]" value="${
                          item.data.id
                        }"> 
                            
                           <a href="#"> 
                           <img class="img-fluid border border-rounted" style="width:50px" src="{{asset('uploads/products')}}/${
                             item.data.thumbnail
                           }" alt="${item.data.thumbnail}">
                           </a>
                            
                            <a target="_blank" href="#">  <span class="fw-bold">${item.data.name}</span> </a>  
                            </td>

                            <td>
                                <div class="align-items-center text-center">
                                    <div class="price-info"   style="line-height:.5">
                                    <p class="original-price"> <strike class="text-danger">${
                                      item.data.published_price
                                    } TK</strike></p> 
                                    <p class="js--prc fw-bolder">${
                                      item.data.sell_price
                                    } TK</p> </div>
                                </div>
                             </td>

                              <td> 
                                    <div class="input-group quantitybox" style="mi-width:100px">
                                        <input type="number" name="product_qty[]" value="${
                                          item.data.min_qty
                                        }" min="${
              item.data.min_qty
            }" max="200" placeholder="Quantity" class="form-control qty" onchange="updateTotalAmount(this.parentElement.parentElement)">
                                    </div>

                                    <input type="hidden" name="product_sell_price[]" value="${
                                      item.data.sell_price
                                    }" class="sell_price"></input>
                                    <input type="hidden" name="discount" step="2" class="basic_product_discount" value="${
                                      item.data.discount_amount
                                    }"></input>
                                    <input type="hidden" name="tax_amount" step="2" class="basic_product_tax_amount" value="${
                                      item.data.tax_amount
                                    }"></input> 
                                    <input type="hidden" name="discount" step="2" class="product_discount" value="${
                                      item.data.discount_amount
                                    }"></input>
                                    <input type="hidden" name="tax_amount" step="2" class="product_tax_amount" value="${
                                      item.data.tax_amount
                                    }"></input>
                                    <input type="hidden" class="total_amount"step="2"  name="product_total_amount" value="${
                                      item.data.min_qty * item.data.sell_price
                                    }"> 
                                    <input type="hidden" name="sell_date" value="${new Date().toLocaleString()}">
                                    <input type="hidden" name="product_name" value="${
                                      item.data.name
                                    }">
                                    </td>

                                    <td>

                                    <button type="button" data-id="${
                                      item.data.id
                                    }" onclick="deleteRow(this)" class="remove btn btn-sm text-danger fs-5"> <i class="fa fa-trash"></i></button>
                                
                                 </td>
                             `;
                            cartContainer.appendChild(row);
                            itemCounter++;
                            updateTotalAmount(row);
                        }
                    } else {
                        if (barcode != " ") {
                            nfp.style.display = "block";
                            nfp.innerHTML = `<span id="notfound"><h6> <span class="text-danger">${barcode}</span> Not found !</h6></span>`;
                        }
                    }
                }, 200);
            })
            .catch((error) => {
                console.error(error);
            });
    }

    //Add to cart button click then check duplicate product to cart then marge
    function findExistingRow(productId) {
        const rows = document.querySelectorAll(".cart_container");
        for (const row of rows) {
            const productIdInput = row.querySelector('[name="product_id[]"]');
            if (productIdInput && productIdInput.value === String(productId)) {
                return row;
            }
        }
        return null;
    }

    //Quantity input then update all data
    function getQuantityFromRow(row) {
        // Create a temporary element to parse the HTML content
        const tempElement = document.createElement("div");
        tempElement.innerHTML = row.outerHTML;

        const quantityInput = tempElement.querySelector('[name="product_qty[]"]');
        return quantityInput ? quantityInput.value : null;
    }

    //});

    //delete the row
    function deleteRow(button) {
        // Get the row that contains the clicked button
        var row = button.parentNode.parentNode;
        // Get the reference to the table
        var table = document.getElementById("itemTable");

        // Delete the row
        table.deleteRow(row.rowIndex);
        updateSummary();
    }

    // Function to update the total amount for a row
    function updateTotalAmount(row) {
        var qty = parseFloat(row.querySelector(".qty").value);
        var sellPrice = parseFloat(row.querySelector(".sell_price").value);
        var discount_amount = parseFloat(row.querySelector(".basic_product_discount").value);
        var tax_amount = parseFloat(row.querySelector(".basic_product_tax_amount").value);

        // Calculate the total amount for the row
        var total_discount = qty * discount_amount;
        var total_tax_amount = qty * tax_amount;
        //var totalAmountwithoutTax = (qty * sellPrice) - total_discount;
        var totalAmount = qty * sellPrice;
        //var totalAmount = 99;

        // Update the total amount input field in the row
        row.querySelector(".total_amount").value = totalAmount.toFixed(2);
        row.querySelector(".product_discount").value = total_discount.toFixed(2);

        row.querySelector(".qty").value = qty;
        row.querySelector(".product_tax_amount").value = total_tax_amount.toFixed(2);
        // console.log("qty" + qty);
        // console.log("sellPrice" + sellPrice);
        // Trigger a recalculation of the summary table
        updateSummary();
    }

    // Function to update the total amount for a row
    function updateServiceCharge() {
        var newgrandTotal = 0;
        var subtotal_amt = 0;
        var subtotal_amt = parseFloat(
            document.getElementById("subtotal_amt").textContent
        );
        // alert(subtotal_amt);

        var service_charge = parseFloat(
            document.getElementById("service_charge").value
        );

        const other_charges_amt = (document.getElementById(
            "other_charges_amt"
        ).textContent = service_charge);

        newgrandTotal = subtotal_amt + service_charge;

        // Update the grand total in the summary table
        document.getElementById("grand_total").textContent = newgrandTotal.toFixed(2);
        // Update the total payable amount input field
        document.getElementById("total_payable_amount").value =
            newgrandTotal.toFixed(2);

        document.getElementById("paid_amount").value = newgrandTotal.toFixed(2);
    }

    function updateSummary() {
        var subtotal = 0;
        var total_qty = 0;
        var grandTotal = 0;
        var product_discount = 0;
        var product_tax = 0;

        // Loop through each row in the item table
        document.querySelectorAll("#itemTableBody tr").forEach(function(row, index) {
            const totalAmount = parseFloat(row.querySelector(".total_amount").value) || 0;
            subtotal += totalAmount;
            const totalProductQty = parseFloat(row.querySelector(".qty").value) || 0;
            total_qty += totalProductQty;

            const all_product_discount = parseFloat(row.querySelector(".product_discount").value) || 0;
            product_discount += all_product_discount;

            const all_product_tax = parseFloat(row.querySelector(".product_tax_amount").value) || 0;
            product_tax += all_product_tax;

            console.log(totalAmount);
        });

        // Other calculations remain unchanged
        const other_charges_amt =
            parseFloat(document.getElementById("other_charges_amt").textContent) || 0;
        grandTotal = subtotal + other_charges_amt + product_tax;

        // Update the subtotal in the summary table
        document.getElementById("subtotal_amt").textContent = subtotal.toFixed(2);
        // Update the total product quantity in the summary table
        document.getElementById("total_product_qty").textContent = total_qty.toFixed(2);

        // Update the total product quantity in the summary table
        document.getElementById("product_discount").textContent = product_discount.toFixed(2);

        // Update the total product quantity in the summary table
        document.getElementById("tax").textContent = product_tax.toFixed(2);

        // Update the grand total in the summary table
        document.getElementById("grand_total").textContent = grandTotal.toFixed(2);
        // Update the total payable amount input field
        document.getElementById("total_payable_amount").value = grandTotal.toFixed(2);
        document.getElementById("paid_amount").value = grandTotal.toFixed(2);
    }

    function updateDiscountToAllAmt() {
        var discountType = document.getElementById("discount_type_all").value;
        var discountValue =
            parseFloat(document.getElementById("discount").value) || 0;

        var subtotalAmt =
            parseFloat(document.getElementById("subtotal_amt").textContent) || 0;
        var discountToAllAmtElement = document.getElementById("discount_to_all_amt");

        if (discountType == 1) {
            // Percentage discount
            var calculatedDiscount = (subtotalAmt * discountValue) / 100;
            discountToAllAmtElement.textContent = calculatedDiscount.toFixed(2);
        } else {
            // Amount discount
            discountToAllAmtElement.textContent = discountValue.toFixed(2);
        }
    }

    document.addEventListener("click", function(event) {
        if (event.target.matches(".quantity-increment")) {
            handleQuantityChange(1);
        } else if (event.target.matches(".quantity-decrement")) {
            handleQuantityChange(-1);
        }
    });

    function handleQuantityChange(increment) {
        var inputField = document.querySelector(".qty");
        var currentValue = parseInt(inputField.value);
        var minValue = parseInt(inputField.getAttribute("min"));
        var maxValue = parseInt(inputField.getAttribute("max"));

        if (!isNaN(currentValue)) {
            var newValue = currentValue + increment;
            if (newValue >= minValue && newValue <= maxValue) {
                inputField.value = newValue;
            }
        }
    }

</script>

<script src="https://cdn.rawgit.com/zxing-js/library/gh-pages/0.17.1/dist/zxing.min.js"></script>;
<script>
    function startBarcodeScanner() {
        const codeReader = new ZXing.BrowserBarcodeReader();

        codeReader
            .decodeFromInputVideoDevice(undefined, "video")
            .then((result) => {
                document.getElementById("BarCodeFormInputGroup").value = result.text;
                codeReader.reset();
                startBarcodeScanner(); // Continue scanning for the next barcode
            })
            .catch((err) => {
                console.error(err);
            });
    }

    // Start the barcode scanner when the page loads
    document.addEventListener("DOMContentLoaded", startBarcodeScanner);

    document.addEventListener("DOMContentLoaded", function() {
        // Add the 'sidebar-collapse' class to the body element
        document.body.classList.add("sidebar-collapse");
    });

    $(document).ready(function() {
        $("#inlineFormInputGroup").on("input", function() {
            event.preventDefault();

            var searchQuery = $("#inlineFormInputGroup").val(); // Get the search query

            $.ajax({
                url: $(this).attr("action"), // Retrieve URL from the form's action attribute
                method: "GET"
                , data: {
                    search: searchQuery
                , }
                , success: function(response) {
                    $("#productContainer").html(""); // Clear previous results
                    if (response.html) {
                        $("#productContainer").html(response.html); // Update with the received HTML content
                    } else {
                        $("#productContainer").html(
                            '<div class="h-50 text-center"><h4 class="fs-4">No Record Found</h4></div>'
                        );
                    }
                }
                , error: function(xhr, status, error) {
                    console.error(error);
                }
            , });
        });


        $("#pagination-links").on("click", "a.page-link", function(event) {
            event.preventDefault();
            var page = $(this).attr("href").split("page=")[1];
            var perPage = 12; // Default value
            fetchPosts(page, perPage); // Pass perPage as a parameter
        });

        function fetchPosts(page, perPage) {
            var currentUrl = window.location.href;
            var ajaxUrl =
                currentUrl +
                (currentUrl.includes("?") ? "&" : "?") +
                "page=" +
                page +
                "&per_page=" +
                perPage;
            $.ajax({
                url: ajaxUrl
                , success: function(data) {
                    $("#item-list").html("");
                    if (data.html) {
                        $("#item-list").html(data.html);
                    } else {
                        $("#item-list").html(
                            '<div class="h-50 text-center"><h4 class="fs-4">No Record Found</h4></div>'
                        );
                    }
                }
            });
        }

    });

</script>
