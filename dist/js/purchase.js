$(document).ready(function () {
  function load_list() {
    if ($(".toggle-id").attr("id") != "manage-invoice") {
      $(".toggle-id").attr("id", "manage-invoice");
      $(".toggle-id").text("Manage Purchases");
    }
    $("#sap").hide();
    $("#calculate").show();
    $(".search-bar").hide();
    // $("#search").val("");

    $.ajax({
      url: "php/purchases/new-purchase.html",
      type: "POST",
      success: function (data) {
        $("#new-purchase").html(data).slideDown();
        // invoice_number();
      },
    });
  }
  load_list();

  // Show option for supplier name
  $(document).on("click keyup", "#s_name", function () {
    var searchValue = $(this).val();

    $.ajax({
      url: "php/purchases/autocomplete.php",
      type: "POST",
      data: {
        search: searchValue,
        for: "name",
        of: "suppliers",
        attr: "s_name",
      },
      success: function (data) {
        $("#s-name-results").fadeIn("fast").html(data);
      },
    });
  });

  // If not active fadeout the suggestion
  $(document).on("blur", "#s_name", function () {
    $("#s-name-results").fadeOut();
  });

  // Show option for medicine name
  $(document).on("click keyup", ".med_name", function () {
    var searchValue = $(this).val();
    var parentDiv = $(this).closest(".med-row");
    var medResults = parentDiv.find(".med-results");
    // var div = '<div id="med-results" class="med_results relative"></div>';

    if (searchValue.length >= 1) {
      $.ajax({
        url: "php/invoice/autocomplete.php",
        type: "POST",
        data: {
          search: searchValue,
          for: "name",
          of: "medicine",
          attr: "med_name",
        },
        success: function (data) {
          medResults.fadeIn("fast").html(data);
        },
      });
    } else {
      medResults.fadeOut();
    }
  });

  // If not active fadeout the suggestion
  $(document).on("blur", ".med_name", function () {
    $(".med-results").fadeOut();
  });

  //Auto complete name for supplier details
  $(document).on("click", "#s-name-results li", function () {
    var s_name = $("#s_name");
    s_name.val($(this).text());
    var s_id = $(this).attr("data-id");
    $(".s-name-results").fadeOut();
    $("#s_id").val(s_id);
  });

  //Auto complete name for medicine details
  $(document).on("click", ".med-results li", function () {
    var parentDiv = $(this).closest(".med-row");
    var med_name = parentDiv.find(".med_name");
    med_name.val($(this).text());
    $(".med-results").fadeOut();
  });

  //add row for another medicine
  $(document).on("click", "#add_med", function (e) {
    e.preventDefault();
    // make all .med-results empty and fade out
    $(".med-results").empty().fadeOut(200);
    var row = $(".med_list .med-row:last").clone();

    row.find("input").val("");
    row.find('input:not([id="remove_med"])').val("");
    var addBtn = $(".add-btn");
    var num = $("#add_med").data("num");
    num++;

    addBtn.remove();
    $(".med_list").append(row);
    row.hide().slideDown(200);

    $(".med_list").append(addBtn);
    $("#add_med").data("num", num);
  });

  // Remove row
  $(document).on("click", "#remove_med", function (e) {
    e.preventDefault();
    var parentDiv = $(this).closest(".med-row");
    if ($(".med_list .med-row").length > 1) {
      parentDiv.slideUp(100, function () {
        parentDiv.remove();
      });
      // parentDiv.remove();
    }
  });

  //Calculation of total on entry of qty
  $(document).on("keyup", ".med_qty", function () {
    var parentDiv = $(this).closest(".med-row");
    medTotalcal(parentDiv);
    cal();
  });

  //Calculation of total on entry of mrp
  $(document).on("keyup", ".med_rate", function () {
    var parentDiv = $(this).closest(".med-row");
    medTotalcal(parentDiv);
    cal();
  });

  function cal() {
    var total = 0;

    $(".med_total").each(function () {
      if ($(this).val() != "") {
        total += parseFloat($(this).val());
      }
    });
    $("#total").val(total);
  }

  $(document).on("click", "#calculate", function (e) {
    e.preventDefault();
    
    var s_name = $("#s_name").val();
    alert(s_name);
    var invoice_number = $("#invoice_number").val();
    var purchase_date = $("#purchase_date").val();
    var total = $("#total").val();

    if (checkInputs()) {
      var medicineArr = [];

      // Loop through the medicine rows and add them to the array
      var medicineArr = [];

      // Loop through the medicine rows and add them to the array
      $(".med-row").each(function () {
        var medName = $(this).find('input[name="med_name[]"]').val().trim();
        var expDate = $(this).find('input[name="exp_date[]"]').val().trim();
        var qty = parseInt(
          $(this).find('input[name="med_qty[]"]').val().trim()
        );
        var rate = parseFloat(
          $(this).find('input[name="med_rate[]"]').val().trim()
        );
        var mrp = parseFloat(
          $(this).find('input[name="med_mrp[]"]').val().trim()
        );

        // Check if any of the inputs are empty for this row, and skip this iteration if so
        if (
          medName === "" ||
          expDate === "" ||
          isNaN(qty) ||
          isNaN(rate) ||
          isNaN(mrp)
        ) {
          return true; // This is equivalent to the "continue" statement in a regular for loop
        }

        var medicineObj = {
          medName: medName,
          expDate: expDate,
          qty: qty,
          rate: rate,
          mrp: mrp,
        };

        medicineArr.push(medicineObj);
      });

      // Add the medicine array to the data object
      var data = {
        s_name: s_name,
        invoice_number: invoice_number,
        purchase_date: purchase_date,
        total: total,
        medicines: medicineArr,
      };
      alert(s_name);

      // Make the AJAX call
      // $.ajax({
      //   type: "POST",
      //   url: "php/purchases/add-purchase.php",
      //   data: data,
      //   success: function (data) {
      //     alert(data);
      //     // Handle successful response from server
      //     if (data == 1) {
      //       alert("Data inserted");
      //       load_list();
      //     } else {
      //       alert("Data inserted failed");
      //     }
      //   },
      // });
    }
  });

  //check for empty
  function checkInputs() {
    // Check if supplier input is empty
    if ($("#s_name").val().trim() === "") {
      alert("Please enter supplier name");
      return false;
    }

    // Check if invoice number input is empty
    if ($("#invoice_number").val().trim() === "") {
      alert("Please enter invoice number");
      return false;
    }

    // Check if purchase date input is empty
    if ($("#purchase_date").val().trim() === "") {
      alert("Please enter purchase date");
      return false;
    }

    // Check if any of the medicine row inputs are empty
    var medNames = $('input[name="med_name[]"]');
    var medQtys = $('input[name="med_qty[]"]');
    var medRates = $('input[name="med_rate[]"]');
    var medMrps = $('input[name="med_mrp[]"]');
    var medTotals = $('input[name="med_total[]"]');

    for (var i = 0; i < medNames.length; i++) {
      if (
        $(medNames[i]).val().trim() === "" ||
        $(medQtys[i]).val().trim() === "" ||
        $(medRates[i]).val().trim() === "" ||
        $(medMrps[i]).val().trim() === ""
      ) {
        if (
          $(medNames[i]).val().trim() === "" &&
          $(medQtys[i]).val().trim() === "" &&
          $(medRates[i]).val().trim() === "" &&
          $(medMrps[i]).val().trim() === ""
        ) {
          // If all inputs for this row are empty, skip this iteration
          continue;
        } else {
          alert("Please fill in all fields for medicine " + (i + 1));
          return false;
        }
      }
    }

    return true;
  }
  function disable(input, value) {
    $(input).val(value);
    $(input).prop("disabled", true);
  }

  function enable(input) {
    $(input).prop("disabled", false);
  }

  //Calculate each medicine total
  function medTotalcal(parentDiv) {
    var qtyValue = parentDiv.find(".med_qty").val();
    var mrpValue = parentDiv.find(".med_rate").val();
    var medTotal = parentDiv.find(".med_total");
    var medTotalValue = medTotal.val();
    if (mrpValue != "") {
      medTotalValue = qtyValue * mrpValue;
    } else {
      medTotalValue = 0;
    }
    medTotal.val(medTotalValue);
  }

  //Display table of Invoice
  $(document).on("click", "#manage-invoice", function () {
    var element = this;

    purchase_list(1);
  });
  function purchase_list(page) {
    if ($(".toggle-id").attr("id") == "manage-invoice") {
      $(".toggle-id").attr("id", "go-back");
      $(".toggle-id").text("New Purchase");
    }

    $("#sap").show();
    $("#calculate").hide();
    $(".search-bar").show();

    $.ajax({
      url: "php/purchases/purchase-list.php",
      type: "POST",
      data: {
        page: page,
      },
      success: function (data) {
      
        $("#new-purchase").html(data).slideDown();
        // $("#new-purchase").slideDown();
      },
    });
  }

  $(document).on("click", ".pagination", function (e) {
    e.preventDefault();
    var page = $(this).data("page");
    purchase_list(page);
  });

  //live search
  $(document).on("keyup", "#search-name", function () {
    var search_term = $(this).val();

    if ($(this).val().length === 0) {
      purchase_list();
    } else {
      search("name", search_term);
    }
  });
  //live search
  $(document).on("keyup", "#search-date", function () {
    var search_term = $(this).val();

    if ($(this).val().length === 0) {
      purchase_list();
    } else {
      search("date", search_term);
    }
  });
  
  function search(value, search_term) {
    $.ajax({
      url: "php/purchases/live-search.php",
      type: "POST",
      data: {
        value: value,
        search: search_term,
      },
      success: function (data) {
        $("#new-purchase").html(data);
      },
    });
  }
  //Go back from invoice table to new invoice
  $(document).on("click", "#go-back", function () {
    load_list();
  });
});


//Delete the medicine
$(document).on("click", ".delete-btn", function () {
  if (confirm("Do you really want to delete this record?")) {
    var id = $(this).data("cid");
    var element = this;
    var num = 1;
    $(".pagination").each(function () {
      if ($(this).hasClass("pms-green-light")) {
        num = $(this).attr("data-page");
      }
    });
    var message =
      '<div id="error-message" class="absolute rounded-md right-1/2 top-3/4 opacity-60 bg-pms-error text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2">Record Deleted</div>';
    $.ajax({
      url: "php/purchases/function.php",
      type: "POST",
      data: {
        action: "delete",
        id: id,
      },
      success: function (data) {
        if (data == 1) {
          $(element).closest("tr").fadeOut();
          $("#notice").append(message);
          $("#notice").fadeIn("fast").delay(4000).fadeOut();
          purchase_list(num);
        } else {
          $("#error-message").html("Can't Delete Record.").slideDown();
          // $("#success-message").slideUp();
        }
      },
    });
  }
});
