<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @hasSection('title')
            @yield('title') |
        @endif {{ config('app.name') }}
    </title>


    @stack('meta')

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.ui.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset("assets/css/timepicker.css") }}" > --}}


    @stack('style')

    <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/timepicker.js') }}"></script> --}}

    @stack('header-script')


</head>

<body class="sliderbody">
    <div class="loading-wrap" style="display: none">
        <div class="loading-container">
            <div class="loading-image"><img src="{{ asset('assets/images/loader.svg') }}" alt=""></div>
            <span>Plese wait...</span>
        </div>
    </div>
    <nav class="navbar navbar-expand">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('assets/images/cortexlogo.svg') }}" alt="">
            </a>
            <ul class="navbar-nav ml-auto">
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarNotification" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarNotification">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li> --}}
                @php

                    $admin = Auth::guard('admin')->user();

                @endphp

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarLogin" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        @if ($admin->role === 'master')

                            <span>{{ $admin->name }}</span>

                        @else

                            <span>{{ substr($admin->email, 0, 5) }}</span>

                        @endif

                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarLogin">

                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('admin.logout') }}">Log Out </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>


    {{-- <div class="side-nav-toggle">
        <button class="btn btn-close-toggle"><img src="{{asset("assets/images/close.svg")}}" alt="close"></button>
    </div> --}}
    <div class="side-nav-toggle">
        <button class="btn btn-close-toggle"><span>Close</span></button>
    </div>

    <aside class="side_bar">

        <button class="btn btn-slider" onclick="ChangeMenu()"><img src="{{ asset('assets/images/menu-arrow.svg') }}"
                alt="slider"></button>

        <div class="sidebar-content js-simplebar">
            <ul class="sidebar-nav">
                {{-- <li class="side-item {{request()->is('admin/dashboard') ?'active':''}}">
                    <a href="{{route('admin.dashboard')}}">
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/iconshover/dashboard.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/icons/dashboard.svg")}}" alt="Dashboard">
                        </span>
                        Dashboard
                    </a>
                </li> --}}
                

                @if ($admin->role === 'master' || optional($admin->permission)->users === 'Y')
                    <li class="side-item {{ request()->is('admin/user') ? 'active' : '' }}">
                        <a href="{{ route('admin.user.index') }}">
                            <span class="side-icon">
                                <img src="{{ asset('assets/images/iconshover/user.svg') }}" alt="Users">
                            </span>
                            <span class="active-icon">
                                <img src="{{ asset('assets/images/icons/user.svg') }}" alt="Users">
                            </span>
                            <span class="menutext">
                                Users
                            </span>
                        </a>
                    </li>
                @endif

                @if ($admin->role === 'master')
                    <li class="side-item {{ request()->is('admin/admin_user*') ? 'active' : '' }}">
                        <a href="{{ route('admin.admin_user.index') }}">
                            <span class="side-icon">
                                <img src="{{ asset('assets/images/iconshover/community.svg') }}" alt="Dashboard">
                            </span>
                            <span class="active-icon">
                                <img src="{{ asset('assets/images/icons/community.svg') }}" alt="Dashboard">
                            </span>
                            <span class="menutext">
                                Admin Users
                            </span>
                        </a>
                    </li>
                @endif

                {{-- 
                <li class="side-item {{request()->is('admin/learn') ? 'active':''}}">
                    <a href="{{ route('admin.learn.index') }}">
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/iconshover/learn.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/icons/learn.svg")}}" alt="Dashboard">
                        </span>
                        Learn
                    </a>
                </li> --}}

                @if ($admin->role === 'master' || optional($admin->permission)->learn === 'Y')
                    <li class="side-item {{ request()->is('admin/learn*') ? 'active' : '' }}">
                        <a href="{{ route('admin.learn.index') }}">
                            <span class="side-icon">
                                <img src="{{ asset('assets/images/iconshover/learn.svg') }}" alt="Learn Icon">
                            </span>
                            <span class="active-icon">
                                <img src="{{ asset('assets/images/icons/learn.svg') }}" alt="Learn Active Icon">
                            </span>
                            <span class="menutext">
                                Learn
                            </span>
                        </a>
                    </li>
                @endif


                @if ($admin->role === 'master' || optional($admin->permission)->options === 'Y')
                    <li class="side-item side-dropdown">
                        <a
                            class="side-dropdown-toggle {{ request()->is('admin/category') || request()->is('admin/full-mock-exam-options') || request()->is('admin/payment') || request()->is('admin/payment-price') || request()->is('admin/coupon') ? 'active' : '' }}">
                            <span class="side-icon">
                                <img src="{{ asset('assets/images/iconshover/options.svg') }}" alt="Options">
                            </span>
                            <span class="active-icon">
                                <img src="{{ asset('assets/images/icons/options.svg') }}" alt="Options">
                            </span>
                            <span class="menutext">Options</span>
                        </a>
                        <ul class="side-dropdown-menu"
                            style="{{ !(request()->is('admin/category') || request()->is('admin/full-mock-exam-options') || request()->is('admin/payment') || request()->is('admin/payment-price') || request()->is('admin/coupon')) ? 'display: none;' : '' }}">
                            <!-- Category -->
                            <li class="side-item {{ request()->is('admin/category') ? 'active' : '' }}">
                                <a href="{{ route('admin.category.index') }}">
                                    <span class="side-icon">
                                        <img src="{{ asset('assets/images/iconshover/category.svg') }}"
                                            alt="Category">
                                    </span>
                                    <span class="active-icon">
                                        <img src="{{ asset('assets/images/icons/categoryyellow.svg') }}"
                                            alt="Category Active">
                                    </span>
                                    <span class="menutext">Category</span>
                                </a>
                            </li>

                            <!-- Exam Simulator -->
                            <li class="side-item {{ request()->is('admin/full-mock-exam-options') ? 'active' : '' }}">
                                <a href="{{ route('admin.exam.options') }}">
                                    <span class="side-icon">
                                        <img src="{{ asset('assets/images/iconshover/examsimulatoryellow.svg') }}"
                                            alt="Exam Simulator">
                                    </span>
                                    <span class="active-icon">
                                        <img src="{{ asset('assets/images/icons/examsimulator5.svg') }}"
                                            alt="Exam Simulator Active">
                                    </span>
                                    <span class="menutext">Exam Simulator</span>
                                </a>
                            </li>

                            <!-- Payment -->
                            <li class="side-item {{ request()->is('admin/payment') ? 'active' : '' }}">
                                <a href="{{ route('admin.payment.index') }}">
                                    <span class="side-icon">
                                        <img src="{{ asset('assets/images/iconshover/paymentyellow.svg') }}"
                                            alt="Payment">
                                    </span>
                                    <span class="active-icon">
                                        <img src="{{ asset('assets/images/icons/payment.svg') }}"
                                            alt="Payment Active">
                                    </span>
                                    <span class="menutext">Payment</span>
                                </a>
                            </li>

                            <!-- Price -->
                            <li class="side-item {{ request()->is('admin/payment-price') ? 'active' : '' }}">
                                <a href="{{ route('admin.payment-price.index') }}">
                                    <span class="side-icon">
                                        <img src="{{ asset('assets/images/iconshover/pricehoveryellow.svg') }}"
                                            alt="Price">
                                    </span>
                                    <span class="active-icon">
                                        <img src="{{ asset('assets/images/icons/price.svg') }}" alt="Price Active">
                                    </span>
                                    <span class="menutext">Price</span>
                                </a>
                            </li>

                            <!-- Coupon and Settings -->
                            <li class="side-item {{ request()->is('admin/coupon') ? 'active' : '' }}">
                                <a href="{{ route('admin.coupon.index') }}">
                                    <span class="side-icon">
                                        <img src="{{ asset('assets/images/iconshover/couponhoveryellow.svg') }}"
                                            alt="Coupon and Settings">
                                    </span>
                                    <span class="active-icon">
                                        <img src="{{ asset('assets/images/icons/coupon1.svg') }}"
                                            alt="Coupon and Settings Active">
                                    </span>
                                    <span class="menutext">Coupon and Settings</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif


                @if ($admin->role === 'master' || optional($admin->permission)->question_bank === 'Y')
                    <li class="side-item {{ request()->is('admin/question-bank*') ? 'active' : '' }}">
                        <a href="{{ route('admin.question-bank.index') }}">
                            <span class="side-icon">
                                <img src="{{ asset('assets/images/iconshover/questionbank.svg') }}" alt="Dashboard">
                            </span>
                            <span class="active-icon">
                                <img src="{{ asset('assets/images/icons/questionbank.svg') }}" alt="Dashboard">
                            </span>
                            <span class="menutext">
                                Question Bank
                            </span>
                        </a>
                    </li>
                @endif


                @if ($admin->role === 'master' || optional($admin->permission)->topic_exam === 'Y' || optional($admin->permission)->full_mock_exam === 'Y')

                    <li class="side-item side-dropdown">
                        <a
                            class="side-dropdown-toggle {{ request()->is('admin/topic-test*') || request()->is('admin/exam*') ? 'active' : '' }}">
                            <span class="side-icon">
                                <img src="{{ asset('assets/images/iconshover/examsimulator.svg') }}"
                                    alt="Exam Simulator">
                            </span>
                            <span class="active-icon">
                                <img src="{{ asset('assets/images/icons/examsimulator.svg') }}" alt="Exam Simulator">
                            </span>
                            <span class="menutext">
                                Exam Simulator
                            </span>
                        </a>
                        <ul class="side-dropdown-menu"
                            style="{{ !(request()->is('admin/topic-test*') || request()->is('admin/exam*')) ? 'display: none;' : '' }}">

                            @if ($admin->role === 'master' || optional($admin->permission)->topic_exam === 'Y')

                                <li class="side-item {{ request()->is('admin/topic-test*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.topic-test.index') }}">
                                        <span class="side-icon">
                                            <img src="{{ asset('assets/images/iconshover/topictesthover.svg') }}"
                                                alt="Topic Test">
                                        </span>
                                        <span class="active-icon">
                                            <img src="{{ asset('assets/images/icons/topictest.svg') }}"
                                                alt="Topic Test Active">
                                        </span>
                                        <span class="menutext">
                                            Topic Test
                                        </span>
                                    </a>
                                </li>

                            @endif

                            @if ($admin->role === 'master' || optional($admin->permission)->full_mock_exam === 'Y')

                            <li class="side-item {{ request()->is('admin/exam*') ? 'active' : '' }}">
                                <a href="{{ route('admin.exam.index') }}">
                                    <span class="side-icon">
                                        <img src="{{ asset('assets/images/iconshover/mockexamhover.svg') }}"
                                            alt="Full Mock Exam">
                                    </span>
                                    <span class="active-icon">
                                        <img src="{{ asset('assets/images/icons/mockexam.svg') }}"
                                            alt="Full Mock Exam Active">
                                    </span>
                                    <span class="menutext">
                                        Full Mock Exam
                                    </span>
                                </a>
                            </li>

                            @endif 

                        </ul>
                    </li>

                @endif
                


                @if ($admin->role === 'master' || optional($admin->permission)->live_teaching === 'Y')
                    <li class="side-item {{ request()->is('admin/live-class*') ? 'active' : '' }}">
                        <a href="{{ route('admin.live-class.index') }}">
                            <span class="side-icon">
                                <img src="{{ asset('assets/images/iconshover/onlineteaching.svg') }}"
                                    alt="Dashboard">
                            </span>
                            <span class="active-icon">
                                <img src="{{ asset('assets/images/icons/onlineteaching.svg') }}" alt="Dashboard">
                            </span>
                            <span class="menutext">
                                Live Teaching
                            </span>
                        </a>
                    </li>
                @endif


                @if ($admin->role === 'master' || optional($admin->permission)->community === 'Y')
                    <li class="side-item {{ request()->is('admin/community*') ? 'active' : '' }}">
                        <a href="{{ route('admin.community.index') }}">
                            <span class="side-icon">
                                <img src="{{ asset('assets/images/iconshover/community.svg') }}" alt="Dashboard">
                            </span>
                            <span class="active-icon">
                                <img src="{{ asset('assets/images/icons/community.svg') }}" alt="Dashboard">
                            </span>
                            <span class="menutext">
                                Community
                            </span>
                        </a>
                    </li>
                @endif

                @if ($admin->role === 'master' || optional($admin->permission)->pages === 'Y')
                    <li class="side-item side-dropdown">
                        <a class="side-dropdown-toggle">
                            <span class="side-icon">
                                <img src="{{ asset('assets/images/iconshover/pages.svg') }}" alt="Pages">
                            </span>
                            <span class="active-icon">
                                <img src="{{ asset('assets/images/icons/pages.svg') }}" alt="Pages Active">
                            </span>
                            <span class="menutext">Pages</span>
                        </a>
                        <ul class="side-dropdown-menu">
                            <li class="side-item {{ request()->is('admin/page') ? 'active' : '' }}">
                                <a href="{{ route('admin.page.index') }}">
                                    <span class="side-icon">
                                        <img src="{{ asset('assets/images/iconshover/homehover.svg') }}"
                                            alt="Home">
                                    </span>
                                    <span class="active-icon">
                                        <img src="{{ asset('assets/images/icons/home.svg') }}" alt="Home Active">
                                    </span>
                                    <span class="menutext">Home</span>
                                </a>
                            </li>
                            <li class="side-item {{ request()->is('admin/faq') ? 'active' : '' }}">
                                <a href="{{ route('admin.faq.index') }}">
                                    <span class="side-icon">
                                        <img src="{{ asset('assets/images/iconshover/faqhover.svg') }}"
                                            alt="FAQ">
                                    </span>
                                    <span class="active-icon">
                                        <img src="{{ asset('assets/images/icons/faq.svg') }}" alt="FAQ Active">
                                    </span>
                                    <span class="menutext">FAQ</span>
                                </a>
                            </li>
                            <li class="side-item {{ request()->is('admin/support') ? 'active' : '' }}">
                                <a href="{{ route('admin.support.index') }}">
                                    <span class="side-icon">
                                        <img src="{{ asset('assets/images/iconshover/support.svg') }}"
                                            alt="Support">
                                    </span>
                                    <span class="active-icon">
                                        <img src="{{ asset('assets/images/icons/support.svg') }}"
                                            alt="Support Active">
                                    </span>
                                    <span class="menutext">Support</span>
                                </a>
                            </li>
                            <li class="side-item {{ request()->is('admin/tip') ? 'active' : '' }}">
                                <a href="{{ route('admin.tip.index') }}">
                                    <span class="side-icon">
                                        <img src="{{ asset('assets/images/iconshover/tipsandadvice.svg') }}"
                                            alt="Tips and Advice">
                                    </span>
                                    <span class="active-icon">
                                        <img src="{{ asset('assets/images/icons/tipsandadvice.svg') }}"
                                            alt="Tips and Advice Active">
                                    </span>
                                    <span class="menutext">Tips and Advice</span>
                                </a>
                            </li>
                            <li class="side-item {{ request()->is('admin/course') ? 'active' : '' }}">
                                <a href="{{ route('admin.course.index') }}">
                                    <span class="side-icon">
                                        <img src="{{ asset('assets/images/iconshover/coursehover.svg') }}"
                                            alt="Course">
                                    </span>
                                    <span class="active-icon">
                                        <img src="{{ asset('assets/images/icons/course.svg') }}" alt="Course Active">
                                    </span>
                                    <span class="menutext">Course</span>
                                </a>
                            </li>
                            <li class="side-item {{ request()->is('admin/privacy') ? 'active' : '' }}">
                                <a href="{{ route('admin.privacy.index') }}">
                                    <span class="side-icon">
                                        <img src="{{ asset('assets/images/iconshover/privacyhover.svg') }}"
                                            alt="Privacy Policy">
                                    </span>
                                    <span class="active-icon">
                                        <img src="{{ asset('assets/images/icons/privacy.svg') }}"
                                            alt="Privacy Policy Active">
                                    </span>
                                    <span class="menutext">Privacy Policy</span>
                                </a>
                            </li>
                            <li class="side-item {{ request()->is('admin/terms') ? 'active' : '' }}">
                                <a href="{{ route('admin.terms.index') }}">
                                    <span class="side-icon">
                                        <img src="{{ asset('assets/images/iconshover/termshover.svg') }}"
                                            alt="Terms & Conditions">
                                    </span>
                                    <span class="active-icon">
                                        <img src="{{ asset('assets/images/icons/terms.svg') }}"
                                            alt="Terms & Conditions Active">
                                    </span>
                                    <span class="menutext">Terms & Conditions</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif


                
                @if ($admin->role === 'master')

                    <li class="side-item {{ request()->is('admin/live-class*') ? 'active' : '' }}">
                        <a href="{{ route('admin.back_up_files.index') }}">
                            <span class="side-icon">
                                <img src="{{ asset('assets/images/iconshover/onlineteaching.svg') }}"
                                    alt="Dashboard">
                            </span>
                            <span class="active-icon">
                                <img src="{{ asset('assets/images/icons/onlineteaching.svg') }}" alt="Dashboard">
                            </span>
                            <span class="menutext">
                                Back up Files
                            </span>
                        </a>
                    </li>
                @endif


                <li class="side-item logout">
                    <a href="{{ route('admin.logout') }}" class="log-out">
                        <span class="side-icon">
                            <img src="{{ asset('assets/images/log-out.svg') }}" alt="log-out">
                        </span>
                        <span class="active-icon">
                            <img src="{{ asset('assets/images/log-out-1.svg') }}" title="Log Out" alt="log-out" data-title="Log Out" class="titledisplay">
                        </span> <span class="menutext">Log Out</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <main class="content_outer">
        @yield('content')
    </main>

    <x-toast-container />
    <x-confirm-popup />

    @stack('modals')

    @stack('before-script')




    <script>
        // function ChangeMenu()
        // {
        //     $('.side_bar').toggleClass('slider-btn');
        // }

        function ChangeMenu() {


            $('.sliderbody').toggleClass('slider-active');

            $('.side_bar').toggleClass('slider-btn');

            // Get the current state and save it in localStorage
            const isCollapsed = $('.side_bar').hasClass('slider-btn');
            const isCollapsed1 = $('.sliderbody').hasClass('slider-active');
if (isCollapsed) {
              
                
                $('.titledisplay').removeAttr('title');
            } else {
              
            
                $('.titledisplay').each(function () {
                    // Retrieve the data-title attribute value
                    var title = $(this).data('title');

                    // Set the title attribute with the value
                    $(this).attr('title', title);
             });
            }

            localStorage.setItem('sidebarCollapsed', isCollapsed);

            localStorage.setItem('sidebarCollapsed1', isCollapsed1);
        }

        // Function to initialize sidebar state based on localStorage
        function initializeSidebar() {

            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

            const isCollapsed1 = localStorage.getItem('sidebarCollapsed1') === 'true';
            

            // // Apply the class based on stored state
            // if (isCollapsed) {
            //     $('.side_bar').addClass('slider-btn');
            // } else {
            //     $('.side_bar').removeClass('slider-btn');
            // }


            if (!isCollapsed) {
                $('.side_bar').removeClass('slider-btn');
                
                $('.titledisplay').removeAttr('title');
            } else {
              
                
                $('.side_bar').addClass('slider-btn');
                
                
                $('.titledisplay').each(function () {
                    // Retrieve the data-title attribute value
                    var title = $(this).data('title');

                    // Set the title attribute with the value
                    $(this).attr('title', title);
             });
            }

            
            if (isCollapsed1) {
                $('.sliderbody').addClass('slider-active');
            } else {
                $('.sliderbody').removeClass('slider-active');
            }
        }

        // Call the initialize function on page load
        $(function() {
            initializeSidebar();
        });
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(xhr) {
                $('.loading-wrap').show();
            },
            complete: function(xhr, status) {
                $('.loading-wrap').hide();
            },
        });

        function handleFileUpload(file) {
            return new Promise((resolve, reject) => {
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

                // Validate file type
                if (!allowedTypes.includes(file.type)) {
                    reject({
                        code: 400,
                        status: 'Invalid File Type',
                        error: 'Only JPG, JPEG, and PNG formats are allowed.'
                    });
                    showToast('Upload failed. Only JPG, JPEG, and PNG formats are allowed.', 'danger', true);
                    return;
                }

                var formData = new FormData();
                formData.append("file", file);
                formData.append("foldername", "ckeditor");
                var toastId = showToast('Uploading... 0%', 'info', false);

                $.ajax({
                    url: "{{ route('admin.upload') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function(event) {
                            if (event.lengthComputable) {
                                var percentComplete = Math.round((event.loaded / event.total) *
                                    100);
                                updateToast(toastId, `Uploading... ${percentComplete}%`,
                                'info');
                            }
                        }, false);
                        return xhr;
                    },
                    success: function(response) {
                        updateToast(toastId, 'Upload complete!', 'success');
                        // resolve({  default: `${response.url}`   });
                        resolve(response);
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.status + ': ' + xhr.statusText + '\n' + xhr.responseText;
                        updateToast(toastId, 'File size exceeds 5MB. Please select a smaller file.',
                            'danger');
                        // reject(errorMessage)
                        reject({
                            code: xhr.status,
                            status: xhr.statusText,
                            error: xhr.responseText
                        })
                    }
                });
            });
        }

        function uploadButtonPlugin(editor) {
            editor.ui.addButton('UploadButton', {
                label: 'Upload Button',
                command: 'uploadButtonCommand',
                toolbar: 'insert',
                icon: '{{ asset('assets/images/paperclip1.svg') }}'
            });
            editor.addCommand('uploadButtonCommand', {
                exec: function(editor) {
                    var input = document.createElement('input');
                    input.type = 'file';
                    input.onchange = function() {
                        var file = input.files[0];
                        if (file) {
                            handleFileUpload(file).then(function(res) {
                                    if (res.mime_type.startsWith('image/')) {
                                        editor.insertHtml(` 
                                        <img alt="" src="${res.url}" width="600" height="400"  /> 
                                    `);
                                    } else if (res.mime_type.startsWith('video/')) {
                                        editor.insertHtml(` 
                                        <video alt="" controls src="${res.url}" type="${res.mime_type}" /> 
                                    `);
                                    } else {
                                        editor.insertHtml(` 
                                        <iframe alt="" src="${res.url}"  width="600" height="400" frameborder="0" type="${res.mime_type}" > </iframe> 
                                    `);
                                    }

                                })
                                .catch(function(error) {
                                    console.error('Error uploading file:', error);
                                });;
                        }
                    };
                    input.click();
                }
            });
        }
        $(document).on('hidden.bs.modal', '.modal', function() {
            $(this).find('form').trigger("reset");
        })
    </script>
    <script src="{{ asset('assets/js/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>


    <script>
        $(document).ready(function() {
            // Loop through each .side-dropdown-menu to check if it has an active item
            $('.side-dropdown-menu').each(function() {
                if ($(this).find('.side-item.active').length) {
                    $(this).css('display',
                    'block'); // Show only this dropdown menu if it has an active item
                } else {
                    $(this).css('display', 'none'); // Hide other dropdown menus
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            var note = $('<p><strong>Note:</strong> Supported Image formats: jpg, png, jpeg. Max size: 5MB</p>');
            $('#editor').prepend(note); // Adds the note to the editor

            $('#image-upload').on('change', function() {
                var file = this.files[0]; // Get the selected file
                var maxSize = 5 * 1024 * 1024; // 5MB in bytes

                if (file && file.size > maxSize) {

                    var note1 = $(
                        '<p><strong>Note:</strong> File size exceeds 5MB. Please select a smaller file.</p>'
                        );
                    $('#editor').prepend(note1);
                    // alert('File size exceeds 5MB. Please select a smaller file.');
                    $(this).val(''); // Clear the input
                }
            });
        });
    </script>



    @stack('footer-script')
</body>

</html>
