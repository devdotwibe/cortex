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
                        <h4>SPACES</h4>


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
                        <button type="submit" class="search-btn" disabled>
                            <img src="{{ asset('assets/images/searc-icon.svg') }}" alt="">
                        </button>
                    </div>
                </form>
                <div id="searchResults" class="dropdown"> <!-- Container for displaying search results -->
                    <!-- Dropdown results will be appended here -->
                </div>
            </div>
            
            <!-- Add some styles for the dropdown -->
            <style>
                .dropdown {
                    position: absolute; /* Position it relative to the input */
                    z-index: 1000; /* Ensure it appears above other elements */
                    background-color: white; /* Background color for dropdown */
                    border: 1px solid #ccc; /* Border for dropdown */
                    max-height: 200px; /* Max height of dropdown */
                    overflow-y: auto; /* Enable scrolling if too many results */
                    width: 100%; /* Match input width */
                    display: none; /* Initially hidden */
                }
            
                .post {
                    padding: 10px; /* Padding for each result */
                    cursor: pointer; /* Change cursor to pointer */
                }
            
                .post:hover {
                    background-color: #f0f0f0; /* Highlight on hover */
                }
            </style>
            
            
            
        </div>
        <div class="post-action">
            <button id="load-more-btn" class="btn btn-outline-dark" style="display: none"> Load More </button>
        </div>
    </section>

@endsection


@push('footer-script')


<script>
    $(document).ready(function() {
      // Function to perform the search
      function performSearch() {
          const query = $('#searchInput').val(); // Get the input value
  
          if (query.length === 0) {
              $('#searchResults').empty().hide(); // Clear results and hide if the search box is empty
              return;
          }
  
          $.ajax({
              url: '{{ route('admin.community.search') }}', // The route to your search method
              type: 'GET',
              data: { query: query },
              success: function(data) {
                  // Clear previous results
                  $('#searchResults').empty();
                  
                  // Check if any posts were returned
                  console.log('Number of posts returned:', data.posts.length);
                  if (data.posts.length > 0) {
                      data.posts.forEach(post => {
                          // Find the user by user_id
                          const user = data.users.find(user => user.id === post.user_id);
                          const userName = user ? user.name : 'Unknown'; // Default to 'Unknown' if user not found
  
                          $('#searchResults').append(`
                              <div class="post">
                                  <p>${userName}</p>
                              </div>
                          `);
                      });
                      $('#searchResults').show(); // Show the dropdown if results are found
                  } else {
                      $('#searchResults').append('<p>No results found.</p>').show(); // Show the dropdown with no results
                  }
              },
              error: function(xhr) {
                  console.error(xhr.responseText);
                  $('#searchResults').append('<p>Error fetching results.</p>').show(); // Show error in dropdown
              }
          });
      }
  
      // Attach the function to the input event
      $('#searchInput').on('input', performSearch);
      
      // Hide dropdown on click outside
      $(document).on('click', function(e) {
          if (!$(e.target).closest('.post-search').length) {
              $('#searchResults').hide(); // Hide if clicked outside
          }
      });
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
