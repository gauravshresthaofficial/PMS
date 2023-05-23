$(document).ready(function () {
  $("#error-message").hide();
  $("#success-message").hide();
  var currentDate = new Date().toISOString().slice(0, 10);
  $("#purchase_date").val(currentDate);

  function load_list() {
    if ($(".toggle-id").attr("id") != "manage-invoice") {
      $(".toggle-id").attr("id", "manage-invoice");
      $(".toggle-id").text("Manage Purchases");
    }
    $("#sap").hide();
    $("#calculate").show();
    $(".search-bar").hide();
    $("#error-message").hide();
    $("#success-message").hide();
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

    if (searchValue.length >= 1) {
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
    } else {
      $("#s-name-results").fadeOut();
    }
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
  // $(document).on("click", "#add_med", function (e) {
  //   e.preventDefault();
  //   // make all .med-results empty and fade out
  //   $(".med-results").empty().fadeOut(200);
  //   var row = $(".med_list .med-row:last").clone();

  //   row.find("input").val("");
  //   row.find('input:not([id="remove_med"])').val("");
  //   var addBtn = $(".add-btn");
  //   var num = $("#add_med").data("num");
  //   num++;

  //   addBtn.remove();
  //   $(".med_list").append(row);
  //   row.hide().slideDown(200);

  //   $(".med_list").append(addBtn);
  //   $("#add_med").data("num", num);
  // });

  // Remove row
  // $(document).on("click", "#remove_med", function (e) {
  //   e.preventDefault();
  //   var parentDiv = $(this).closest(".med-row");
  //   if ($(".med_list .med-row").length > 1) {
  //     parentDiv.slideUp(100, function () {
  //       parentDiv.remove();
  //     });
  //     // parentDiv.remove();
  //   }
  // });

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

  // Calculate button click event
  $(document).on("click", "#calculate", function (e) {
    e.preventDefault();

    alert("yes");
    // Check if any field is empty or has invalid value
    var isError = false;
    var data = {
      purchase_date: "",
      total: "",
      medicines: [],
    };
    //input value for total
    data.total = $("#total").val().trim();

    // Check if purchase date input is empty or invalid
    data.purchase_date = $("#purchase_date").val().trim();
    if (data.purchase_date === "") {
      idError("date-error", "Please enter purchase date");
      isError = true;
    } else {
      var validDate = isValidDate(data.purchase_date);
      if (!validDate) {
        idError("date-error", "Please enter a valid purchase date");
        isError = true;
      } else {
        hideError("date-error");
      }
    }
    // Check if any of the medicine row inputs are empty or have invalid values
    var medRows = $(".med-row");
    var nonEmptyRows = 0;

    medRows.each(function (index) {
      var medRow = $(this);
      var medName = medRow.find('input[name="med_name[]"]').val().trim();
      var medQty = parseInt(
        medRow.find('input[name="med_qty[]"]').val().trim()
      );
      var medRate = parseFloat(
        medRow.find('input[name="med_rate[]"]').val().trim()
      );
      var medMrp = parseFloat(
        medRow.find('input[name="med_mrp[]"]').val().trim()
      );
      var medExp = medRow.find('input[name="exp_date[]"]').val().trim();
      var medTotal = medRow.find('input[name="med_total[]"]').val().trim();

      // Skip checking the row if all fields are empty
      if (
        medName === "" &&
        isNaN(medQty) &&
        isNaN(medRate) &&
        isNaN(medMrp) &&
        medExp === ""
      ) {
        if (medRows.length > 1) {
          medRow.hide(); // Hide the row if there are other non-empty rows
        }
        return true; // Skip to the next iteration
      }

      nonEmptyRows++;

      if (medName === "") {
        idError("med_name-error-" + index, "Please enter medicine name");
        isError = true;
      } else {
        hideError("med_name-error-" + index);
      }

      if (isNaN(medQty)) {
        idError("med_qty-error-" + index, "Enter Qty");
        isError = true;
      } else {
        hideError("med_qty-error-" + index);
      }

      if (isNaN(medRate)) {
        idError("med_rate-error-" + index, "Enter Rate");
        isError = true;
      } else {
        hideError("med_rate-error-" + index);
      }

      if (isNaN(medMrp)) {
        idError("med_mrp-error-" + index, "Enter MRP");
        isError = true;
      } else {
        hideError("med_mrp-error-" + index);
      }

      if (medExp === "") {
        idError("exp_date-error-" + index, "Enter expiration date");
        isError = true;
      } else {
        var validExpDate = isValidDate(medExp);
        if (!validExpDate) {
          idError("exp_date-error-" + index, "Enter expiration date");
          isError = true;
        } else {
          var currentDate = new Date();
          var expirationDate = new Date(medExp);
          if (expirationDate < currentDate) {
            idError("exp_date-error-" + index, "Enter valid date");
            isError = true;
          } else {
            hideError("exp_date-error-" + index);
          }
        }
      }
      // Add medicine data to the array
      if (!isError) {
        data.medicines.push({
          medName: medName,
          medQty: medQty,
          medRate: medRate,
          medMrp: medMrp,
          medExp: medExp,
          medTotal: medTotal,
        });
      }
    });

    // Show error if all medicine rows are empty
    if (nonEmptyRows === 0) {
      showError("Please fill in at least one medicine.");
      medRows.first().show(); // Show the first medicine row
      return;
    }
    alert(isError);

    if (!isError) {
      var jsonData = JSON.stringify(data);

      // Display the encoded JSON in an alert
      alert(jsonData);
      // Perform AJAX call
      $.ajax({
        url: "php/purchases/add-purchase.php",
        method: "POST",
        data: data,
        success: function (response) {
          alert(response);
          if (response === "0") {
            showError("Can't add purchases");
          } else if (response === "1") {
            showSuccess("Purchase successful");

            // Empty all input fields
            $("input[type='text']").val("");
            $("input[type='number']").val("");
            $("input[type='date']").val("");
          } else {
            showError(response);
          }
        },
      });
    }
  });

  // Show error message
  function idError(elementId, errorMessage) {
    $("#" + elementId).text(errorMessage);
  }

  // Hide error message
  function hideError(elementId) {
    $("#" + elementId).empty();
  }

  // Check if the date is valid
  function isValidDate(dateString) {
    var dateRegex = /^\d{4}-\d{2}-\d{2}$/;
    if (!dateRegex.test(dateString)) {
      return false;
    }

    var parts = dateString.split("-");
    var year = parseInt(parts[0]);
    var month = parseInt(parts[1]);
    var day = parseInt(parts[2]);

    // JavaScript months are 0-based, so subtract 1 from the month
    var date = new Date(year, month - 1, day);

    // Check if the year, month, and day are valid
    return (
      date.getFullYear() === year &&
      date.getMonth() === month - 1 &&
      date.getDate() === day
    );
  }

  // Add row for another medicine
  $(document).on("click", "#add_med", function (e) {
    e.preventDefault();
    // Make all .med-results empty and fade out
    $(".med-results").empty().fadeOut(200);

    var row = $(".med_list .med-row:last").clone();
    row.find("input").val("");

    // Empty all error divs in the new row
    row.find(".med-error").empty(); // Assuming the class name for the error divs is "med-error"

    var addBtn = $(".add-btn");
    var num = $("#add_med").data("num");
    num++;

    addBtn.remove();
    $(".med_list").append(row);
    row.hide().slideDown(200);

    $(".med_list").append(addBtn);
    $("#add_med").data("num", num);

    // Update the error IDs for the new row
    var index = $(".med_list .med-row").length - 1;
    row.find(".med_name-error").attr("id", "med_name-error-" + index);
    row.find(".exp_date-error").attr("id", "exp_date-error-" + index);
    row.find(".med_qty-error").attr("id", "med_qty-error-" + index);
    row.find(".med_rate-error").attr("id", "med_rate-error-" + index);
    row.find(".med_mrp-error").attr("id", "med_mrp-error-" + index);
  });

  // Remove row
  $(document).on("click", ".remove_med", function (e) {
    e.preventDefault();
    var parentDiv = $(this).closest(".med-row");
    if ($(".med_list .med-row").length > 1) {
      parentDiv.slideUp(100, function () {
        parentDiv.remove();
      });
    }
  });

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
          showSuccess("Record Deleted.");
          purchase_list(num);
        } else {
          showError("Can't Delete Record.");
          // $("#success-message").slideUp();
        }
      },
    });
  }
});

var errorContainer = $("#error-message");
var successContainer = $("#success-message");
var successTimeout;
var errorTimeout;

// Function to show a message in the specified container
function showMessage(container, message) {
  // Hide any existing message before showing the new one
  errorContainer.add(successContainer).hide().empty();

  // Set the message and show it
  container.html(message).slideDown();
}

// Function to show an error message
function showError(message) {
  clearTimeout(errorTimeout); // Clear any existing timeout

  // Show the error message
  showMessage(errorContainer, message);

  // Set a timeout to hide the error message after 4 seconds
  errorTimeout = setTimeout(function () {
    errorContainer.slideUp(function () {
      // Delete the HTML content
      errorContainer.empty();
    });
  }, 4000);
}

// Function to show a success message
function showSuccess(message) {
  clearTimeout(successTimeout); // Clear any existing timeout

  // Show the success message
  showMessage(successContainer, message);

  // Set a timeout to hide the success message after 4 seconds
  successTimeout = setTimeout(function () {
    successContainer.slideUp(function () {
      // Delete the HTML content
      successContainer.empty();
    });
  }, 4000);
}
