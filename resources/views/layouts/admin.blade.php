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

    <link rel="shortcut icon" href="{{ asset("assets/images/favicon.png") }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset("assets/css/datatables.min.css") }}" >
    <link rel="stylesheet" href="{{ asset("assets/css/select2.min.css") }}" >
    <link rel="stylesheet" href="{{ asset("assets/css/select2.min.css") }}" >
    <link rel="stylesheet" href="{{ asset("assets/css/jquery.ui.css") }}" >
    
    @stack('style')

    <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    @stack('header-script')


</head>

<body>
    <div class="loading-wrap" style="display: none">
        <div class="loading-container">
            <div class="loading-image"><img src="{{asset('assets/images/loader.svg')}}" alt=""></div>
            <span>Plese wait...</span>
        </div>
    </div>
    <nav class="navbar navbar-expand" >
        <div class="container">
            <a class="navbar-brand"  href="{{ url('/') }}">
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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarLogin" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>{{auth('admin')->user()->name}}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarLogin">
                       
                        <a class="dropdown-item" href="{{route('admin.dashboard')}}">Dashboard</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('admin.logout')}}">Log Out </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <aside class="side_bar">
        <div class="side-nav-toggle">
            <button class="btn btn-close-toggle"><img src="{{asset("assets/images/close.svg")}}" alt="close"></button>
        </div>
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
                <li class="side-item {{request()->is('admin/user') ? 'active':''}}">
                    <a href="{{route("admin.user.index")}}">
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/iconshover/user.svg")}}"  alt="Users">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/icons/user.svg")}}" alt="Users">
                        </span>
                        Users
                    </a>
                </li>

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
                <li class="side-item {{ request()->is('admin/learn*') ? 'active' : '' }}">
                    <a href="{{ route('admin.learn.index') }}">
                        <span class="side-icon">
                            <img src="{{ asset('assets/images/iconshover/learn.svg') }}" alt="Learn Icon">
                        </span>
                        <span class="active-icon">
                            <img src="{{ asset('assets/images/icons/learn.svg') }}" alt="Learn Active Icon">
                        </span>
                        Learn
                    </a>
                </li>
                

                <li class="side-item side-dropdown ">
                    <a class="side-dropdown-toggle" >
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/iconshover/options.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/icons/options.svg")}}" alt="Dashboard">
                        </span>
                        Options
                    </a>
                    <ul class="side-dropdown-menu" >
                        <li class="side-item {{request()->is('admin/category') ?'active':''}} "><a href="{{ route('admin.category.index') }}">Category</a></li>
                        <li class="side-item {{request()->is('admin/exam') ? 'active':''}} "><a href="{{route('admin.exam.options')}}">Exam Simulator</a></li>
                        <li class="side-item {{request()->is('admin/payment') ? 'active':''}} "><a href="{{route('admin.payment.index')}}">Payment</a></li>
                        <li class="side-item {{request()->is('admin/payment-price') ? 'active':''}} "><a href="{{route('admin.payment-price.index')}}">Price</a></li>
                        <li class="side-item {{request()->is('admin/coupon') ? 'active':''}} "><a href="{{route('admin.coupon.index')}}">Coupon and Settings</a></li>
                    </ul>
                </li> 

                <li class="side-item {{request()->is('admin/question-bank*') ? 'active':''}}">
                    <a href="{{ route('admin.question-bank.index') }}">
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/iconshover/questionbank.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/icons/questionbank.svg")}}" alt="Dashboard">
                        </span>
                        Question Bank
                    </a>
                </li>
                <li class="side-item side-dropdown ">
                    <a class="side-dropdown-toggle" >
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/iconshover/examsimulator.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/icons/examsimulator.svg")}}" alt="Dashboard">
                        </span>
                        Exam Simulator
                    </a>
                    <ul class="side-dropdown-menu" >
                        <li class="side-item {{request()->is('admin/topic-test*') ? 'active':''}} "><a href="{{route('admin.topic-test.index')}}">Topic Test</a></li>
                        <li class="side-item {{request()->is('admin/exam*') ? 'active':''}} "><a href="{{route('admin.exam.index')}}">Full Mock Exam</a></li>
                    </ul>
                </li>

                <li class="side-item {{request()->is('admin/live-class*') ? 'active':''}}">
                    <a href="{{ route('admin.live-class.index') }}">
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/iconshover/onlineteaching.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/icons/onlineteaching.svg")}}" alt="Dashboard">
                        </span>
                        Live Teaching
                    </a>
                </li>


                <li class="side-item {{request()->is('admin/community*') ? 'active':''}}">
                    <a href="{{ route('admin.community.index') }}">
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/iconshover/community.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/icons/community.svg")}}" alt="Dashboard">
                        </span>
                        Community
                    </a>
                </li>

                <li class="side-item side-dropdown ">
                    <a class="side-dropdown-toggle" >
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/iconshover/pages.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/icons/pages.svg")}}" alt="Dashboard">
                        </span>
                        Pages
                    </a>
                    <ul class="side-dropdown-menu" >
                        <li class="side-item {{request()->is('admin/page') ?'active':''}} "><a href="{{ route('admin.page.index') }}">Home</a></li>
                        <li class="side-item {{request()->is('admin/faq') ? 'active':''}} "><a href="{{route('admin.faq.index')}}">FAQ</a></li>
                        <li class="side-item {{request()->is('admin/support') ? 'active':''}} "><a href="{{route('admin.support.index')}}">Support</a></li>
                        <li class="side-item {{request()->is('admin/tip') ? 'active':''}} "><a href="{{route('admin.tip.index')}}">Tips and Advice</a></li>

                        <li class="side-item {{request()->is('admin/course') ? 'active':''}} "><a href="{{route('admin.course.index')}}">Course</a></li>

                        <li class="side-item {{request()->is('admin/privacy') ? 'active':''}} "><a href="{{route('admin.privacy.index')}}">Privacy Policy</a></li>
                        <li class="side-item {{request()->is('admin/terms') ? 'active':''}} "><a href="{{route('admin.terms.index')}}">Terms & Conditions</a></li>
                    </ul>
                </li>

                {{-- <li class="side-item {{request()->is('admin/faq') ? 'active':''}}">
                    <a href="{{ route('admin.faq.index') }}">
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/Dashboard-wht.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/Dashboard-blk.svg")}}" alt="Dashboard">
                        </span>
                        Faq
                    </a>
                </li> --}}

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
        @yield('content')
    </main>

    <x-toast-container />
    <x-confirm-popup />

    @stack('modals')

    @stack('before-script')
    <script>
        $.ajaxSetup({
             headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             beforeSend:function(xhr){
                 $('.loading-wrap').show();
             },
             complete:function(xhr,status){
                 $('.loading-wrap').hide();
             },
        });
        function handleFileUpload(file){
            return new Promise((resolve, reject) => {
                var formData = new FormData();
                formData.append("file", file);
                formData.append("foldername", "ckeditor");
                var toastId = showToast('Uploading... 0%', 'info', false);

                $.ajax({
                    url : "{{route('admin.upload')}}",
                    type : 'POST',
                    data : formData,
                    processData: false,
                    contentType: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function(event) {
                            if (event.lengthComputable) {
                                var percentComplete = Math.round((event.loaded / event.total) * 100);
                                updateToast(toastId, `Uploading... ${percentComplete}%`, 'info');
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
                        updateToast(toastId, 'Upload failed.', 'danger');
                        // reject(errorMessage)
                        reject({code:xhr.status,status:xhr.statusText,error:xhr.responseText})
                    }
                });
            });
        }
        function uploadButtonPlugin(editor){
            editor.ui.addButton('UploadButton', {
                label: 'Upload Button',
                command: 'uploadButtonCommand',
                toolbar: 'insert',
                icon: '{{asset("assets/images/paperclip1.svg")}}'
            });
            editor.addCommand('uploadButtonCommand', {
                exec: function(editor) {
                    var input = document.createElement('input');
                    input.type = 'file';
                    input.onchange = function() {
                        var file = input.files[0];
                        if (file) {
                            handleFileUpload(file).then(function(res) {
                                if(res.mime_type.startsWith('image/')){
                                    editor.insertHtml(` 
                                        <img alt="" src="${res.url}" width="600" height="400"  /> 
                                    `);
                                }else if(res.mime_type.startsWith('video/')){
                                    editor.insertHtml(` 
                                        <video alt="" controls src="${res.url}" type="${res.mime_type}" /> 
                                    `);
                                }else{
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
        $(document).on('hidden.bs.modal','.modal',function(){
            $(this).find('form').trigger("reset");
        })
    </script>
    <script src="{{ asset('assets/js/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>

    @stack('footer-script')
</body>

</html>
