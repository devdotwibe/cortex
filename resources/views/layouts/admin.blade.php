<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @hasSection('title')
            @yield('title') |
        @endif {{ config('app.name') }}
    </title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
</head>

<body>
    <aside class="side_bar">
        <div class="side-bar-logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo-small.png') }}" alt="">
            </a>
        </div>
        <div class="side-nav-toggle">
            <button class="btn btn-close-toggle"><img src="./assets/images/close.svg" alt=""></button>
        </div>
        <div class="sidebar-content js-simplebar">
            <ul class="sidebar-nav">
                <li class="side-item  active ">
                    <a href="">
                        <span class="side-icon" active=""><img src="./assets/images/Dashboard-wht.svg"
                                alt=""></span>
                        <span class="active-icon"><img src="./assets/images/Dashboard-blk.svg" alt=""></span>
                        Dashboard
                    </a>
                </li>
                <li class="side-item">
                    <a href="">
                        <span class="side-icon" active=""><img src="./assets/images/Dashboard-wht.svg"
                                alt=""></span>
                        <span class="active-icon"><img src="./assets/images/Dashboard-blk.svg" alt=""></span>
                        Dashboard
                    </a>
                </li>


                <li class="side-item">
                    <a href="">
                        <span class="side-icon" active=""><img src="./assets/images/Dashboard-wht.svg"
                                alt=""></span>
                        <span class="active-icon"><img src="./assets/images/Dashboard-blk.svg" alt=""></span>
                        Dashboard
                    </a>
                </li>


                <li class="side-item ">
                    <a href="">
                        <span class="side-icon" active=""><img src="./assets/images/Dashboard-wht.svg"
                                alt=""></span>
                        <span class="active-icon"><img src="./assets/images/Dashboard-blk.svg" alt=""></span>
                        Dashboard
                    </a>
                </li>


                <li class="side-item ">
                    <a href="">
                        <span class="side-icon" active=""><img src="./assets/images/Dashboard-wht.svg"
                                alt=""></span>
                        <span class="active-icon"><img src="./assets/images/Dashboard-blk.svg" alt=""></span>
                        Settings
                    </a>
                </li>


                <li class="side-item side-dropdown ">
                    <a class="side-dropdown-toggle" id="pagesLink">
                        <span class="side-icon" active=""><img src="./assets/images/Dashboard-wht.svg"
                                alt=""></span>
                        <span class="active-icon"><img src="./assets/images/Dashboard-blk.svg" alt=""></span>
                        Pages
                    </a>
                    <ul class="side-dropdown-menu" id="pagesDropdown">
                        <li class="side-item "><a href="">Contact Details</a></li>
                        <li class="side-item "><a href="">Home</a></li>
                        <li class="side-item "><a href="">About Us</a></li>
                        <li class="side-item "><a href="">Employer</a></li>
                        <li class="side-item "><a href="">Terms and Conditions</a></li>

                    </ul>
                </li>

                <li class="side-item logout">
                    <a href="{{route('admin.logout')}}" class="log-out"> 
                        <span class="side-icon">
                            <img src="{{asset("assets/images/log-out.svg")}}" alt="log-out">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/log-out-1.svg")}}" alt="log-out">
                        </span> Log Out
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <main class="content_outer">
        <section class="header_nav">
            <div class="header_wrapp">
                <div class="header_title">
                    <h2>Dashboard</h2>
                </div>
                <div class="header_right">
                    <ul class="nav_bar">
                        <li class="nav_item"><a href="" class="nav_link btn">Demo</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="content_section">
            <div class="container">
                <div class="row">
                    <div class="dash_card">
                        <div class="admin-icon">
                            <span class="wht-icon"><img
                                    src="https://suryaplacement.com/assets/images/Settings-wht.png"></span>
                            <span class="red-icon"><img
                                    src="https://suryaplacement.com/assets/images/Settings-red.png"></span>
                        </div>
                        <h3>Settings</h3>
                    </div>
                    <div class="dash_card">
                        <div class="admin-icon">
                            <span class="wht-icon"><img
                                    src="https://suryaplacement.com/assets/images/Settings-wht.png"></span>
                            <span class="red-icon"><img
                                    src="https://suryaplacement.com/assets/images/Settings-red.png"></span>
                        </div>
                        <h3>Settings</h3>
                    </div>
                    <div class="dash_card">
                        <div class="admin-icon">
                            <span class="wht-icon"><img
                                    src="https://suryaplacement.com/assets/images/Settings-wht.png"></span>
                            <span class="red-icon"><img
                                    src="https://suryaplacement.com/assets/images/Settings-red.png"></span>
                        </div>
                        <h3>Settings</h3>
                    </div>
                    <div class="dash_card">
                        <div class="admin-icon">
                            <span class="wht-icon"><img
                                    src="https://suryaplacement.com/assets/images/Settings-wht.png"></span>
                            <span class="red-icon"><img
                                    src="https://suryaplacement.com/assets/images/Settings-red.png"></span>
                        </div>
                        <h3>Settings</h3>
                    </div>
                </div>
            </div>
        </section>
        <section class="table-section">
            <div class="container">
                <div class="row">
                    <div class="table-outer">
                        <table>
                            <thead>
                                <tr>
                                    <th>Sl.No</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Place</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>2023-11-03</td>
                                    <td>Amal</td>
                                    <td>Aluva</td>
                                    <td>
                                        <a href="" class="btn btn-icons view_btn"><img
                                                src="./assets/images/view.svg" alt=""></a>
                                        <a href="" class="btn btn-icons edit_btn"><img
                                                src="./assets/images/edit.svg" alt=""></a>
                                        <a href="" class="btn btn-icons dlt_btn"><img
                                                src="./assets/images/delete.svg" alt=""></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>2023-11-03</td>
                                    <td>Amal</td>
                                    <td>Aluva</td>
                                    <td>
                                        <a href="" class="btn btn-icons view_btn"><img
                                                src="./assets/images/view.svg" alt=""></a>
                                        <a href="" class="btn btn-icons edit_btn"><img
                                                src="./assets/images/edit.svg" alt=""></a>
                                        <a href="" class="btn btn-icons dlt_btn"><img
                                                src="./assets/images/delete.svg" alt=""></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>2023-11-03</td>
                                    <td>Amal</td>
                                    <td>Aluva</td>
                                    <td>
                                        <a href="" class="btn btn-icons view_btn"><img
                                                src="./assets/images/view.svg" alt=""></a>
                                        <a href="" class="btn btn-icons edit_btn"><img
                                                src="./assets/images/edit.svg" alt=""></a>
                                        <a href="" class="btn btn-icons dlt_btn"><img
                                                src="./assets/images/delete.svg" alt=""></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>


    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>

</html>
