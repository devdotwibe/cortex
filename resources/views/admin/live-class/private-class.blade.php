@extends('layouts.admin')
@section('title', $live_class->class_title_1?? "Private Class")
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            @if(!empty($live_class->class_title_1))

            <h2>{{ $live_class->class_title_1 }}</h2>
            @else
            <h2>Private Class</h2>

            @endif
        </div>
        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="{{route('admin.live-class.private_class_request')}}" class="nav_link btn">Register List</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="content_section">
    <div class="container">
        <div class="row">
           
            <div class="col-md-6 pt-4">

                <a  onclick="loadclassdetail('{{route('admin.term.class_detail')}}')">

                    <div class="card">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">
                                    <img src="{{asset("assets/images/class.svg")}}">
                                </div>
                                <div class="category-content">
                                    {{-- <h5><span >  </span> <img src="{{asset('assets/images/pen.png')}}" width="15" alt=""></h5> --}}
                                    <h3>Class Details</h3>
                                </div>
                                <div class="category-action">

                                    <button class="btn btn-dark btn-sm" onclick="AddTerm(event,'class_detail')" type="button"> <img src="{{asset('assets/images/plus.svg')}}"  alt=""></button>

                                </div>
                            </div>

                            <div class="category" id="category-content-class-detail">

                            </div>

                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 pt-4">

                <a  onclick="loadlessonmaterial('{{route('admin.term.lesson_material')}}')">

                    <div class="card">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">
                                    <img src="{{asset("assets/images/lessonmaterial.svg")}}">
                                </div>
                                <div class="category-content">
                                    {{-- <h5><span >  </span> <img src="{{asset('assets/images/pen.png')}}" width="15" alt=""></h5> --}}
                                    <h3>Lesson Material</h3>
                                </div>
                                <div class="category-action">

                                    <button class="btn btn-dark btn-sm" onclick="AddTerm(event,'lesson_material')" type="button"> <img src="{{asset('assets/images/plus.svg')}}"  alt=""></button>
                                </div>
                            </div>

                            <div class="category" id="category-content-lesson-material">

                            </div>

                        </div>
                    </div>
                </a>

            </div>

            <div class="col-md-6 pt-4">

                <a  onclick="loadhomework('{{route('admin.term.home_work')}}')">

                    <div class="card">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">
                                    <img src="{{asset("assets/images/homework.svg")}}">
                                </div>
                                <div class="category-content">
                                    {{-- <h5><span >  </span> <img src="{{asset('assets/images/pen.png')}}" width="15" alt=""></h5> --}}
                                    <h3>Home work submission</h3>
                                </div>
                                <div class="category-action">

                                    <button class="btn btn-dark btn-sm" onclick="AddTerm(event,'home_work')" type="button"> <img src="{{asset('assets/images/plus.svg')}}"  alt=""></button>
                                </div>
                            </div>

                            <div class="category" id="category-content-home-work">

                            </div>

                        </div>
                    </div>
                </a>

            </div>

            <div class="col-md-6 pt-4">

                <a  onclick="loadlessonrecord('{{route('admin.term.lesson_recording')}}')">

                    <div class="card">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">
                                    <img src="{{asset("assets/images/recording.svg")}}">
                                </div>
                                <div class="category-content">
                                    {{-- <h5><span >  </span> <img src="{{asset('assets/images/pen.png')}}" width="15" alt=""></h5> --}}
                                    <h3>Lesson Recording</h3>
                                </div>
                                <div class="category-action">

                                    <button class="btn btn-dark btn-sm" onclick="AddTerm(event,'lesson_recording')" type="button"> <img src="{{asset('assets/images/plus.svg')}}"  alt=""></button>
                                </div>
                            </div>

                            <div class="category" id="category-content-lesson-recording">

                            </div>

                        </div>
                    </div>
                </a>

            </div>

            </div>
          
        </div>
    </div>
</section>


<section class="content_section" id="subcategory-content-section" style="display: none">
    <div class="container">
        <div class="row" id="subcategory-list">

        </div>
    </div>
</section>


@endsection

@push('modals')

<div class="modal fade bd-example-modal-lg" id="private-class-modal" tabindex="-1" role="dialog" aria-labelledby="private-classLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="private-class-modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="sub-category-set-createLabel">Add Term</h5>
                <button type="button" class="close" data-bs-dismiss="modal" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form  class="form" id="term_form" data-save="create" data-action-save="" data-action="{{ route('admin.term.store') }}" data-createurl="" >
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-data">
                                    <div class="forms-inputs mb-4">
                                        <label for="term_label">Term Name</label>

                                        <input type="text" name="term_name" id="term_label" class="form-control " >

                                        <input type="hidden" name="term_type" id="term_type_form" class="form-control " >

                                        <div class="invalid-feedback" id="term-errror"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-md-4 pt-4">
                            <button type="submit" class="btn btn-dark" id="table-subcategoryset-form-submit"> Add + </button>
                            <button type="button" class="btn btn-secondary" style="display: none" id="table-subcategoryset-form-clear" >Cancel</button>
                        </div>
                    </div> 
                </form>

                <div id="class_detail" class="table-term-ajax" style="display: none">

                    <x-ajax-table
                
                        popupid="private-class-modal"
                        tableid="class_detail"
                        :url="route('admin.term.show_table')"
                        :coloumns="[
                            ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                            ['th' => 'Term Name', 'name' => 'term_name', 'data' => 'term_name'],
                        ]" />
                        
                </div>

                <div id="lesson_material" class="table-term-ajax" style="display: none">

                    <x-ajax-table
                    
                        popupid="private-class-modal"
                        tableid='lesson_material'
                        :url="route('admin.term.show_table_lesson_material')"
                        :coloumns="[
                            ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                            ['th' => 'Term Name', 'name' => 'term_name', 'data' => 'term_name'],
                        ]" />
                        
                </div>

                <div id="home_work" class="table-term-ajax" style="display: none">

                    <x-ajax-table
                    
                        popupid="private-class-modal"
                        tableid='home_work'
                        :url="route('admin.term.show_table_home_work')"
                        :coloumns="[
                            ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                            ['th' => 'Term Name', 'name' => 'term_name', 'data' => 'term_name'],
                        ]" />
                        
                </div>

                <div id="lesson_recording" class="table-term-ajax" style="display: none">

                    <x-ajax-table
                    
                        popupid="private-class-modal"
                        tableid='lesson_recording'

                        :url="route('admin.term.show_table_lesson_recording')"
                        :coloumns="[
                            ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                            ['th' => 'Term Name', 'name' => 'term_name', 'data' => 'term_name'],
                        ]" />
                        
                </div>

            </div>
        </div>
        <div class="modal-content" id="private-class-booklet-modal-content" style="display: none" >
            <div class="modal-header">
                <h5 class="modal-title" id="sub-category-set-createLabel">Add Week Booklet</h5>
                <button type="button" class="close"  onclick="weekbooklettoggle()" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form  class="form" id="booklet-form-create" data-save="create" data-action-save="{{ route('admin.home-work.storebooklet') }}" data-action="{{ route('admin.home-work.storebooklet') }}" data-createurl="{{ route('admin.home-work.storebooklet') }}" >
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-data">
                                    <div class="forms-inputs mb-4">
                                        <label for="name-booklet-form-create">Week Booklet Title</label>
                                        <input type="text" name="title" id="name-booklet-form-create" class="form-control " >
                                        <input type="hidden" name="home_work" id="week_booklet_parent" value="" >
                                        <div class="invalid-feedback" id="name-error-booklet-form-create"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-md-4 pt-4">
                            <button type="submit" class="btn btn-dark" id="booklet-form-submit"> Add + </button>
                            <button type="button" class="btn btn-secondary" style="display: none" id="booklet-form-clear" >Cancel</button>
                        </div>
                    </div> 
                </form>

                <div class="table-booklet-ajax"  >

                    <x-ajax-table 
                        deletecallbackbefore='deletecallbackbefore' 
                        deletecallbackafter='deletecallbackafter' 
                        tableinit="booklettableinit" 
                        beforeajax="booklettablebeforeajax"
                        :url="route('admin.term.show_table_week_booklet')"
                        :coloumns="[
                            ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                            ['th' => 'Title', 'name' => 'title', 'data' => 'title'],
                        ]" />
                        
                </div>
            </div>
        </div>
    </div>
</div>


@endpush

@push('footer-script')
    <script>
        let booklettable=null;
        function update_term(url) {

            $.get(url, function(res) {
                $('#term_label').val("");
                // $('#term_type_form').text("");

                $('#term_label').val(res.term_name);

                $('#term-errror').text('').removeClass("is-invalid");

                 var oldurl = $('#term_form').data('action');

                 $('#term_form').data('action-save', oldurl);

                $('#term_form').data('action', res.updateUrl);

                $('#table-subcategoryset-form-clear').show();
                $('#table-subcategoryset-form-submit').text(' Update ');

                $('#sub-category-set-createLabel').text('Update Term');

            }, 'json')
        }


        $('#table-subcategoryset-form-clear').click(function() {

            var new_url = "{{ route('admin.term.store') }}";

            $('#term_form').data('action', new_url);

            $('#table-subcategoryset-form-clear').hide();

            $('#table-subcategoryset-form-submit').text('Add +');

            $('#sub-category-set-createLabel').text('Add Term');

            $('#term_label').val("");

        });

        function AddTerm(event,term)
        {
            event.preventDefault();
            event.stopPropagation();
            $('#private-class-booklet-modal-content').hide()
            $('#private-class-modal-content').show()

            $('#term_type_form').val(term);

            $('#private-class-modal').modal('show');

            $('.table-term-ajax').hide();

            $('#'+term).show();

            $('#table-subcategoryset-form-clear').hide();

            $('#table-subcategoryset-form-submit').text('Add +');

            $('#sub-category-set-createLabel').text('Add Term');

            $('#term_label').val("");

        }

        function deletecallbackbefore(){ 
            $('#private-class-modal').modal('hide');
        }
        function deletecallbackafter(){
            $('#private-class-modal').modal('show');
        }
        function weekbooklet(event,slug)
        {
            $('#week_booklet_parent').val(slug) 
            weekbooklettoggle()
            booklettable.ajax.reload()
        }
        function weekbooklettoggle(){
            $('#private-class-booklet-modal-content,#private-class-modal-content').slideToggle()
        }
        function booklettablebeforeajax(data) {
            data.home_work = $('#week_booklet_parent').val() || "";
            return data;
        }

        function booklettableinit(table) {
            booklettable = table
        }
        function visiblechangerefresh(url) {
            $.get(url, function() {
                if (booklettable != null) {
                    booklettable.ajax.reload()
                }
            }, 'json')
        }

        function updatebooklet(url) {
            $.get(url, function(res) {
                $('#name-error-booklet-form-create').text("")
                $('#name-booklet-form-create').val(res.name).removeClass("is-invalid")
                $('#booklet-form-create').data('save', "update")
                $('#booklet-form-create').data('action', res.updateUrl)
                $('#booklet-form-clear').show()
                $('#booklet-form-submit').text(' Update ')
            }, 'json')
        }

        function clearbooklet() {
            $('#name-error-booklet-form-create').text("")
            $('#name-booklet-form-create').val('').removeClass("is-invalid")
            $('#booklet-form-create').data('save', "create")
            $('#booklet-form-create').data('action', "{{ route('admin.home-work.storebooklet') }}")
            $('#booklet-form-clear').hide()
            $('#booklet-form-submit').text(' Add + ')
        }

        $(function(){
            $('#booklet-form-clear').click(clearbooklet);
            $('#booklet-form-create').on('submit', function(e) {
                e.preventDefault();
                $('#name-error-booklet-form-create').text("")
                $('#name-booklet-form-create').removeClass("is-invalid")
                if ($(this).data('save') == "create") {
                    $.post($(this).data('action'), {
                        title: $('#name-booklet-form-create').val(),
                        home_work:$('#week_booklet_parent').val()
                    }, function(res) {
                        booklettable.ajax.reload()
                        clearbooklet()
                        showToast(res.success??'Week Booklet has been successfully added', 'success');
                    }).fail(function(xhr) {
                        try {
                            var errors = xhr.responseJSON.errors;
                            $('#name-error-booklet-form-create').text(errors.name[0])
                            $('#name-booklet-form-create').addClass("is-invalid")
                        } catch (error) {

                        }

                    })
                } else if ($(this).data('save') == "update") {
                    $.post($(this).data('action'), {
                        _method: "PUT",
                        title: $('#name-booklet-form-create').val()
                    }, function(res) {
                        booklettable.ajax.reload()
                        clearbooklet()
                        showToast(res.success??'Week Booklet has been successfully updated', 'success');
                    }).fail(function(xhr) {
                        try {
                            var errors = xhr.responseJSON.errors;
                            $('#name-error-booklet-form-create').text(errors.name[0])
                            $('#name-booklet-form-create').addClass("is-invalid")
                        } catch (error) {

                        }

                    })
                } else {
                    $('#name-error-booklet-form-create').text("Invalid form")
                    $('#name-booklet-form-create').addClass("is-invalid")
                }
            })
        })
        
        $(document).ready(function() {

            $('#term_form').on('submit', function(event) {

                event.preventDefault(); 
                
                var form = $(this);
                var url = form.data('action');
                var formData = new FormData(this);

                var term_type = $('#term_type_form').val();

                $.ajax({
                    url: url,

                    type: 'POST',

                    data: formData,

                    processData: false,
                    contentType: false,
                  
                    success: function(response) {
                      

                        var new_url = "{{ route('admin.term.store') }}";

                        $('#term_form').data('action', new_url);
                        $('#table-subcategoryset-form-clear').hide();

                        $('#table-subcategoryset-form-submit').text('Add +');

                        $('#sub-category-set-createLabel').text('Add Term');

                        form.trigger('reset');

                        $('#table-' + term_type).DataTable().ajax.reload();

                        if(term_type=='class_detail')
                        {
                            loadclassdetail('{{route('admin.term.class_detail')}}');
                        }
                        else if(term_type=='lesson_material')
                        {
                            loadlessonmaterial('{{route('admin.term.lesson_material')}}');
                        }
                        else if(term_type=='home_work')
                        {
                            loadhomework('{{route('admin.term.home_work')}}');
                        }
                        else if(term_type=='lesson_recording')
                        {
                            loadlessonrecord('{{route('admin.term.lesson_recording')}}');
                        }
                        

                    },
                    error: function(response) {
                       
                        var errors = response.responseJSON.errors;
                        if (errors.term_name) {
                            $('#term-errror').text(errors.term_name[0]).show();
                        }
                    }
                });
            });

            $('#term_label').on('focus', function() {
                $('#term-errror').hide().text('');
            });
        });
        
    </script>

    <script>

        function loadclassdetail(url){
                $.get(url,function(res){
                    $.each(res,function(k,v){

                        var str="";

                        $.each(res,function(k,v){
                            str+=`
                                <div class="category-title">
                                <a href="${v.inner_url}"><span>${v.term_name}</span></a>
                                </div>
                            `;
                        })
                        $('#category-content-class-detail').html(str);

                    })
                    // pagetoggle()
                },'json')
            }
            
            function loadlessonmaterial(url){
                $.get(url,function(res){
                    $.each(res,function(k,v){

                        var str="";

                        $.each(res,function(k,v){
                            str+=`
                                <div class="category-title">
                                <a href="${v.inner_url}"><span>${v.term_name}</span></a>
                                </div>
                            `;
                        })
                        $('#category-content-lesson-material').html(str);

                    })
                    // pagetoggle()
                },'json')
            }

            function loadhomework(url){
                $.get(url,function(res){
                    $.each(res,function(k,v){

                        var str="";

                        $.each(res,function(k,v){
                            str+=`
                                <div class="category-title">
                                <a href="${v.inner_url}"><span>${v.term_name}</span></a>
                                </div>
                            `;
                        })
                        $('#category-content-home-work').html(str);

                    })
                    // pagetoggle()
                },'json')
            }

            function loadlessonrecord(url){
                $.get(url,function(res){
                    $.each(res,function(k,v){

                        var str="";

                        $.each(res,function(k,v){
                            str+=`
                                <div class="category-title">
                                <a href="${v.inner_url}"><span>${v.term_name}</span></a>
                                </div>
                            `;
                        })
                        $('#category-content-lesson-recording').html(str);

                    })
                    // pagetoggle()
                },'json')
            }

        // function pagetoggle(){
        //     $('#category-content-section,#subcategory-content-section').slideToggle()
        //     $('#back-btn').fadeToggle()
        // }
        $(document).ready(function() {

            loadclassdetail('{{route('admin.term.class_detail')}}');

            loadlessonmaterial('{{route('admin.term.lesson_material')}}');

            loadhomework('{{route('admin.term.home_work')}}');

            loadlessonrecord('{{route('admin.term.lesson_recording')}}');

        });


    </script>

@endpush
