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

    @stack('style')

    <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
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
                    <a class="nav-link dropdown-toggle" id="navbarLogin" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>{{auth('web')->user()->name}}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarLogin">
                        <a class="dropdown-item" href="{{route('dashboard')}}">Dashboard</a>
                        @guest('admin')
                        <a class="dropdown-item" href="{{ route('profile.view') }}">Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('logout')}}">Log Out </a>                            
                        @endguest
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
                <li class="side-item  {{request()->is('dashboard') ? 'active':''}}">
                    <a href="{{route('dashboard')}}">
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/Dashboard-wht.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/Dashboard-blk.svg")}}" alt="Dashboard">
                        </span>
                        Dashboard
                    </a>
                </li>
                
                <li class="side-item {{request()->is('learn') ? 'active' :''}}">
                    <a href="{{ route('learn.index') }}">
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/Dashboard-wht.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/Dashboard-blk.svg")}}" alt="Dashboard">
                        </span>
                        Learn
                    </a>
                </li>                    
                
                <li class="side-item {{request()->is('question-bank') ? 'active':''}}">
                    <a href="{{ route('question-bank.index') }}">
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/Dashboard-wht.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/Dashboard-blk.svg")}}" alt="Dashboard">
                        </span>
                        Question Bank
                    </a>
                </li>
                <li class="side-item side-dropdown">
                    <a class="side-dropdown-toggle" >
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/Dashboard-wht.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/Dashboard-blk.svg")}}" alt="Dashboard">
                        </span>
                        Exam Simulator
                    </a>
                    <ul class="side-dropdown-menu" >
                        <li class="side-item {{request()->is('topic-test') ? 'active':''}}" ><a href="{{route('topic-test.index')}}">Topic Test</a></li>
                        <li class="side-item {{request()->is('full-mock-exam') ? 'active':''}}"><a href="{{route('full-mock-exam.index')}}">Full Mock Exam</a></li>
                    </ul>
                </li>

                <li class="side-item {{request()->is('live-class') ? 'active':''}}">
                    @if (auth('web')->user()->progress('cortext-subscription-payment','')=="paid") 
                        <a href="{{ route('live-class.index') }}">
                    @else
                        <a data-bs-toggle="modal" data-bs-target="#cortext-subscription-payment-modal"> 
                    @endif 
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/Dashboard-wht.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/Dashboard-blk.svg")}}" alt="Dashboard">
                        </span>
                        Live Teaching
                    </a>
                </li>

                <li class="side-item {{request()->is('analytics') ? 'active':''}}">
                    <a href="{{ route('analytics.index') }}">
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/Dashboard-wht.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/Dashboard-blk.svg")}}" alt="Dashboard">
                        </span>
                        Analytics
                    </a>
                </li>
                @guest('admin') 
                <li class="side-item {{request()->is('community') ? 'active':''}}">
                    <a href="{{ route('community.index') }}">
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/Dashboard-wht.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/Dashboard-blk.svg")}}" alt="Dashboard">
                        </span>
                        Community
                    </a>
                </li>
                <li class="side-item logout">
                    <a href="{{route('logout')}}" class="log-out">
                        <span class="side-icon">
                            <img src="{{asset("assets/images/log-out.svg")}}" alt="log-out">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/log-out-1.svg")}}" alt="log-out">
                        </span> Log Out
                    </a>
                </li>
                @endguest
            </ul>
        </div>
    </aside>
    <main class="content_outer">
        @yield('content')
    </main>

    <x-toast-container />
    <x-confirm-popup />

    @if ($user->progress('cortext-subscription-payment','')!="paid")
    <div class="modal fade" id="cortext-subscription-payment-modal" tabindex="-1" role="dialog"  aria-labelledby="cortext-subscription-paymentLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cortext-subscription-paymentLablel">Subscription</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('payment.subscription')}}"  id="cortext-subscription-payment-form" >
                        <p>The {{config('app.name')}} Subscription Peyment required </p>
                        <button type="button" data-bs-dismiss="modal"  class="btn btn-secondary">Cancel</button>
                        <button type="submit" class="btn btn-dark">Pay Now ${{ get_option('stripe.subscription.payment.amount-price','0') }} </button>
                    </form>
                </div>
    
            </div>
        </div>
    </div>
    @endif

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
                                    <figure class="image-area">
                                        <img alt="" src="${res.url}" width="600" height="400"  />
                                    </figure>
                                    `);
                                }else if(res.mime_type.startsWith('video/')){
                                    editor.insertHtml(`
                                    <figure class="video-area">
                                        <video alt="" controls src="${res.url}" type="${res.mime_type}" />
                                    </figure>
                                    `);
                                }else{
                                    editor.insertHtml(`
                                    <figure class="frame-area">
                                        <iframe alt="" src="${res.url}"  width="600" height="400" frameborder="0" type="${res.mime_type}" > </iframe>
                                    </figure>
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
    </script>
    <script src="{{ asset('assets/js/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    @stack('footer-script')
</body>

</html>
