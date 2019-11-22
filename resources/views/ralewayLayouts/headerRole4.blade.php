<!-- Begin Header -->
<header>

    <!-- Begin Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <!-- Address and Phone -->
                <div class="col-sm-7 hidden-xs">
                    <span class="ion-android-system-home home-icon"></span>Voltastraße 2, 70376 Stuttgart<span class="ion-ios7-telephone phone-icon"></span>1741640085
                </div>
                <!-- Social Buttons -->
                <div class="col-sm-5 text-right">
                    <ul class="topbar-list list-inline">
                        <li>
                            <a class="btn btn-social-icon btn-rw btn-primary btn-xs">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a class="btn btn-social-icon btn-rw btn-primary btn-xs">
                                <i class="fa fa-instagram"></i>
                            </a>
                            <a class="btn btn-social-icon btn-rw btn-primary btn-xs">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li><li><a data-toggle="modal" data-target="#login">Login</a></li><li><a href="pages-forms-register-login.html')}}">Register</a></li>
                    </ul>
                </div>
            </div><!--/row -->
        </div><!--/container header -->
    </div><!--/top bar -->
    <!-- End Top Bar -->

    <!-- Login -->
    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="loginLabel">Login</h4>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"> Do you flex?
                            </label>
                        </div>
                    </form><!-- /form -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rw btn-primary">Login</button>
                </div>
            </div><!-- /modal content -->
        </div><!-- /modal dialog -->
    </div><!-- /modal holder -->
    <!-- End Login -->

    <!-- Begin Navigation -->
    <div class="navbar-wrapper">
        <div class="navbar navbar-main" id="fixed-navbar">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 column-header">
                        <div class="navbar-header">
                            <!-- Brand -->
                            <a href="index.html" class="navbar-brand">
                                <img src="{{ asset('raleway/images/tokas.png')}}" class="raleway-logo" alt="Tokas">
                            </a>
                            <!-- Mobile Navigation -->
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div><!-- /navbar header -->

                        <!-- Main Navigation - Explained in Documentation -->
                        <nav class="navbar-collapse collapse navHeaderCollapse" role="navigation">
                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown dropdown-main">
                                    <a href="/home"><span class="fa fa-home"></span></a>
                                </li>
                                @if(auth()->user()->role_id == 1 or auth()->user()->role_id == 2)
                                    <li class="dropdown dropdown-main">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('partials\header.tariffs')}}<span class="fa fa-angle-down dropdown-arrow"></span></a>
                                        <ul class="dropdown-menu dropdown-subhover dropdown-animation animated fadeIn"><!-- Control Animations by changing "fadeIn" to another property from animate.css, check animations page in features / ALSO dropdown-animation class controls the duration, ajust if need -->
                                            <li><a href="/tariff/index">{{__('partials\header.tariffManagement')}}<span></span></a></li>
                                            <li><a href="/contract/tariffs">{{__('partials\header.tariffs')}}<span></span></a></li>
                                        </ul>
                                    </li>
                                @else
                                    <li class="dropdown dropdown-main">
                                        <a href="/contract/tariffs">{{__('partials\header.tariffs')}}<span></span></a>
                                    </li>
                                @endif

                                <li class="dropdown dropdown-main">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('partials\header.contracts')}}<span class="fa fa-angle-down dropdown-arrow"></span></a>
                                    <ul class="dropdown-menu dropdown-subhover dropdown-animation animated fadeIn"><!-- Control Animations by changing "fadeIn" to another property from animate.css, check animations page in features / ALSO dropdown-animation class controls the duration, ajust if need -->
                                        <li><a href="features-typography.html">Typography</a></li>
                                        <li><a href="features-typography.html">Typography</a></li>
                                        <li><a href="features-typography.html">Typography</a></li>
                                        <li><a href="features-typography.html">Typography</a></li>

                                    </ul>
                                </li>
                                <li class="dropdown dropdown-main">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('partials\header.management')}}<span class="fa fa-angle-down dropdown-arrow"></span></a>
                                    <ul class="dropdown-menu dropdown-subhover dropdown-animation animated fadeIn"><!-- Control Animations by changing "fadeIn" to another property from animate.css, check animations page in features / ALSO dropdown-animation class controls the duration, ajust if need -->
                                        <li><a href="features-typography.html">Typography</a></li>
                                        <li><a href="features-typography.html">Typography</a></li>
                                        <li><a href="features-typography.html">Typography</a></li>
                                        <li><a href="features-typography.html">Typography</a></li>

                                    </ul>
                                </li>
                                <li class="dropdown dropdown-main">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('partials\header.admin')}}<span class="fa fa-angle-down dropdown-arrow"></span></a>
                                    <ul class="dropdown-menu dropdown-subhover dropdown-animation animated fadeIn"><!-- Control Animations by changing "fadeIn" to another property from animate.css, check animations page in features / ALSO dropdown-animation class controls the duration, ajust if need -->
                                        <li><a href="features-typography.html">Typography</a></li>
                                        <li><a href="features-typography.html">Typography</a></li>
                                        <li><a href="features-typography.html">Typography</a></li>
                                        <li><a href="features-typography.html">Typography</a></li>

                                    </ul>
                                </li>
                                <li class="dropdown dropdown-main">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('partials\header.evaluations')}}<span class="fa fa-angle-down dropdown-arrow"></span></a>
                                    <ul class="dropdown-menu dropdown-subhover dropdown-animation animated fadeIn"><!-- Control Animations by changing "fadeIn" to another property from animate.css, check animations page in features / ALSO dropdown-animation class controls the duration, ajust if need -->
                                        <li><a href="features-typography.html">Typography</a></li>
                                        <li><a href="features-typography.html">Typography</a></li>
                                        <li><a href="features-typography.html">Typography</a></li>
                                        <li><a href="features-typography.html">Typography</a></li>

                                    </ul>
                                </li>
                                <li class="dropdown dropdown-main">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('partials\header.infoCenter')}}<span class="fa fa-angle-down dropdown-arrow"></span></a>
                                    <ul class="dropdown-menu dropdown-subhover dropdown-animation animated fadeIn"><!-- Control Animations by changing "fadeIn" to another property from animate.css, check animations page in features / ALSO dropdown-animation class controls the duration, ajust if need -->
                                        <li><a href="features-typography.html">Typography</a></li>
                                        <li><a href="features-typography.html">Typography</a></li>
                                        <li><a href="features-typography.html">Typography</a></li>
                                        <li><a href="features-typography.html">Typography</a></li>

                                    </ul>
                                </li>
                                <li class="dropdown dropdown-main">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('partials\header.account')}}<span class="fa fa-angle-down dropdown-arrow"></span></a>
                                    <ul class="dropdown-menu dropdown-subhover dropdown-animation animated fadeIn"><!-- Control Animations by changing "fadeIn" to another property from animate.css, check animations page in features / ALSO dropdown-animation class controls the duration, ajust if need -->
                                        <li><a href="features-typography.html">{{__('partials\header.account')}}</a></li>
                                        <li><a href="features-typography.html">Typography</a></li>
                                        <li><a href="features-typography.html">Typography</a></li>
                                        <li><a href="features-typography.html">Typography</a></li>

                                    </ul>
                                </li>
                                <li class="dropdown hidden-sm hidden-xs">
                                    <a href="#" class="ml10 nav-circle-li dropdown-toggle dropdown-form-toggle" data-toggle="dropdown"><i class="fa fa-shopping-cart"></i></a>
                                    <ul class="fadeInUp-animated dropdown-menu dropdown-menu-user cart">
                                        <li id="dropdownForm">
                                            <div class="dropdown-form">
                                                <table class="table table-hover no-margin">
                                                    <thead>
                                                    <tr>
                                                        <th class="quantity">QTY</th>
                                                        <th class="product">Product</th>
                                                        <th class="amount">Subtotal</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="quantity">2 x</td>
                                                        <td class="product"><a href="shop-product.html">IPhone 6s</a><span class="small">32GB 10.0 Megapixel</span></td>
                                                        <td class="amount">$700.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="quantity">3 x</td>
                                                        <td class="product"><a href="shop-product.html">G10 Macbook Toaster</a><span class="small">Quad Core 5GB</span></td>
                                                        <td class="amount">$500.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="quantity">3 x</td>
                                                        <td class="product"><a href="shop-product.html">Desktop Seagul</a><span class="small">1 Foot Tall - 2FT Wingspan</span></td>
                                                        <td class="amount">$1500.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="total-quantity" colspan="2">Total 8 Items</td>
                                                        <td class="total-amount">$3000.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right" colspan="3">
                                                            <a href="shop-cart.html"><button class="btn btn-rw btn-primary btn-sm">View your cart</button></a>
                                                            <a href="shop-checkout-1.html"><button class="btn btn-rw btn-primary btn-sm">Checkout</button></a>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div><!-- /dropdown form -->
                                        </li><!-- /dropdownForm list item -->
                                    </ul><!-- /cart dropdown -->
                                </li><!-- /cart navbar list item -->
                                <li class="dropdown hidden-sm hidden-xs">
                                    <a href="#" class="ml10 nav-circle-li dropdown-toggle dropdown-form-toggle" data-toggle="dropdown"><i class="fa fa-search"></i></a>
                                    <ul class="fadeInRight-animated dropdown-menu dropdown-menu-user">
                                        <li id="dropdownForm">
                                            <div class="dropdown-form">
                                                <form class="form-default form-inline p15">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control search-input" placeholder="Search...">
                                                        <span class="input-group-btn">
						                                                <button class="btn btn-rw btn-primary search-btn" type="button">Go!</button>
						                                            </span>
                                                </form><!-- /searh form -->
                                            </div><!-- /dropdown form -->
                                        </li><!-- /dropdownForm list item -->
                                    </ul><!-- /search dropdown -->
                                </li><!-- /search navbar list item -->
                            </ul><!-- /navbar right -->
                        </nav><!-- /nav -->
                    </div>
                </div>
            </div><!-- /container header -->
        </div><!-- /navbar -->
    </div><!-- /navbar wrapper -->
    <!-- End Navigation -->

    @yield('pageHeader')

</header><!-- /header -->
<!-- End Header -->