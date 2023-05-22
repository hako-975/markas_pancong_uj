<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>


    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter" id="badge-counter">0</span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Pesanan Terbaru
                </h6>
                <div id="content-notif"></div>
            </div>
        </li>
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $dataUser['nama_lengkap']; ?></span>
                <img class="img-profile rounded-circle"
                    src="img/undraw_profile.svg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="profile.php">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->
<script>
    function loadData() {
        setInterval(function() {
            $.ajax({
                url: "data_for_notif.php?counter",
                method: "GET",
                success: function(response) {
                    $("#badge-counter").html(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error loading data:", error);
                }
            });
        }, 100);
    }

    loadData();

    $(document).ready(function() {
        $("#alertsDropdown").click(function() {
            
            $.ajax({
                url: "data_for_notif.php?content-notif",
                method: "GET",
                success: function(response) {
                    $("#content-notif").html(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error loading data:", error);
                }
            });

            $.ajax({
                url: "update_status_notif.php",
                method: "POST",
                data: { status_notif: 1 },
                success: function(response) {
                    // Code to execute when the update is successful
                    console.log("Status updated!");
                },
                error: function(xhr, status, error) {
                    // Code to handle errors
                    console.error("Error updating status:", error);
                }
            });
        });
    });


</script>