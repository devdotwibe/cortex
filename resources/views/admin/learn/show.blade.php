@extends('layouts.admin')
@section('title', $category->name)
@section('content')
<section class="header_nav learn-nav">
    <div class="header_wrapp">
        <div class="header_title">
            <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                <a href="{{ route('admin.learn.index') }}">
                    <img src="{{ asset('assets/images/leftarrowblack.svg') }}" alt="">
                </a>
            </div>
            <h2>{{ $category->name }}</h2>
        </div> <!-- Closing tag added here -->
        <div class="header_content">
            <div class="form-group">
                <select id="subcat-list" class="select2 form-control" data-placeholder="Select a Sub Category" data-allow-clear="true" data-ajax--url="{{ route('admin.learn.create', $category->slug) }}"></select>
            </div>
        </div>
        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item">
                    <a href="{{ route('admin.learn.create', $category->slug) }}" class="nav_link btn">Add Lessons</a>
                </li>
            </ul>
        </div>
    </div>
</section>

<section class="content_section admin_section learn_show">
    <div class="container">
        <div class="row">
            <x-ajax-table :bulkaction="true" bulkactionlink="{{route('admin.learn.bulkaction')}}"
            
            
            :bulkotheraction='[
                ["name"=>"Enable Visible Access","value"=>"visible_status"],
                ["name"=>"Disable Visible Access","value"=>"visible_status_disable"],
               
            ]' 

            
            
            :coloumns='[
                ["th"=>"Date","name"=>"created_at","data"=>"date"],
                ["th"=>"Title","name"=>"title","data"=>"title"],
                ["th" => "Visible", "name" => "visible_status", "data" => "visibility"],
            ]' 
            tableinit="questiontableinit" beforeajax="questionbeforeajax" />
        </div>
    </div>
</section>
@endsection

@push('footer-script')
    <script>

$(function() {
    setTimeout(function() {
        $('table tr td p img').hide(); 
    }, 500); 
});

        var questiontable = null;
        function questiontableinit(table) {
            questiontable = table
             // Enable state saving to retain page and sort status
             questiontable.state.save();
        }
        // function visiblechangerefresh(url) {
        //     $.get(url, function() {
        //         if (questiontable != null) {
        //             questiontable.ajax.reload()
        //         }
        //     }, 'json')
        // }
        function visiblechangerefresh(url) {
            $.get(url, function() {
                if (questiontable != null) {
                    var currentPage = questiontable.page(); // Store current page
                    // questiontable.ajax.reload()
                     // Reload the table but retain the current page
                     questiontable.ajax.reload(function() {
                        questiontable.page(currentPage).draw(false); // Stay on the same page
                    }, false);
                }
            }, 'json');
        }
        function questionbeforeajax(data){
            data.sub_category=$('#subcat-list').val()||null;
            return data;
        }

        $(function(){
            $('.select2').select2().change(function(){
                if (questiontable != null) {
                    questiontable.ajax.reload()
                }
            })
        })
    </script>
@endpush
