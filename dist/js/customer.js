$(document).ready(function () {
  if (localStorage.getItem("createNewCustomer") === "true") {
    // Display the "New Supplier" form here
    localStorage.removeItem("createNewCustomer"); // Clear the flag once it's been used
    newCustomer();
  } else {
    load_list();
  }
  $("#error-message").hide();
  $("#success-message").hide();
  function load_list() {
    if ($(".toggle-id").attr("id") != "new-btn") {
      $(".toggle-id").attr("id", "new-btn");
      $(".toggle-id").text("New Customer");
    }
    $("#print").show();
    $("#search-bar").show();
    $(".search").val("");

    $.ajax({
      url: "php/customer/customer-list.php",
      type: "POST",
      success: function (data) {
        $("#customer-list").html(data).fadeIn();
      },
    });
  }

  $(document).on("click", ".pagination", function () {
    page = $(this).data("page");
    $.ajax({
      url: "php/customer/customer-list.php",
      type: "POST",
      data: {
        page: page,
      },
      success: function (data) {
        $("#customer-list").html(data);
      },
    });
  });

  $(document).on("click", "#go-back", function () {
    load_list();
  });

  $(document).on("click", ".delete-btn", function () {
    if (confirm("Do you really want to delete this record ?")) {
      var cid = $(this).data("cid");
      var element = this;

      $.ajax({
        url: "php/customer/delete-customer.php",
        type: "POST",
        data: {
          cid: cid,
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
    var c_id = $(this).data("eid");
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
      url: "php/customer/new-customer.php",
      type: "POST",
      data: {
        c_id: c_id,
        act: "edit",
      },
      success: function (data) {
        $("#customer-list").html(data);
      },
    });
  });

  //Update data to database and go back to table
  $(document).on("click", "#update-btn", function () {
    var c_id = $("#c_id").val();
    var c_name = $("#c_name").val();
    var c_address = $("#c_address").val();
    var c_number = $("#c_number").val();
    var c_email = $("#c_email").val();

    // Regular expression for validating phone number format
    var phoneNumberRegex = /^(\+977-)?\d{10}$/;

    // Regular expression for validating email format
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Perform validation checks
    if (
      c_name.trim() === "" ||
      c_address.trim() === "" ||
      c_email.trim() === "" ||
      c_number.trim() === ""
    ) {
      showError("All fields are required.");
    } else if (!phoneNumberRegex.test(c_number)) {
      showError("Enter a valid phone number.");
    } else if (!emailRegex.test(c_email)) {
      showError("Enter a valid email address.");
    } else {
      $.ajax({
        url: "php/customer/update-customer.php",
        type: "POST",
        data: {
          c_id: c_id,
          c_name: c_name,
          c_address: c_address,
          c_number: c_number,
          c_email: c_email,
        },
        success: function (data) {
          // alert(data);
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
              showSuccess("No Changes were made.");
              break;
            case "6":
              load_list();
              showSuccess("Enter a valid Email Address.");
              break;
            case "7":
              load_list();
              showSuccess("Email already exists.");
              break;
            default:
              load_list();
              showError("Can't Update record.");
              break;
          }
        },
      });
    }
  });

  //Display form to add
  $(document).on("click", "#new-btn", function () {
    var element = this;
    newCustomer();
  });
  function isEmpty(variable) {
    return $.trim(variable) == "";
  }
  function newCustomer() {
    // if ($(".toggle-id").attr("id") == "new-btn") {
    $(".toggle-id").attr("id", "go-back");
    $(".toggle-id").text("Customer Lists");
    // }

    $("#print").hide();
    $("#search-bar").hide();

    $.ajax({
      url: "php/customer/new-customer.php",
      type: "POST",
      data: {
        act: "add",
      },
      success: function (data) {
        $("#customer-list").html(data);
      },
    });
  }

  //add to database and go back to table
  $(document).on("click", "#add-btn", function () {
    var c_name = $("#c_name").val();
    var c_address = $("#c_address").val();
    var c_number = $("#c_number").val();
    var c_email = $("#c_email").val();

    // Check if any field is empty
    if (
      c_name.trim() === "" ||
      c_address.trim() === "" ||
      c_number.trim() === "" ||
      c_email.trim() === ""
    ) {
      showError("All fields are required.");
      return;
    }

    // Check if the number is not numeric
    if (isNaN(c_number)) {
      showError("Please enter a valid number.");
      return;
    }

    //Check if the email is valid
    if (!isValidEmail(c_email)) {
      showError("Please enter a valid email address for c_email.");
      return;
    }

    function isValidEmail(email) {
      var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(email);
    }

    var message =
      '<div id="error-message" class="absolute rounded-md right-1/2 top-3/4 bg-green-600 text-white translate-y-1/2 translate-x-2/3 px-6 w-1/3 text-center py-2">Recorded Successfully.</div>';

    alert(c_name);
    $.ajax({
      url: "php/customer/add-customer.php",
      type: "POST",
      data: {
        c_name: c_name,
        c_address: c_address,
        c_number: c_number,
        c_email: c_email,
      },
      success: function (data) {
        // alert(data);
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
          default:
            load_list();
            showError("Can't add record.");
            break;
        }
      },
    });
  });

  //live search
  $(document).on("keyup", ".search-input", function () {
    var search_term = $(this).val();
    var search_type = $(this).data("type");

    if ($(this).val().length === 0) {
      load_list();
    } else {
      $.ajax({
        url: "php/customer/live-search.php",
        type: "POST",
        data: {
          value: search_type,
          search: search_term,
        },
        success: function (data) {
          $("#customer-list").html(data);
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
