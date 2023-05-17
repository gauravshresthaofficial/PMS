$(document).ready(function () {
  $(".log-out").click(function (e) {
    e.preventDefault(); // Prevent the default behavior of the anchor tag

    if (confirm("Do you want to Log Out?")) {
      var logoutUrl = $(this).attr("href");

      // Redirect to the desired location
      window.location.href = logoutUrl;
    }
  });
  $(".edit-admin").click(function (e) {
    e.preventDefault(); // Prevent the default behavior of the anchor tag

    // if (confirm("Do you want to Log Out?")) {
      var logoutUrl = $(this).attr("href");

      // Redirect to the desired location
      window.location.href = logoutUrl;
  });
  // $('.user-name').click(function() {
  //     alert(1);
  //     var url = 'edit-admin.php?action=edit';
  //     window.location.href = url;
  // });
});
