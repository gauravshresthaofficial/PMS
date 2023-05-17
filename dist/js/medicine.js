$(document).ready(function () {
  if (localStorage.getItem("createNewMedicine") === "true") {
    // Display the "New Medicine" form here
    localStorage.removeItem("createNewMedicine"); // Clear the flag once it's been used
    newMedicine();
    return;
  } else {
    load_list();
  }

  function load_list() {
    if ($(".med_stock").attr("id") != "med_stock") {
      $(".med_stock").attr("id", "med_stock");
      $(".med_stock").text("Medicine Stock");
    }
    $(".modal").hide();
    $("#search-bar").show();
    $("#search").val("");
    $("#search-bar").attr("data-for", "med");

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

  function load_stock() {
    $(".med_stock").attr("id", "go-back");
    $(".med_stock").text("Go Back");

    $("#search-bar").show();
    $("#search").val("");

    $("#search-bar").attr("data-for", "med_stock");

    $.ajax({
      url: "php/medicine/function.php",
      type: "POST",
      data: {
        action: "stock",
      },
      success: function (data) {
        $("#table-list").html(data);
      },
    });
  }

  //display table of medicine stock
  $(document).on("click", ".med_stock", function () {
    load_stock();
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

  //Delete the medicine
  $(document).on("click", ".delete-btn", function () {
    if (confirm("Do you really want to delete this record ?")) {
      var id = $(this).data("id");
      var element = this;
      var message =
        '<div id="error-message" class="absolute rounded-md right-1/2 top-3/4 opacity-60 bg-pms-error text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2">Record Deleted</div>';
      $.ajax({
        url: "php/medicine/function.php",
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
          } else {
            $("#error-message").html("Can't Delete Record.").slideDown();
            // $("#success-message").slideUp();
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
          $("#modalcontent").html(data);
          $(".modal").show();
          if (data_for == "med_stock") {
            disable("#med_name");
            disable("#med_pack");
            disable("#generic_name");
            disable("#s_name");
          }
        } else {
          load_list();
          var message =
            '<div id="error-message" class="absolute rounded-md right-1/2 top-3/4 opacity-60 bg-pms-error text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2">Operation Failed</div>';
          $("#notice").append(message);
          $("#notice").fadeIn("fast").delay(4000).fadeOut();
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
          $("#modalcontent").html(data);
          $(".modal").show();
        } else {
          load_list();
          var message =
            '<div id="error-message" class="absolute rounded-md right-1/2 top-3/4 opacity-60 bg-pms-error text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2">Operation Failed</div>';
          $("#notice").append(message);
          $("#notice").fadeIn("fast").delay(4000).fadeOut();
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
    var new_supplier = $("#add-supplier").data("details");
    var s_name = $("#s_name").val();
    if (new_supplier == 1) {
      var s_email = $("#s_email").val();
      var s_number = $("#s_number").val();
      var s_address = $("#s_address").val();
    } else {
      var s_id = $("#s_id").val();
    }

    var dataObj = {
      action: action,
      med_name: med_name,
      med_pack: med_pack,
      generic_name: generic_name,
      new_supplier: new_supplier,
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
        dataObj.mrp = $("#mrp").val();
        dataObj.qty = $("#qty").val();
        dataObj.rate = $("#rate").val();
      }
    }
    if (new_supplier == 1) {
      dataObj.s_email = s_email;
      dataObj.s_number = s_number;
      dataObj.s_address = s_address;
      dataObj.s_name = s_name;
    } else {
      dataObj.s_name = s_name;
      dataObj.s_id = s_id;
    }

    var message =
      '<div id="error-message" class="absolute rounded-md right-1/2 top-3/4 opacity-60 bg-pms-error text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2">Record Added.</div>';
    $.ajax({
      url: "php/medicine/function.php",
      type: "POST",
      data: dataObj,
      success: function (data) {
        // alert(data);
        if (data == 1) {
          if (data_for == "med") load_list();
          else {
            $(".modal").hide();
            $("#search-bar").show();
            $("#search").val("");
            load_stock();
          }
          $("#notice").append(message);
          if (action == "update") {
            $("#error-message").html("Record Updated").slideDown();
          }
          $("#notice").fadeIn("fast").delay(4000).fadeOut();
        } else if (data == 2) {
          load_list();
          $("#notice").append(message);
          $("#error-message").html("Medicine already exists.").slideDown();
          $("#notice").fadeIn("fast").delay(4000).fadeOut();
        } else if (data == 3) {
          load_list();
          $("#notice").append(message);
          $("#error-message").html("Supplier already exists.").slideDown();
          $("#notice").fadeIn("fast").delay(4000).fadeOut();
        } else if (data == 5) {
          load_list();
          $("#notice").append(message);
          $("#error-message").html("Supplier already exists.").slideDown();
          $("#notice").fadeIn("fast").delay(4000).fadeOut();
        } else {
          load_list();
          $("#notice").append(message);
          $("#error-message").html("Can't Add Record.").slideDown();
          $("#notice").fadeIn("fast").delay(4000).fadeOut();
        }
      },
    });
  });

  // Show option for supplier name
  $(document).on("keyup click", "#s_name", function () {
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
      url: "php/medicine/addnew.php",
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
      },
      success: function (data) {
        if (!isEmpty(data)) {
          // alert(data);
          $("#modalcontent").html(data);
          $(".modal").show();
          $("#add-supplier").attr("data-details", "1");
        } else {
          load_list();
          var message =
            '<div id="error-message" class="absolute rounded-md right-1/2 top-3/4 opacity-60 bg-pms-error text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2">Operation Failed</div>';
          $("#notice").append(message);
          $("#notice").fadeIn("fast").delay(4000).fadeOut();
        }
      },
    });
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
  });

  // When the modal overlay is clicked
  $(document).on("click", ".modal-overlay", function () {
    // Hide the modal
    $(".modal").hide();
  });

  // When the escape key is pressed
  $(document).on("keyup", function (e) {
    if (e.keyCode === 27) {
      // Hide the modal
      $(".modal").hide();
    }
  });

  function disable(input) {
    $(input).prop("disabled", true);
  }
});
