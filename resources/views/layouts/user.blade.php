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
                        <a class="dropdown-item" href="{{ route('profile.view') }}">Profile</a>
                        <a class="dropdown-item" href="#">Settings</a>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-item" href="{{route('logout')}}">Log Out </div>
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
                <li class="side-item  active ">
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
                 
                <li class="side-item">
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

                <li class="side-item">
                    <a href="{{ route('admin.options.index') }}">
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/Dashboard-wht.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/Dashboard-blk.svg")}}" alt="Dashboard">
                        </span>
                        Options
                    </a>
                </li>
                <li class="side-item">
                    <a href="{{ route('admin.question-bank.index') }}">
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/Dashboard-wht.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/Dashboard-blk.svg")}}" alt="Dashboard">
                        </span>
                        Question Bank
                    </a>
                </li> 
                <li class="side-item side-dropdown ">
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
                        <li class="side-item "><a href="{{route('admin.topic-test.index')}}">Topic Test</a></li> 
                        <li class="side-item "><a href="{{route('admin.exam.index')}}">Full Mock Exam</a></li> 
                    </ul>
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
            </ul>
        </div>
    </aside>
    <main class="content_outer">
        @yield('content')
    </main>

    <x-toast-container />

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
    @stack('footer-script')
</body>

</html>
