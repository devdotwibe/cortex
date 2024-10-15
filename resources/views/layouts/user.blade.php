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

<body class="sliderbody">

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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarLogin" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>{{ ucfirst(auth('web')->user()->name) }}</span>
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

    <div class="sidebar-menu">
        <a href="" class="sidebar-toggle">
            <span class="line"></span>
        </a>
    </div>

    <aside class="side_bar">

        <button class="btn btn-slider" onclick="ChangeMenu()"><img src="{{asset("assets/images/menu-arrow.svg")}}" alt="slider"></button>

        <div class="side-nav-toggle">
            <button class="btn btn-close-toggle"><img src="{{asset("assets/images/close.svg")}}" alt="close"></button>
        </div>
        <div class="sidebar-content js-simplebar">
            <ul class="sidebar-nav">
                <li class="side-item  {{request()->is('dashboard') ? 'active':''}}">
                    <a href="{{route('dashboard')}}">
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/iconshover/dashboard.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/icons/dashboard.svg")}}" alt="Dashboard">
                        </span>
                        <span class="menutext">
                        Home
                    </span>
                    </a>
                </li>
                <li class="side-item status">
                    <span class="side-label menutext">
                        
                        Thinking Skills NSW
                    </span>
                    <span class="side-trail">
                        @php
                            $user = Auth::user();
                            $subscriptionStatus = optional($user->subscription())->status ?? 'Free Trial';
                        @endphp
                        {{ $user->is_free_access ? 'Free Trial' : ($subscriptionStatus === 'subscribed' ? 'Premium' : 'Free Trial') }}
                    </span>
                </li>
                
                
        

                <li class="side-item {{request()->is('learn*') ? 'active' :''}}">
                    <a href="{{ route('learn.index') }}">
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/iconshover/learn.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/icons/learn.svg")}}" alt="Dashboard">
                        </span>
                        <span class="menutext">
                        Learn
                        </span>
                    </a>
                </li>

                <li class="side-item {{request()->is('question-bank*') ? 'active':''}}">
                    <a href="{{ route('question-bank.index') }}">
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/iconshover/questionbank.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/icons/questionbank.svg")}}" alt="Dashboard">
                        </span>
                        <span class="menutext">
                        Question Bank
                        </span>
                    </a>
                </li>
               


                <li class="side-item side-dropdown ">
                    <a class="side-dropdown-toggle {{ request()->is('topic-test') || request()->is('full-mock-exam') ? 'active' : '' }}">
                        <span class="side-icon">
                            <img src="{{ asset('assets/images/iconshover/examsimulator.svg') }}" alt="Exam Simulator">
                        </span>
                        <span class="active-icon">
                            <img src="{{ asset('assets/images/icons/examsimulator.svg') }}" alt="Exam Simulator">
                        </span>
                        <span class="menutext">Exam Simulator</span>
                    </a>
                    <ul class="side-dropdown-menu" style="{{ request()->is('topic-test') || request()->is('full-mock-exam') ? 'display: block;' : '' }}">
                        <li class="side-item {{ request()->is('topic-test') ? 'active' : '' }}">
                            <a href="{{ route('topic-test.index') }}">
                                <span class="side-icon">
                                    <img src="{{ asset('assets/images/iconshover/topictesthover.svg') }}" alt="Topic Test">
                                </span>
                                <span class="active-icon">
                                    <img src="{{ asset('assets/images/icons/topictest.svg') }}" alt="Topic Test Active">
                                </span>
                                <span class="menutext">Topic Test</span>
                            </a>
                        </li>
                        <li class="side-item {{ request()->is('full-mock-exam') ? 'active' : '' }}">
                            <a href="{{ route('full-mock-exam.index') }}">
                                <span class="side-icon">
                                    <img src="{{ asset('assets/images/iconshover/mockexamhover.svg') }}" alt="Full Mock Exam">
                                </span>
                                <span class="active-icon">
                                    <img src="{{ asset('assets/images/icons/mockexam.svg') }}" alt="Full Mock Exam Active">
                                </span>
                                <span class="menutext">Full Mock Exam</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                

                <li class="side-item {{request()->is('live-class*') ? 'active':''}}">
                   
                        <a @if(auth('admin')->check() &&!(auth('web')->user()->is_free_access) && (optional(auth('web')->user()->subscription())->status ?? "") !== "subscribed") data-bs-toggle="modal" data-bs-target="#adminsubModal"  @else href="{{ route('live-class.index') }}" @endif >  
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/iconshover/onlineteaching.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/icons/onlineteaching.svg")}}" alt="Dashboard">
                        </span>
                        <span class="menutext">
                        Live Teaching
                        </span>
                    </a>
                </li>

                <li class="side-item {{request()->is('analytics') ? 'active':''}}">
                    
                    {{-- <a @if(auth('admin')->check() &&!(auth('web')->user()->is_free_access) && (optional(auth('web')->user()->subscription())->status ?? "") == "subscribed") href="{{ route('analytics.index') }}" @else data-bs-toggle="modal" data-bs-target="#adminsubModal" @endif > --}}
                        <a @if(auth('admin')->check() &&!(auth('web')->user()->is_free_access) && (optional(auth('web')->user()->subscription())->status ?? "") !== "subscribed") data-bs-toggle="modal" data-bs-target="#adminsubModal"  @else href="{{ route('analytics.index') }}" @endif >  
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/iconshover/analytics.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/icons/analytics.svg")}}" alt="Dashboard">
                        </span>
                        <span class="menutext">
                        Analytics
                        </span>
                    </a>
                </li>
                @guest('admin')
                <li class="side-item {{request()->is('community*') ? 'active':''}}">
                  
                    <a @if(auth('admin')->check() &&!(auth('web')->user()->is_free_access) && (optional(auth('web')->user()->subscription())->status ?? "") !== "subscribed") data-bs-toggle="modal" data-bs-target="#adminsubModal"  @else href="{{ route('community.index') }}" @endif >
                          
                        <span class="side-icon" >
                            <img src="{{asset("assets/images/iconshover/community.svg")}}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/icons/community.svg")}}" alt="Dashboard">
                        </span>
                        <span class="menutext">
                        Community
                        </span>
                    </a>
                </li>

               


                 {{-- <li class="side-item {{request()->is('tipsandadvice*') ? 'active':''}}">

                  
                        <a @if(auth('admin')->check() &&!(auth('web')->user()->is_free_access) && (optional(auth('web')->user()->subscription())->status ?? "") !== "subscribed") data-bs-toggle="modal" data-bs-target="#adminsubModal"  @else href="{{ route('tipsandadvise.index') }}" @endif >
                          

                         <span class="side-icon" >
                             <img src="{{asset("assets/images/iconshover/tipsandadvice.svg")}}" alt="Dashboard">
                         </span>
                         <span class="active-icon">
                             <img src="{{asset("assets/images/icons/tipsandadvice.svg")}}" alt="Dashboard">
                         </span>
                         <span class="menutext">
                         Tips And Advice
                         </span>
                     </a>
                 </li> --}}


                 <li class="side-item {{request()->is('tipsandadvice*') ? 'active':''}}">
                    
                    
                    <a @if(!auth('admin')->check() && !(auth('web')->user()->is_free_access) && (optional(auth('web')->user()->subscription())->status ?? "") !== "subscribed") 
                        data-bs-toggle="modal" 
                        data-bs-target="#lockedModal" {{-- Show the modal for free users --}}
                    @else
                        href="{{ route('tipsandadvise.index') }}" {{auth('web')->user()->is_free_access}} terdt {{optional(auth('web')->user()->subscription())->status }}{{-- Subscribed users will access the actual route --}}
                    @endif
                >
                        <span class="side-icon">
                            <img src="{{ asset('assets/images/iconshover/tipsandadvice.svg') }}" alt="Dashboard">
                        </span>
                        <span class="active-icon">
                            <img src="{{ asset('assets/images/icons/tipsandadvice.svg') }}" alt="Dashboard">
                        </span>
                        <span class="menutext">
                            Tips And Advice
                        </span>
                    </a>
                </li>
                
<div class="supportsection">
                 <li class="side-item {{request()->is('support') ? 'active':''}}">
                       
                    <a href="{{route('support.index')}}">


                         <span class="side-icon" >
                             <img src="{{asset("assets/images/iconshover/support.svg")}}" alt="Dashboard">
                         </span>
                         <span class="active-icon">
                             <img src="{{asset("assets/images/icons/support.svg")}}" alt="Dashboard">
                         </span>
                         <span class="menutext">
                         Support
                         </span>
                     </a>
                 </li>

                <li class="side-item logout">
                    <a href="{{route('logout')}}" class="log-out">
                        <span class="side-icon">
                            <img src="{{asset("assets/images/log-out.svg")}}" alt="log-out">
                        </span>
                        <span class="active-icon">
                            <img src="{{asset("assets/images/log-out-1.svg")}}" alt="log-out">
                        </span>
                        <span class="menutext"> Log Out </span>
                    </a>
                </li>

            </div>
                @endguest
            </ul>
        </div>
    </aside>
    <main class="content_outer">
        @if(!auth('web')->user()->hasVerifiedEmail())
        <div class="warning-container">
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif
            <div class="alert alert-warning" role="alert">
                <p class="userverify">Before proceeding, please check your email for a verification link. If you did not receive the email</p>
                <a href="{{ route('verification.resend') }}" class="btn btn-link">{{ __('click here to request another') }}</a>
            </div>
        </div>

        @endif
        @yield('content')
    </main>

    <x-toast-container />
    <x-confirm-popup />
 

    @stack('modals')
<!-- Modal -->
<div class="modal fade" id="adminsubModal" tabindex="-1" aria-labelledby="adminsubModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminsubModalLabel">Subscription Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Candidate Not Subscriber Plan
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<!-- Locked Content Modal -->
<div id="lockedModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Content Locked</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeLockedModal1()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>The content is locked and a subscription is required.</p>
            </div>
            <div class="modal-footer">
                <a href="{{ route('pricing.index') }}#our-plans" class="btn btn-primary">View Pricing Plans</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeLockedModal1()">Close</button>
            </div>
        </div>
    </div>
</div>

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


    localStorage.setItem('sidebarCollapsed', isCollapsed);

    localStorage.setItem('sidebarCollapsed1', isCollapsed1);
}

// Function to initialize sidebar state based on localStorage
function initializeSidebar() {

    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

    const isCollapsed1 = localStorage.getItem('sidebarCollapsed1') === 'true';

    // Apply the class based on stored state
    if (isCollapsed) {
        $('.side_bar').addClass('slider-btn');
    } else {
        $('.side_bar').removeClass('slider-btn');
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


        $(function() {
          
            $('#showModalButton').click(function() {
                $('#adminsubModal').modal('show'); // Show the modal using jQuery
            });
        });

     </script>


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
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

// Validate file type
if (!allowedTypes.includes(file.type)) {
    reject({ code: 400, status: 'Invalid File Type', error: 'Only JPG, JPEG, and PNG formats are allowed.' });
    showToast('Upload failed. Only JPG, JPEG, and PNG formats are allowed.', 'danger', true);
    return;
}

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
                        updateToast(toastId, 'File size exceeds 5MB. Please select a smaller file.', 'danger');
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
    </script>
    <script src="{{ asset('assets/js/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

    {{-- <script>

$(document).ready(function() {
       
       console.log('test');
       if ($('.side-dropdown-menu .side-item.active').length) {

           console.log('active');
           $('.side-dropdown-menu').css('display', 'block');

       }
   });


    </script> --}}


    <script>

       

        $(document).ready(function() {
            // Loop through each .side-dropdown-menu to check if it has an active item
            $('.side-dropdown-menu').each(function() {
                if ($(this).find('.side-item.active').length) {
                    $(this).css('display', 'block'); // Show only this dropdown menu if it has an active item
                } else {
                    $(this).css('display', 'none');  // Hide other dropdown menus
                }
            });
        });
        
                
                
                    </script>

<script>
    function showLockedModal() {
        document.getElementById('lockedModal').style.display = 'block';
    }
    
    function closeLockedModal1() {
        
        $('#lockedModal').modal('hide');
    }
    </script>

<script>
    $(document).ready(function() {
      var note = $('<p><strong>Note:</strong> Supported Image formats: jpg, png, jpeg. Max size: 5MB</p>');
      $('#editor').prepend(note);  // Adds the note to the editor
  
      $('#image-upload').on('change', function() {
          var file = this.files[0];  // Get the selected file
          var maxSize = 5 * 1024 * 1024; // 5MB in bytes
  
          if (file && file.size > maxSize) {
  
              var note1 = $('<p><strong>Note:</strong> File size exceeds 5MB. Please select a smaller file.</p>');
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
