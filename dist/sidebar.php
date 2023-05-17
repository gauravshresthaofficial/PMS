<div class="col-span-2 shadow-md">
  <style>
    .threedots:hover img {
      scale: 110%;
    }
  </style>

  <div class="bg-[#1E1E1E]  text-[#F1F5F9] h-screen">

    <!-- <div class="col-span-3  bg-[#1E1E1E] text-[#F1F5F9] h-screen"> -->
    <div class="flex flex-col justify-between h-full content-between">

      <div>
        <!-- <p class="text-center h-12 text-pms-green font-bold text-2xl pt-2">
          P M S
        </p>
        <hr class="" /> -->
        <!-- Admin row -->
        <div class="col-span-2  flex flex-row justify-between ps-6 pe-2 h-14 border-b user-name hover:scale-105">
          <a href="edit-admin.php" class="edit-admin cursor-pointer flex  flex-col justify-center w-full">
            <p class="text-[#F1F5F9] font-bold text-lg"><?php echo $_SESSION['name']; ?></p>
            <p class="text-[#F1F5F9] font-semibold text-xs"><?php echo $_SESSION['username']; ?></p>
          </a>
          <!-- <div class="threedots my-auto p-2 relative">
            <img src="../icons/threedots.svg" alt="dashboard" class="w-6">
            <div id="profile-menu" class="absolute text-sm hidden flex-col divide-y rounded-md right-0 bg-white w-36 text-[#1E1E1E]">
              <div class="p-2 ps-4 log-out">
                <p class="hover:scale-105">Logout</p>
              </div>
              <div class="p-2 ps-4 edit-profile">
                <p class="hover:scale-105">Edit Profile</p>
              </div>
            </div>
          </div> -->


        </div>
        <!-- Menu -->
        <div class="flex flex-col w-full">
          <!-- <ul class="w-full"> -->
          <!-- Dashboard -->
          <a href="home.php" class="py-3 ps-4 delay-50 duration-150 hover:text-[#2DD4BF] flex flex-row items-center 
          <?php
          if ($active == "") {
            echo " bg-[#2DD4BF]";
          }
          ?>">
            <img src="../icons/dashboard.svg" alt="dashboard" class="w-6">
            <p class="ms-3">Dashboard</p>
          </a>
          <!-- Invoice -->
          <a href="invoice.php" class="py-3 ps-4 delay-50 duration-150 hover:text-[#2DD4BF] flex flex-row items-center
          <?php
          if ($active == "invoice") {
            echo " bg-[#2DD4BF]";
          }
          ?>">
            <img src="../icons/invoice.svg" alt="dashboard" class="w-6 p-1">
            <p class="ms-3">Invoice</p>
          </a>
          <!-- Customer -->
          <a href="customer.php" class="py-3 ps-4 delay-50 duration-150 hover:text-[#2DD4BF] flex flex-row items-center
          <?php
          if ($active == "customer") {
            echo " bg-[#2DD4BF]";
          }
          ?>">
            <img src="../icons/customer.svg" alt="dashboard" class="w-6 ">
            <p class="ms-3">Customer</p>
          </a>
          <!-- Medicine -->
          <a href="suppliers.php" class="py-3 ps-4 delay-50 duration-150 hover:text-[#2DD4BF] flex flex-row items-center
          <?php
          if ($active == "suppliers") {
            echo " bg-[#2DD4BF]";
          }
          ?>">
            <img src="../icons/suppliers.svg" alt="dashboard" class="w-6 ">
            <p class="ms-3">Suppliers</p>
          </a>
          <!-- Suppliers -->
          <a href="medicine.php" class="py-3 ps-4 delay-50 duration-150 hover:text-[#2DD4BF] flex flex-row items-center
          <?php
          if ($active == "medicine") {
            echo " bg-[#2DD4BF]";
          }
          ?>">
            <img src="../icons/medicine.svg" alt="dashboard" class="w-6 ">
            <p class="ms-3">Medicine</p>
          </a>
          <!-- Purchases -->
          <a href="purchases.php" class="py-3 ps-4 delay-50 duration-150 hover:text-[#2DD4BF] flex flex-row items-center
          <?php
          if ($active == "purchases") {
            echo " bg-[#2DD4BF]";
          }
          ?>">
            <img src="../icons/purchase.svg" alt="dashboard" class="w-5 ">
            <p class="ms-3">Purchases</p>
          </a>
          <!-- Report -->
          <!-- <a href="report.php" class="py-3 ps-4 delay-50 duration-150 hover:text-[#2DD4BF] flex flex-row items-center
          <?php
          // if ($active == "report") {
          //   echo " bg-[#2DD4BF]";
          // }
          ?>">
              <img src="../icons/report.svg" alt="dashboard" class="w-6 ">
              <p class="ms-3">Report</p>
            </a> -->
          <!-- </ul> -->
        </div>
        <!-- </div> -->
        <!-- </div> -->

      </div>
      <div>
        <a href="logout.php" class="log-out py-3 px-4 pr-6 delay-50 duration-150 flex flex-row justify-between items-center border border-transparent hover:border-white">
          <p class="ms-3">Log out</p>
          <img src="../icons/logout.svg" class="w-6">
          </a>
        <div class="flex flex-row justify-evenly text-center text-xs bottom-1 text-white/40 py-3 border-t">
          <span>copyright@2023</span>
          <span>V.0.01</span>
        </div>
      </div>

    </div>
  </div>
</div>


<script>
  // $(document).ready(function() {
  //   $(document).on("click", ".threedots", function() {
  //     alert(1);
  //     if ($("#profile-menu").hasClass("flex")) {
  //       $("#profile-menu").removeClass("flex").addClass("hidden");
  //     } else {
  //       $("#profile-menu").removeClass("hidden").addClass("flex");
  //     }
  //   });
  // });
</script>