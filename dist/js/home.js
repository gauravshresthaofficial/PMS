$(document).ready(function () {
  //for new supplier
  const newSupplierBtn = document.getElementById("new-supplier");

  newSupplierBtn.addEventListener("click", function (event) {
    event.preventDefault();

    localStorage.setItem("createNewSupplier", "true");
    window.location.href = newSupplierBtn.href;
  });

  const newCustomerBtn = document.getElementById("new-customer");

  newCustomerBtn.addEventListener("click", function (event) {
    event.preventDefault();
    localStorage.setItem("createNewCustomer", "true");
    window.location.href = newCustomerBtn.href;
  });
  const newMedicineBtn = document.getElementById("new-medicine");

  newMedicineBtn.addEventListener("click", function (event) {
    event.preventDefault();
    localStorage.setItem("createNewMedicine", "true");
    window.location.href = newMedicineBtn.href;
  });

  // Function to retrieve and display the number of rows in each table
  function getTableRowCount() {
    $.ajax({
      url: "php/home/data.php",
      type: "POST",
      dataType: "json",
      success: function (data) {
        // Display the number of rows in each table
        $("#customer-num").text(data.customer_num);
        $("#medicine-num").text(data.medicine_num);
        $("#supplier-num").text(data.supplier_num);
        $("#invoice-num").text(data.invoice_num);
        $("#today-sales").text("Rs " + data.purchasesTotal);
        $("#today-purchases").text("Rs " + data.salesTotal);
        $("#expired-med").text(data.totalExpiredMedicine);
        $("#out-of-stock").text(data.outOfStockMedicine);
      },
    });
  }

  // Call the function initially
  getTableRowCount();

  // Refresh the row counts every 5 seconds
  setInterval(getTableRowCount, 5000);

  // Hide success message after 4 seconds
  function hideSuccessMessage() {
    $("#success-message").fadeOut();
  }

  var successMessageElement = $("#success-message");

  if (successMessageElement.length) {
    var successMessage = successMessageElement.data("success-message");
    successMessageElement.fadeIn();

    setTimeout(function () {
      hideSuccessMessage();
    }, 4000);
  }
  
});
