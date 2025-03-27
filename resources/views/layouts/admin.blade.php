<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Data Management -->
                <li class="nav-header">DATA MANAGEMENT</li>
                <li class="nav-item">
                    <a href="{{ route('admin.brands.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>Brands</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.compatibility.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-random"></i>
                        <p>Compatibility Rules</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.posts.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-pen"></i>
                        <p>Posts</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.products.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-box-open"></i>
                        <p>Products</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>

                <!-- Performance Test -->
                <li class="nav-header">PERFORMANCE TEST</li>
                <li class="nav-item">
                    <a href="{{ route('admin.performance.take') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Take a Test</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.performance.test_results') }}" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Test Results</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
