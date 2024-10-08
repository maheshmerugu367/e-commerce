<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <li class="nav-item ">
      <a class="nav-link" href="index.php">
        <span class="menu-title"> <i class="mdi mdi-home menu-icon f2"></i> &nbsp; Dashboard</span>
        <i class="mdi mdi-home menu-icon f1"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-toggle="collapse" href="#ui-basics" aria-expanded="false" aria-controls="ui-basics">
        <span class="menu-title"> <i class="mdi mdi-database f2"></i> &nbsp; Categories</span>
        <i class="mdi mdi-database menu-icon f1"></i> <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basics" style="">
        <ul class="nav flex-column sub-menu">

          <li class="nav-item"> <a class="nav-link" href="{{route('admin.category.index')}}">All Categories</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{route('admin.subcategory.index')}}">All Sub Categories</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{route('admin.list.subcategories.index')}}">List Sub Categories</a></li>

        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <span class="menu-title"> <i class="mdi   mdi-gift f2"></i> &nbsp; Products</span>
        <i class="mdi   mdi-gift menu-icon f1"></i> <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="add-produts.php">Add  New Products</a></li>
          <li class="nav-item"> <a class="nav-link" href="product_list.php">Products List</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#orders" aria-expanded="false" aria-controls="orders">
        <span class="menu-title"> <i class="mdi  mdi-chart-bar f2"></i> &nbsp; Orders</span>
        <i class="mdi  mdi-chart-bar menu-icon f1"></i> <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="orders">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="add-orders.php">Add</a></li>
          <li class="nav-item"> <a class="nav-link" href="order-manager.php">Manage</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-orders" aria-expanded="false" aria-controls="ui-orders">
        <span class="menu-title"> <i class="mdi  mdi-account-multiple f2"></i> &nbsp; Users</span>
        <i class="mdi mdi-account-multiple menu-icon f1"></i> <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-orders">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="add-user.php">Add</a></li>
          <li class="nav-item"> <a class="nav-link" href="manage-users.php">Manage</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="#">
        <span class="menu-title"> <i class="mdi  mdi-email  menu-icon f2"></i> &nbsp; Messages</span>
        
        <i class="mdi  mdi-email  menu-icon f1"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">
        <span class="menu-title"> <i class="mdi mdi-lock menu-icon f2"></i> &nbsp; Change Password</span>
        <i class="mdi mdi-lock menu-icon f1"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">
        <span class="menu-title"> <i class="mdi mdi-settings menu-icon f2"></i> &nbsp; Settings</span>
        <i class="mdi mdi-settings menu-icon f1"></i>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="#">
      <span class="menu-title logout-button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="mdi mdi-power menu-icon f2"></i> &nbsp; Logout
        </span>
        
        <!-- Hidden Logout Form -->
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>        <i class="mdi mdi-power menu-icon f1"></i>

        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
    @csrf
</form>


      </a>
    </li>
  </ul>
</nav>

<script>
        // jQuery to toggle sidebar-icon-only class on click
        $(document).ready(function() {
            $('.mdi-menu').on('click', function() {
                $('body').toggleClass('sidebar-icon-only');
            });
        });
    </script>