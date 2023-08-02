<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('img/hero.jpg') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">QAZIR</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('template/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-header">DASHBOARD</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                @if (auth()->user()->level == 1)
                    <li class="nav-header">MASTER</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p>
                                Master
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('category.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Category</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('product.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Product</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('member.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Member</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('supplier.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Supplier</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header">TRANSACTION</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cash-register"></i>
                            <p>
                                Transaction
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('expenditure.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Expenditure</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('purchase.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Purchase</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('sale.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sale</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('transaction.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Old Transaction</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('transaction.new') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>New Transaction</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header">REPORT</li>
                    <li class="nav-item">
                        <a href="{{ route('report.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>
                                Report
                            </p>
                        </a>
                    </li>

                    <li class="nav-header">SETTING</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tools"></i>
                            <p>
                                Setting
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('user.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>User</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header">SIGN OUT</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="document.getElementById('logout-form').submit()">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>
                                Sign Out
                            </p>
                        </a>
                    </li>
                @else
                    <li class="nav-header">TRANSACTION</li>
                    <li class="nav-item">
                        <a href="{{ route('transaction.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-cash-register"></i>
                            <p>
                                Old Transaction
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('transaction.new') }}" class="nav-link">
                            <i class="nav-icon fas fa-cash-register"></i>
                            <p>
                                New Transaction
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">SIGN OUT</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="document.getElementById('logout-form').submit()">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>
                                Sign Out
                            </p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none">
    @csrf
</form>
