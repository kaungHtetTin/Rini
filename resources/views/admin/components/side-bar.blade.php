<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin.index')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Rini <sup>Admin</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    @if (Auth::user()->check_access_level(4))
        <li class="nav-item @php if($page_title == 'Dashboard') echo 'active' @endphp">
            <a class="nav-link" href="{{route('admin.index')}}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
    @endif
    

    <li class="nav-item @php if($page_title == 'Blogs') echo 'active' @endphp">
        <a class="nav-link" href="{{route('admin.blogs')}}">
            <i class="fas fa-fw fa-blog"></i>
            <span>Blogs</span></a>
    </li>

    <li class="nav-item @php if($page_title == 'Customers') echo 'active' @endphp">
        <a class="nav-link" href="{{route('admin.customers')}}">
            <i class="fas fa-fw fa-users"></i>
            <span>Customers</span></a>
    </li>

    <li class="nav-item @php if($page_title == 'Collaborators') echo 'active' @endphp">
        <a class="nav-link" href="{{route('admin.collaborators')}}">
            <i class="fas fa-fw fa-handshake"></i>
            <span>Collaborators</span></a>
    </li>

    @if (Auth::user()->check_access_level(2))
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Sale
        </div>

        <li class="nav-item @php if($page_title == 'Sale Overview') echo 'active' @endphp">
            <a class="nav-link" href="{{route('admin.vouchers.sale-overview')}}">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Overview</span></a>
        </li>

        <li class="nav-item @php if($page_title == 'New Orders') echo 'active' @endphp">
            <a class="nav-link" href="{{route('admin.vouchers.new-orders')}}">
                <i class="fas fa-fw fa-cart-plus"></i>
                <span>New Orders</span></a>
        </li>

        <li class="nav-item  @php if($page_title == 'Delivered Orders') echo 'active' @endphp">
            <a class="nav-link" href="{{route('admin.vouchers.delivered_orders')}}">
                <i class="fas fa-fw fa-shipping-fast"></i>
                <span>Delivered</span></a>
        </li>

        <li class="nav-item  @php if($page_title == 'Add Order') echo 'active' @endphp">
            <a class="nav-link" href="{{route('admin.vouchers.add')}}">
                <i class="fas fa-fw fa-plus-square"></i>
                <span>Add Order</span></a>
        </li>

    @endif

    @if (Auth::user()->check_access_level(1))
    <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Product
        </div>

        <li class="nav-item @php if($page_title == 'Products') echo 'active' @endphp">
            <a class="nav-link" href="{{route('admin.products')}}">
                <i class="fas fa-fw fa-parking"></i>
                <span>Products</span></a>
        </li>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item @php if($page_title == 'Product Setting') echo 'active' @endphp">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#product_setting"
                aria-expanded="true" aria-controls="product_setting">
                <i class="fas fa-fw fa-cog"></i>
                <span>Product Setting</span>
            </a>
            <div id="product_setting" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Product Setting:</h6>
                    <a class="collapse-item" href="{{route('admin.product-categories')}}">Add Category</a>
                    <a class="collapse-item" href="{{route('admin.products-add')}}">Add Product</a>
                    
                </div>
            </div>
        </li>
    @endif

    @if (Auth::user()->check_access_level(4))
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Financial
        </div>

        <li class="nav-item @php if($page_title == 'Financial Overview') echo 'active' @endphp">
            <a class="nav-link" href="{{route('admin.financials.overview')}}">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Overview</span></a>
        </li>

        <li class="nav-item @php if($page_title == 'Add Cost') echo 'active' @endphp">
            <a class="nav-link" href="{{route('admin.financials.add')}}">
                <i class="fas fa-fw fa-plus-circle"></i>
                <span>Add Cost</span></a>
        </li>

        {{-- <li class="nav-item" @php if($page_title == 'Income') echo 'active' @endphp>
            <a class="nav-link" href="charts.html">
                <i class="fas fa-fw fa-wallet"></i>
                <span>Income</span></a>
        </li> --}}
    
        <li class="nav-item @php if($page_title == 'Outcome') echo 'active' @endphp">
            <a class="nav-link" href="{{route('admin.financials')}}">
                <i class="fas fa-fw fa-donate"></i>
                <span>Outcome</span></a>
        </li>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item @php if($page_title == 'Financial Setting') echo 'active' @endphp">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#financial_setting"
                aria-expanded="true" aria-controls="financial_setting">
                <i class="fas fa-fw fa-cog"></i>
                <span>Financial Setting</span>
            </a>
            <div id="financial_setting" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Financial Setting:</h6>
                    <a class="collapse-item" href="{{route('admin.cost-categories')}}">Add Cost Category</a>
                </div>
            </div>
        </li>

    @endif

    @if (Auth::user()->check_access_level(3))
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Employee
        </div>

        {{-- <li class="nav-item">
            <a class="nav-link @php if($page_title == 'Employee Overview') echo 'active' @endphp" href="charts.html">
                <i class="fas fa-fw fa-users"></i>
                <span>Overview</span></a>
        </li> --}}

        <li class="nav-item @php if($page_title == 'Employee') echo 'active' @endphp">
            <a class="nav-link" href="{{route('admin.employees')}}">
                <i class="fas fa-fw fa-user-tie"></i>
                <span>Employee</span></a>
        </li>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item @php if($page_title == 'Employee Setting') echo 'active' @endphp">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#employee_setting"
                aria-expanded="true" aria-controls="employee_setting">
                <i class="fas fa-fw fa-cog"></i>
                <span>Employee Setting</span>
            </a>
            <div id="employee_setting" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Employee Setting:</h6>
                    <a class="collapse-item" href="{{route('admin.departments')}}">Add New Department</a>
                    <a class="collapse-item" href="{{route('admin.employees.add')}}">Add New Employee</a>

                </div>
            </div>
        </li>
    @endif

    
    @if (Auth::user()->check_access_level(5))
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Project Setting
        </div>

        <li class="nav-item @php if($page_title == 'Admins') echo 'active' @endphp">
            <a class="nav-link" href="{{route('admin.admins')}}">
                <i class="fas fa-fw fa-user-shield"></i>
                <span>Admins</span></a>
        </li>

        <li class="nav-item @php if($page_title == 'Update Contact') echo 'active' @endphp">
            <a class="nav-link" href="{{route('admin.setting.update-contact')}}">
                <i class="fas fa-fw fa-address-card"></i>
                <span>Update Contact</span></a>
        </li>

        <li class="nav-item @php if($page_title == 'Payment Methods') echo 'active' @endphp">
            <a class="nav-link" href="{{route('admin.payment-methods')}}">
                <i class="fab fa-fw fa-cc-visa"></i>
                <span>Payment Methods</span></a>
        </li>

        <li class="nav-item @php if($page_title == 'Reviews') echo 'active' @endphp">
            <a class="nav-link" href="{{route('admin.reviews')}}">
                <i class="fas fa-fw fa-star"></i>
                <span>Reviews</span></a>
        </li>

    @endif
    

</ul>