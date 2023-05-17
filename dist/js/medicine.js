$(document).ready(function () {
  if (localStorage.getItem("createNewMedicine") === "true") {
    // Display the "New Medicine" form here
    localStorage.removeItem("createNewMedicine"); // Clear the flag once it's been used
    newMedicine();
  } else {
    load_list();
  }
  $("#error-message").hide();
  $("#success-message").hide();
  function load_list() {
    $("#button").html("");
    $("#new-btn").show();
    $("#med_list").hide();
    $("#med_stock").show();
    $("#search-bar").show();
    $("#search").val("");
    $(".modal").hide();
    $("#search-bar").attr("data-for", "med");

    // Change the href value
    var newHref = "pdf/medicine-pdf.php";
    $("#print").attr("href", newHref);
    $("#print").show();

    $.ajax({
      url: "php/medicine/function.php",
      type: "POST",
      data: {
        action: "table",
      },
      success: function (data) {
        $("#table-list").html(data);
      },
    });
  }

  function load_stock(dataForValue = "stock") {
    // $(".med_stock").attr("id", "go-back");
    // $(".med_stock").text("Medicine List");

    $("#new-btn").hide();
    $("#med_list").show();
    if(dataForValue != "stock"){
      $("#med_stock").show();
    }else{
      $("#med_stock").hide();
    } 
    $("#search-bar").show();
    $("#search").val("");
    $(".modal").hide();
    $("#search-bar").attr("data-for", "med_stock");

    var outOfStockBtn =
      '<button type="button" data-for = "outofstock" id="out_of_stock" class="stock out_of_stock border border-red-500 py-1 px-3 bg-red-500 text-white rounded-md hover:bg-red-600">Out of Stock</button>';

    var expiredMedBtn =
      '<button type="button" data-for = "expiredmed" id="expired_med" class="stock expired_med border border-yellow-500 py-1 px-3 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">Expired Medicine</button>';

    // Change the href value
    var newHref = "pdf/medicine-stock-pdf.php";
    $("#print").attr("href", newHref);
    $("#print").show();

    $.ajax({
      url: "php/medicine/function.php",
      type: "POST",
      data: {
        action: "stock",
        dataForValue: dataForValue,
      },
      success: function (data) {
        $("#table-list").html(data);
        // Append the buttons as siblings of the search bar
        $("#button").html(outOfStockBtn + " " + expiredMedBtn);
      },
    });
  }

  //display table of medicine stock
  $(document).on("click", ".med_stock", function () {
    var dataForValue = $(this).data("for");
    load_stock(dataForValue);
  });
  //display table of medicine stock
  $(document).on("click", ".stock", function () {
    var dataForValue = $(this).data("for");
    load_stock(dataForValue);
  });
  //display table of medicine stock
  $(document).on("click", "#expired_med", function () {
    var dataForValue = $(this).data("for");
    load_stock(dataForValue);
  });

  $(document).on("click", ".pagination", function () {
    var page = $(this).data("page");
    var action = "table";
    // alert(action);
    if ($(".pagination").attr("data-for") == "med_stock") {
      action = "stock";
    }
    $.ajax({
      url: "php/medicine/function.php",
      type: "POST",
      data: {
        action: action,
        page: page,
      },
      success: function (data) {
        $("#table-list").html(data);
      },
    });
  });

  //Go back to medicine table from medicne stock table
  $(document).on("click", "#go-back", function () {
    load_list();
  });
  $(document).on("click", "#med_list", function () {
    load_list();
  });

  //Delete the medicine
  $(document).on("click", ".delete-btn", function () {
    if (confirm("Do you really want to delete this record ?")) {
      var id = $(this).data("id");
      var actionFor = $(this).data("for");
      var element = this;
      $.ajax({
        url: "php/medicine/function.php",
        type: "POST",
        data: {
          action: "delete",
          actionFor: actionFor,
          id: id,
        },
        success: function (data) {
          if (data == 1) {
            $(element).closest("tr").fadeOut();
            showSuccess("Record deleted Sucessfully.");
          } else {
            showError("Can't Delete Record.");
          }
        },
      });
    }
  });

  //Display form to update
  $(document).on("click", ".edit-btn", function () {
    var id = $(this).data("id");
    var element = $(this);
    var data_for = element.attr("data-for");
    function isEmpty(variable) {
      return $.trim(variable) == "";
    }

    $.ajax({
      url: "php/medicine/addnew.php",
      type: "POST",
      data: {
        id: id,
        action: "edit",
        data_for: data_for,
      },
      success: function (data) {
        if (!isEmpty(data)) {
          $("#new-btn").hide();
          $("#med_stock").show();
          $("#med_list").show();
          $("#search-bar").hide();
          $("#table-list").html(data);
          $("#print").hide();
          if (data_for == "med_stock") {
            $("#search-bar").hide();
            disable("#med_name");
            disable("#med_pack");
            disable("#generic_name");
            disable("#s_name");
          }
        } else {
          load_list();
          showError("Operation Failed.");
        }
      },
    });
  });

  // //Update data to database and go back to table
  // $(document).on("click", "#update-btn", function () {
  //   var med_id = $("#med_id").val();
  //   var med_name = $("#med_name").val();
  //   var med_pack = $("#med_pack").val();
  //   var generic_name = $("#generic_name").val();
  //   var s_name = $("#s_name").val();
  //   var s_id = $("#s_id").val();

  //   var message =
  //     '<div id="error-message" class="absolute rounded-md right-1/2 top-3/4 opacity-60 bg-pms-error text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2">Record Updated</div>';
  //   $.ajax({
  //     url: "php/medicine/function.php",
  //     type: "POST",
  //     data: {
  //       action: "update",
  //       med_id: med_id,
  //       med_name: med_name,
  //       med_pack: med_pack,
  //       generic_name: generic_name,
  //       s_name: s_name,
  //       s_id: s_id,
  //     },
  //     success: function (data) {
  //       if (data == 1) {
  //         load_list();
  //         $("#notice").html(message).hide().fadeIn().delay(4000).fadeOut();
  //       } else {
  //         load_list();
  //         $("#notice").html(message);
  //         $("#error-message").html("Can't Update Record.").slideDown();
  //         $("#notice").fadeIn("fast").delay(4000).fadeOut();
  //       }
  //     },
  //   });
  // });

  //Display form to add
  $(document).on("click", "#new-btn", function () {
    var element = this;
    newMedicine();
  });
  function isEmpty(variable) {
    return $.trim(variable) == "";
  }
  function newMedicine() {
    $.ajax({
      url: "php/medicine/addnew.php",
      type: "POST",
      data: {
        action: "add",
        data_for: "med",
      },
      success: function (data) {
        if (!isEmpty(data)) {
          $("#new-btn").hide();
          $("#med_list").show();
          $("#med_stock").show();
          $("#search-bar").hide();
          $("#print").hide();
          $("#table-list").html(data);
        } else {
          load_list();
          showError("Operation Failed.");
        }
      },
    });
  }

  // add or update to database
  $(document).on("click", "#add-btn, #update-btn", function () {
    // alert("add");
    var action = $(this).attr("id") == "add-btn" ? "add" : "update";
    // var c_id = $("#c_id").val();
    var element = $(this);
    var med_name = $("#med_name").val();
    var med_pack = $("#med_pack").val();
    var generic_name = $("#generic_name").val();
    // var new_supplier = $("#add-supplier").data("details");
    var s_name = $("#s_name").val();
    var s_id = $("#s_id").val();

    // if (med_name === "" || med_pack === "" || generic_name === "" || s_name === "" || s_id === "") {
    //   showError("All fields are required.");
    //   return;
    // }

    var dataObj = {
      action: action,
      med_name: med_name,
      med_pack: med_pack,
      generic_name: generic_name,
      // new_supplier: new_supplier,
    };
    // alert(action);
    if (action == "update") {
      var data_for = element.attr("data-for");
      // alert(data_for);
      dataObj.data_for = data_for;
      if (data_for == "med") {
        dataObj.med_id = $("#med_id").val();
      } else {
        dataObj.stock_id = $("#stock_id").val();
        dataObj.exp_date = $("#exp_date").val();
        dataObj.mrp = parseFloat($("#mrp").val());
        dataObj.qty = parseFloat($("#qty").val());
        dataObj.rate = parseFloat($("#rate").val());

        if (dataObj.mrp < dataObj.rate) {
          showError("MRP should be greater than Rate.");
          return;
        }
        if (dataObj.qty < 0) {
          showError("Quantity can't be less than 0.");
          return;
        }
      }
    }

    dataObj.s_name = s_name;
    dataObj.s_id = s_id;
    $.ajax({
      url: "php/medicine/function.php",
      type: "POST",
      data: dataObj,
      success: function (data) {
        if (action == "add") {
          handleMedData(data);
        } else {
          if (data_for == "med") {
            handleMedData(data);
          } else {
            handleMedStockData(data);
          }
        }
      },
    });
  });

  function handleMedData(data) {
    if (data == 1) {
      load_list();
      showSuccess("Record updated.");
    } else if (data == 2) {
      load_list();
      showError("Medicine already exists.");
    } else if (data == 3) {
      load_list();
      showError("Suppliers already exist.");
    } else if (data == 5) {
      load_list();
      showSuccess("No changes were made.");
    } else {
      load_list();
      showError("Can't add record.");
    }
  }

  function handleMedStockData(data) {
    if (data == 1) {
      // $(".modal").hide();
      // $("#search-bar").show();
      // $("#search").val("");
      load_stock();
      showSuccess("Record updated.");
    } else if (data == 5) {
      load_stock();
      showSuccess("No changes were made.");
    } else if (data == 8) {
      load_stock();
      showError("Mrp must be greater than Rate.");
    } else {
      load_stock();
      showError("Can't Update record.");
    }
  }

  // Show option for supplier name
  $(document).on("keyup click", "#s_name", function () {
    if ($(".modal").is(":visible")) {
      // Check if a modal is visible
      return; // Skip the code if a modal is shown
    }

    var searchValue = $(this).val();
    $.ajax({
      url: "php/medicine/function.php",
      type: "POST",
      data: {
        search: searchValue,
        action: "s_name_option",
      },
      dataType: "JSON",
      success: function (data) {
        // $.parseJSON(data);
        // alert(data.show);
        $("#s-name-results").fadeIn("fast").html(data.list);
        if (
          data.show == 0 &&
          searchValue.length >= 1 &&
          $("#add-supplier").data("details") == 0
        ) {
          $("#add-supplier").show();
        } else {
          $("#add-supplier").hide();
        }
      },
    });
  });

  // If not active fadeout the suggestion
  $(document).on("blur", "#s_name", function () {
    $("#s-name-results").fadeOut();
    // $("#add-supplier").hide();
  });

  //Auto complete name for customer details
  $(document).on("click", "#s-name-results li", function () {
    $("#s_name").val($(this).text());
    $("#s_id").val($(this).attr("data-id"));
    $("#add-supplier").hide();
    $("#s-name-results").fadeOut();
  });

  //Display form to add suppliers
  $(document).on("click", "#add-supplier", function () {
    var element = this;

    var btn = $(".toggle-btn").attr("id");
    var med_id = $("#med_id").val();
    var med_name = $("#med_name").val();
    var med_pack = $("#med_pack").val();
    var generic_name = $("#generic_name").val();
    var s_name = $("#s_name").val();

    function isEmpty(variable) {
      return $.trim(variable) == "";
    }
    if (btn == "update-btn") {
      action = "edit";
    } else {
      action = "add";
    }
    // alert(action);

    $.ajax({
      url: "php/suppliers/new-supplier.php",
      type: "POST",
      data: {
        action: action,
        addition: "supplier-details",
        id: med_id,
        med_name: med_name,
        med_pack: med_pack,
        generic_name: generic_name,
        s_name: s_name,
        data_for: "med",
        act: "Add",
      },
      success: function (data) {
        if (!isEmpty(data)) {
          // alert(data);
          $("#modalcontent").html(data);
          $(".modal").show();
          $("#add-supplier").attr("data-details", "1");
          $("#add-btn").attr("id", "add-btn-supplier");
        } else {
          load_list();
          showError("Operation Failed.");
        }
      },
    });
  });

  //Add data to database and go back to table
  $(document).on("click", "#add-btn-supplier", function () {
    var s_name = $("#s_name").val();
    var s_email = $("#s_email").val();
    var s_address = $("#s_address").val();
    var s_number = $("#s_number").val();

    // Regular expression for validating phone number format
    var phoneNumberRegex = /^(\+977-)?(\d{1,3}-)?\d{7,}$/;

    // Regular expression for validating email format
    var emailRegex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;

    // Perform validation checks
    if (
      s_name.trim() === "" ||
      s_email.trim() === "" ||
      s_address.trim() === "" ||
      s_number.trim() === ""
    ) {
      showError("All fields are required.");
    } else if (!phoneNumberRegex.test(s_number)) {
      showError("Enter a valid phone number.");
    } else if (!emailRegex.test(s_email)) {
      showError("Enter a valid email address.");
    } else {
      $.ajax({
        url: "php/suppliers/add-supplier.php",
        type: "POST",
        data: {
          s_name: s_name,
          s_email: s_email,
          s_address: s_address,
          s_number: s_number,
        },
        success: function (data) {
          switch (data) {
            case "1":
              $(".modal").hide();
              $("#add-btn-supplier").attr("id", "add-btn");
              showSuccess("Record Added Successfully.");
              break;
            case "2":
              $(".modal").hide();
              $("#add-btn-supplier").attr("id", "add-btn");
              showError("Name already exists.");
              break;
            case "3":
              $(".modal").hide();
              $("#add-btn-supplier").attr("id", "add-btn");
              showError("All fields are required.");
              break;
            case "4":
              $(".modal").hide();
              $("#add-btn-supplier").attr("id", "add-btn");
              showError("Enter a valid phone number.");
              break;
            case "7":
              $(".modal").hide();
              $("#add-btn-supplier").attr("id", "add-btn");
              showError("Email already exists.");
              break;
            default:
              $(".modal").hide();
              $("#add-btn-supplier").attr("id", "add-btn");
              showError("Can't add record.");
              break;

              $("#add-btn-supplier").attr("id", "add-btn");
          }
        },
      });
    }
  });

  //live search
  $(document).on("keyup", "#search", function () {
    var search_term = $(this).val();
    var data_for = $("#search-bar").attr("data-for");

    if ($(this).val().length == 0) {
      if (data_for == "med") {
        load_list();
      } else {
        load_stock();
      }
    } else {
      $.ajax({
        url: "php/medicine/live-search.php",
        type: "POST",
        data: {
          data_for: data_for,
          search: search_term,
        },
        success: function (data) {
          $("#table-list").html(data);
        },
      });
    }
  });

  // When the close button is clicked
  $(document).on("click", "#close-modal", function () {
    // Hide the modal
    $(".modal").hide();
    $("#add-btn-supplier").attr("id", "add-btn");
  });

  // When the modal overlay is clicked
  $(document).on("click", ".modal-overlay", function () {
    // Hide the modal
    $(".modal").hide();
    $("#add-btn-supplier").attr("id", "add-btn");
  });

  // When the escape key is pressed
  $(document).on("keyup", function (e) {
    if (e.keyCode === 27) {
      // Hide the modal
      $(".modal").hide();
      $("#add-btn-supplier").attr("id", "add-btn");
    }
  });

  function disable(input) {
    $(input).prop("disabled", true);
  }

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

  
});
