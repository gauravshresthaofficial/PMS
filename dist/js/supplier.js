$(document).ready(function () {
  if (localStorage.getItem("createNewSupplier") === "true") {
    // Display the "New Supplier" form here
    localStorage.removeItem("createNewSupplier"); // Clear the flag once it's been used
    newSupplier();
  } else {
    load_list();
  }
  $("#error-message").hide();
  $("#success-message").hide();
  function load_list() {
    if ($(".toggle-id").attr("id") != "new-btn") {
      $(".toggle-id").attr("id", "new-btn");
      $(".toggle-id").text("New Supplier");
    }
    $("#print").fadeIn();
    $("#search-bar").fadeIn();
    $(".search").val("");

    $.ajax({
      url: "php/suppliers/suppliers-list.php",
      type: "POST",
      success: function (data) {
        $("#suppliers-list").html(data);
      },
    });
  }

  $(document).on("click", ".pagination", function () {
    page = $(this).data("page");
    $.ajax({
      url: "php/suppliers/suppliers-list.php",
      type: "POST",
      data: {
        page: page,
      },
      success: function (data) {
        $("#suppliers-list").html(data);
      },
    });
  });

  $(document).on("click", "#go-back", function () {
    load_list();
  });

  $(document).on("click", ".delete-btn", function () {
    if (confirm("Do you really want to delete this record ?")) {
      var sid = $(this).data("sid");
      var element = this;
      $.ajax({
        url: "php/suppliers/delete-supplier.php",
        type: "POST",
        data: {
          sid: sid,
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
    var s_id = $(this).data("eid");
    var element = this;

    function isEmpty(variable) {
      return $.trim(variable) == "";
    }

    if ($(".toggle-id").attr("id") == "new-btn") {
      $(".toggle-id").attr("id", "go-back");
      $(".toggle-id").text("Go Back").fadeIn();
    }

    $("#print").hide();
    $("#search-bar").hide();

    $.ajax({
      url: "php/suppliers/new-supplier.php",
      type: "POST",
      data: {
        s_id: s_id,
        act: "edit",
      },
      success: function (data) {
        $("#suppliers-list").html(data);
      },
    });
  });

  // Update data to database and go back to table
  $(document).on("click", "#update-btn", function () {
    var s_id = $("#s_id").val();
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
      s_address.trim() === "" ||
      s_number.trim() === "" ||
      s_email.trim() === ""
    ) {
      showError("All fields are required.");
    } else if (!phoneNumberRegex.test(s_number)) {
      showError("Enter a valid phone number.");
    } else if (!emailRegex.test(s_email)) {
      showError("Enter a valid email address.");
    } else {
      $.ajax({
        url: "php/suppliers/update-supplier.php",
        type: "POST",
        data: {
          s_id: s_id,
          s_name: s_name,
          s_email: s_email,
          s_address: s_address,
          s_number: s_number,
        },
        success: function (data) {
          switch (data) {
            case "1":
              load_list();
              showSuccess("Record Updated Successfully.");
              break;
            case "2":
              load_list();
              showError("Name already exists.");
              break;
            case "3":
              load_list();
              showError("All fields are required.");
              break;
            case "4":
              load_list();
              showError("Enter a valid phone number.");
              break;
            case "5":
              load_list();
              showSuccess("No changes were made.");
              break;
            case "6":
              load_list();
              showError("Enter a valid email address.");
              break;
            case "7":
              load_list();
              showError("Email already exists.");
              break;
            default:
              load_list();
              showError("Can't update record.");
              break;
          }
        },
      });
    }
  });

  //Display form to add
  $(document).on("click", "#new-btn", function () {
    var element = this;
    newSupplier();
  });
  function isEmpty(variable) {
    return $.trim(variable) == "";
  }
  function newSupplier() {
    // if ($(".toggle-id").attr("id") == "new-btn") {
    $(".toggle-id").attr("id", "go-back");
    $(".toggle-id").text("Suppliers Lists");
    // }

    $("#print").hide();
    $("#search-bar").hide();

    $.ajax({
      url: "php/suppliers/new-supplier.php",
      type: "POST",
      data: {
        act: "add",
      },
      success: function (data) {
        $("#suppliers-list").html(data);
      },
    });
  }

  //Add data to database and go back to table
  $(document).on("click", "#add-btn", function () {
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
              load_list();
              showSuccess("Record Added Successfully.");
              break;
            case "2":
              load_list();
              showError("Name already exists.");
              break;
            case "3":
              load_list();
              showError("All fields are required.");
              break;
            case "4":
              load_list();
              showError("Enter a valid phone number.");
              break;
            case "7":
              load_list();
              showError("Email already exists.");
              break;
            default:
              load_list();
              showError("Can't add record.");
              break;
          }
        },
      });
    }
  });

  //live search
  $(document).on("keyup", ".search-input", function () {
    var search_term = $(this).val();
    var search_type = $(this).data("type");

    if ($(this).val().length === 0) {
      load_list();
    } else {
      $.ajax({
        url: "php/suppliers/live-search.php",
        type: "POST",
        data: {
          value: search_type,
          search: search_term,
        },
        success: function (data) {
          $("#suppliers-list").html(data);
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
});
