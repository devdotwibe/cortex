@extends('layouts.admin')
@section('title', 'Community')
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>Community</h2>
            </div>
            <div class="header_right">
                <ul class="nav_bar">
                    <li class="nav_item"><a href="{{ route('admin.community.report.index') }}" class="nav_link btn">Hashtags</a></li>
                    <li class="nav_item"><a href="{{ route('admin.community.report.index') }}" class="nav_link btn">Reported
                            Post</a></li>
                    <li class="nav_item"><a href="{{ route('admin.community.post.create') }}" class="nav_link btn">Create
                            Post</a></li>
                </ul>
            </div>
        </div>
    </section>

    <section class="post-section">
        <div class="post-row">
            <div class="post-container1">
                <div class="row">
                    <!-- Left Sidebar for Hashtags -->
                    <div class="post-col1">
                        <h4>Channels</h4>


                        <!-- Link styled as a textbox -->
                        <div class="mb-3 back-btn-wrapp">
                            <label for="backtoall" class="form-label"></label>
                            <a href="{{ route('admin.community.index') }}" id="backtoall"
                                class="form-control text-decoration-none"
                                >
                                #Backtoall
                            </a>
                        </div>  
                       
                        <div class="hashtag-wrapp">  
                            <ul class="list-group"  >  
                                @foreach ($hashtags as $hashtag)
                                    <li class="list-group-item d-inline-block" >
                                        <a
                                            href="{{ route('admin.community.index', ['hashtag' => $hashtag]) }}">{{ $hashtag }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="drophash hashtagdropdown">
                      
                        <select id="hashtagDropdown" class="form-select" onchange="location = this.value;">
                            <option value="">Choose a Channel</option> <!-- Default option -->
                            @foreach ($hashtags as $hashtag)
                                <option value="{{ route('admin.community.index', ['hashtag' => $hashtag]) }}">{{ $hashtag }}</option>
                            @endforeach
                        </select>
                    </div>
        

                </div>
            </div>

           



            <div class="post-container-wrapp">
                <div class="post-container" id="post-item-list">

                </div>
            </div>

            <div class="post-search">
                <form id="searchForm" action="">
                    <div class="text-field">
                        <input type="search" id="searchInput" placeholder="Search for Posts" aria-label="Search for Posts" oninput="performSearch()">
                        <button type="button" class="search-btn" onclick="toggleSearchResults()"><img src="{{ asset('assets/images/searc-icon.svg') }}" alt=""></button>
                        <div class="searchclass">
                            <div id="searchResults" name="searchres" ></div> <!-- Container for displaying search results -->
                            </div>
                    </div>
                </form>
                
            </div>
            
            
        </div>
        <div class="post-action">
            <button id="load-more-btn" class="btn btn-outline-dark" style="display: none"> Load More </button>
        </div>
    </section>

@endsection


@push('footer-script')

<script>
    function toggleSearchResults() {

    
        $('.post-search').toggleClass('menu-view');
       
        // performSearch(); 
    }
    </script>

<script>
  $(document).ready(function() {
   
    function performSearch() {
        const query = $('#searchInput').val(); 

        if (query.length === 0) {
            $('#searchResults').empty();
            return;
        }

        $.ajax({
            url: '{{ route('admin.community.search') }}', 
            type: 'GET',
            data: { query: query },
            success: function(data) {
   
    $('#searchResults').empty();

   
    if (data.users.length > 0) {
        data.users.forEach(user => {
            const userName = user.name;
            const userID = user.id;

            const url = "{{ route('admin.community.index', ['user_id' => '__userID__']) }}".replace('__userID__', userID);

          
            $('#searchResults').append(`
                <a data-id="${userName}" href="${url}">${userName}</a>
            `);
        });
    } else {
        $('#searchResults').append('<p>No results found.</p>');
    }
},

            error: function(xhr) {
                console.error(xhr.responseText);
                $('#searchResults').append('<p>Error fetching results.</p>');
            }
        });
    }

    // Attach the function to the input event
    $('#searchInput').on('input', performSearch);
});

    </script>
    



    <script>
        function loadpost(url) {
            $.get(url, function(res) {
                if (res.next) {
                    $('#load-more-btn').show().data('url', res.next)
                } else {
                    $('#load-more-btn').hide().data('url', null);
                }
                $.each(res.data, function(k, v) {
                    let polloption = ``;
                    if (v.vote) {

                        $.each(v.poll || [], function(pk, pv) {
                            polloption += `
                        <div class="form-check ${v.vote.option==pv.slug?"voted":"vote"}">
                            <input class="form-check-input" type="radio" name="${v.slug}" id="poll-${v.slug}-option-${pv.slug}" value="${pv.slug}"  >
                            <label class="form-check-label" for="poll-${v.slug}-option-${pv.slug}">
                                ${pv.option}
                                <span id="poll-${v.slug}-option-${pv.slug}-percentage">(${pv.percentage}%)</span>
                                <div class="poll-graph-bar-wrapper">
                                    <div class="poll-graph-bar" id="poll-${v.slug}-option-${pv.slug}-bar" style="width: ${pv.percentage}%;"></div>
                                </div>
                            </label>
                        </div>
                        `;
                        })
                    } else {

                        $.each(v.poll || [], function(pk, pv) {
                            polloption += `
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="${v.slug}" id="poll-${v.slug}-option-${pv.slug}" value="${pv.slug}" >
                            <label class="form-check-label" for="poll-${v.slug}-option-${pv.slug}">
                                ${pv.option}
                                <span id="poll-${v.slug}-option-${pv.slug}-percentage">(${pv.percentage}%)</span>
                                <div class="poll-graph-bar-wrapper">
                                    <div class="poll-graph-bar" id="poll-${v.slug}-option-${pv.slug}-bar" style="width: ${pv.percentage}%;"></div>
                                </div>
                            </label>
                        </div>
                        `;
                        })
                    }

                    let imagehtml = '';
                    if (v.image) {
                        imagehtml = `
                        <img src="${v.image}" alt="">
                    `;
                    }
                    let hashtag = '';
                    console.log(v.hashtags);

                    $('#post-item-list').append(`
                    <div class="post-item" id="post-item-${v.slug}">  
                        <div class="post-header">
                            <div class="avathar">
                                <img src="{{ asset('assets/images/User-blk.png') }}" alt="img">
                            </div>
                            <div class="title">
                                <h3>${v.user.name||"Admin"}</h3>
                                <span>${v.createdAt}</span>
                            </div>
                            <div class="action">
                                <a class="btn btn-outline-dark" href="${v.showUrl}">View</a>
                                <a class="btn btn-dark" href="${v.editUrl}">edit</a>
                            </div>
                        </div>
                        <div class="post-title">
                            ${v.title||""}
                        </div>
                        <div class="post-content">
                            ${v.description||""}
                        </div>
                         <div class="post-content">
                            ${v.hashtags||""}
                        </div>
                        <div class="poll-options">
                            ${polloption}
                        </div>
                        <div class="post-image">
                            ${imagehtml}
                        </div>
                        <div class="post-actions">
                            <a class="post-action-btn like-btn btn" ><img src="{{ asset('assets/images/like.svg') }}" slt="comment"> <span>${v.likes}</span></a>
                            <a class="post-action-btn comment-btn btn"  ><img src="{{ asset('assets/images/comment1.svg') }}" slt="comment"> <span>${v.comments}</span></a>
                        </div>
                    </div>
                `)
                })
            }, 'json');
        }
        $(function() {
            loadpost("{{ url()->full() }}");
            $('#load-more-btn').click(function() {
                loadpost($('#load-more-btn').data('url'))
            })
        })
    </script>




@endpush
