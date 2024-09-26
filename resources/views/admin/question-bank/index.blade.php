@extends('layouts.admin')
@section('title', 'Question Bank')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <div class="back-btn"  id="back-btn" style="display: none">
                <a onclick="pagetoggle()"><img src="{{asset('assets/images/leftarrowblack.svg')}}" alt=""></a>
            </div>
            <h2>Question Bank</h2>
        </div>
    </div>
</section>
<section class="content_section admin_section category-section" id="category-content-section">
    <div class="container">
        <div class="row">
            @foreach ($categorys as $k=> $item)
            <div class="col-md-6">

                <a  onclick="loadsubcategory('{{route('admin.question-bank.subcategory',$item->slug)}}')">
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">
                                    <img src="{{$exam->examIcon($item->id,asset("assets/images/User-red.png"))}}" id="category-content-icon-{{$item->id}}">
                                </div>
                                <div class="category-content">
                                    <h5><span id="category-content-subtitle-{{$item->id}}"> {{$exam->subtitle($item->id,"Topic ".($item->getIdx()+1))}} </span> <i id="category-content-subtitle-edit-{{$item->id}}" onclick="editsubtitle(event,this)" data-icon="{{$exam->examIcon($item->id,asset("assets/images/User-red.png"))}}" data-title="{{$item->name}}" data-subtitle="{{$exam->subtitle($item->id,"Topic ".($item->getIdx()+1))}}" data-category="{{$item->id}}"><img src="{{asset('assets/images/pen.png')}}" width="15" alt=""> </i></h5>
                                    <h3>{{$item->name}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="content_section admin_section subcategory-section" id="subcategory-content-section" style="display: none">
    <div class="container">
        <div class="row" id="subcategory-list">

        </div>
    </div>
</section>
@endsection

@push('modals')

<div class="modal fade" id="question-bank-subtitle" tabindex="-1" role="dialog" aria-labelledby="question-bank-subtitleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="question-bank-subtitleLablel"></h5>
                <button type="button" class="close"  data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.question-bank.subtitle')}}"  id="question-bank-subtitle-form" method="post">
                    @csrf
                    <input type="hidden" name="category_id" id="question-bank-category-id" value="">
                    <input type="hidden" name="exam_id" value="{{$exam->id}}">
                     <div class="form-group">
                        <div class="form-data">
                            <div class="forms-inputs mb-4">
                                <label for="question-bank-category-title">Sub Title</label>
                                <input type="text" name="title" id="question-bank-category-title" value="" class="form-control " placeholder="Sub Title" aria-placeholder="Sub Title" >
                                <div class="invalid-feedback">The field is required</div>
                            </div>
                        </div>
                        <div class="form-data">
                            <div class="forms-inputs mb-4">
                                <label for="question-bank-category-icon">Icon</label>
                                <input type="hidden" name="icon" value="" id="question-bank-category-icon-input"  >
                                <input type="file" onchange="iconchange(event)"  id="question-bank-category-icon" class="form-control " placeholder="Icon" aria-placeholder="Icon" >
                                <div class="invalid-feedback">The field is required</div>
                            </div>
                            <div id="question-bank-category-icon-preview">

                            </div>
                        </div>
                     </div>
                    <button type="button" data-bs-dismiss="modal" class="btn btn-secondary mr-1">Cancel</button>
                    <button type="submit" class="btn btn-dark ml-1">Save</button>
                </form>
            </div>

        </div>
    </div>
</div>



<div class="modal fade bd-example-modal-lg" id="sub-category-create-modal" tabindex="-1" role="dialog" aria-labelledby="sub-category-createLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="sub-category-set-createLabel">Add Set</h5>
                <button type="button" class="close" data-bs-dismiss="modal" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  class="form" id="table-subcategoryset-form-create" data-save="create" data-action="" data-createurl="" >
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-data">
                                    <div class="forms-inputs mb-4">
                                        <label for="name-table-subcategoryset-form-create">Set Name</label>
                                        <input type="search" name="name" id="name-table-subcategoryset-form-create" class="form-control "  >
                                        <div class="invalid-feedback" id="name-error-table-subcategoryset-form-create"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-data">
                                    <div class="forms-inputs mb-4">
                                        <label for="time_of_exam-table-subcategoryset-form-create">Exam Duration (HH:MM)</label>
                                        <input type="search" name="time_of_exam" id="time_of_exam-table-subcategoryset-form-create" class="form-control "  >
                                        <div class="invalid-feedback" id="time_of_exam-error-table-subcategoryset-form-create"></div>
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
                <x-ajax-table
                    beforeajax='beforeajaxcallsub'
                    tableinit='subcatsettableinit'
                    deletecallbackbefore='deletecallbackbefore'
                    deletecallbackafter='deletecallbackafter'
                    :url="route('admin.set_table.show')"
                    :coloumns="[
                        ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                        ['th' => 'Set Name', 'name' => 'name', 'data' => 'name'],
                        ['th' => 'Exam Duration (HH:MM)', 'name' => 'time_of_exam', 'data' => 'time_of_exam'],
                        ['th' => 'Visible', 'name' => 'visible_status', 'data' => 'visibility'],
                    ]" />
            </div>
        </div>
    </div>
</div>
@endpush

@push('footer-script')
<script>

        $(function(){

        var type ={{request('type')}};

        console.log(type,'dt');

        });

        var activedata={};
        var subcatsettable = null;

    function beforeajaxcallsub(data) {
        data.subcategory = activedata['subcategory']||"";
        return data;
    }
    function deletecallbackbefore(){
        $('#sub-category-create-modal').modal('hide');
    }
    function deletecallbackafter(){
        $('#sub-category-create-modal').modal('show');
    }
    function pagetoggle(){
        $('#category-content-section,#subcategory-content-section').slideToggle()
        $('#back-btn').fadeToggle()
    }

    function subcatsettableinit(table) {
        subcatsettable = table
    }
    function subcatsetvisiblechangerefresh(url) {
        $.get(url, function() {
            if (subcatsettable != null) {
                subcatsettable.ajax.reload()
            }
        }, 'json')
    }
    function loadsubcategory(url){
        $.get(url,function(res){
            $('#subcategory-list').html("")
            $.each(res,function(k,v){
                $('#subcategory-list').append(`
                <div class="col-md-6">
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">
                                    <img src="{{asset("assets/images/User-red.png")}}">
                                </div>
                                <div class="category-content">
                                    <h3>${v.name}</h3>
                                </div>
                                <div class="category-action">
                                    <button class="btn btn-dark btn-sm" onclick="subcategorysetlist('${v.subsetUrl}','${v.slug}','${v.setUrl}')" ><img src="{{asset('assets/images/plus.svg')}}"></button>
                                </div>
                            </div>
                            <div class="category" id="category-content-set-${v.slug}">
                            </div>
                        </div>
                    </div>
                </div>
                `)
                setlistrefresh(v.setUrl,v.slug);
                // $.each(v.setList,function(ik,iv){
                //     $(`#category-content-set-${v.slug}`).append(`
                //      <div class="category-title">
                //         <a href="${iv.questionsUrl}"><span>${iv.name}</span></a>
                //      </div>
                //     `)
                // })
            })
            pagetoggle()
        },'json')
    }
    function setlistrefresh(url,slug){
        $.get(url,function(res){
            var str="";
            $.each(res,function(ik,iv){
                str+=`
                    <div class="category-title">
                    <a href="${iv.questionsUrl}"><span>${iv.name}</span></a>
                    </div>
                `;
            })
            $(`#category-content-set-${slug}`).html(str)
        })
    }
    function editsubtitle(event,element){
        event.preventDefault()
        event.stopPropagation()
        $('#question-bank-subtitleLablel').text($(element).data('title'))
        $('#question-bank-category-title').val($(element).data('subtitle')).removeClass('is-invalid')
        $('#question-bank-category-id').val($(element).data('category'))
        $('#question-bank-category-icon-input').val('')
        $('#question-bank-category-icon').val('')
        $('#question-bank-category-icon-preview').html(`
            <div class="image-group">
                <img src="${$(element).data('icon')}" class="img img-thumbnail">
                <button type="button" onclick="removeicon('question-bank-category')">
                    <img src="{{ asset('assets/images/delete-icon.svg') }}" alt="">
                </button>
            </div>
        `)
        $('#question-bank-subtitle').modal('show')
    }

    function iconchange(event){
            const files=event.target.files;
            const formID="question-bank-category";
            if(files.length > 0) {
                var formData = new FormData();
                formData.append("file", files[0]);
                formData.append("foldername", "subtitle");
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
                        $(`#${formID}-icon-input`).val(response.path)
                        $(`#${formID}-icon-preview`).html(` 
                        <div class="image-group">                         
                            <img src="${response.url}" class="img img-thumbnail" alt="">
                            <button type="button" onclick="removeicon('${formID}')">
                                <img src="{{ asset('assets/images/delete-icon.svg') }}" alt="">
                            </button>
                        </div>
                        `)

                        $(`#${formID}-icon`).val('')
                    },
                    error: function(xhr, status, error) {
                        updateToast(toastId, 'Upload failed.', 'danger');
                    }
                });
            }
         }
         function removeicon(e){
            $('#question-bank-category-icon-input').val('delete')
            $('#question-bank-category-icon').val('')
            $('#question-bank-category-icon-preview').html(``)
         }



    function subcategorysetlist(url, slug,seturl) {
        activedata['subcategory'] = slug;
        activedata['subcategoryseturl'] = seturl;
        $('#table-subcategoryset-form-create').data('createurl', url);
        clearsubcategoryset();
        $('#sub-category-create-modal').modal('show');
        subcatsettable.ajax.reload()
    }

    function updatesubcategoryset(url) {
        $.get(url, function(res) {
            $('#name-error-table-subcategoryset-form-create').text("")
            $('#name-table-subcategoryset-form-create').val(res.name).removeClass("is-invalid")
            $('#time_of_exam-error-table-subcategoryset-form-create').text("")
            $('#time_of_exam-table-subcategoryset-form-create').val(res.time_of_exam).removeClass("is-invalid")
            $('#table-subcategoryset-form-create').data('save', "update")
            $('#table-subcategoryset-form-create').data('action', res.updateUrl)
            $('#table-subcategoryset-form-clear').show()
            $('#table-subcategoryset-form-submit').text(' Update ')
        }, 'json')
    }

    function clearsubcategoryset() {
        $('#name-error-table-subcategoryset-form-create').text("")
        $('#name-table-subcategoryset-form-create').val('').removeClass("is-invalid")
        $('#time_of_exam-error-table-subcategoryset-form-create').text("")
        $('#time_of_exam-table-subcategoryset-form-create').val('').removeClass("is-invalid")
        $('#table-subcategoryset-form-create').data('save', "create")
        $('#table-subcategoryset-form-create').data('action', $('#table-subcategoryset-form-create').data('createurl'))
        $('#table-subcategoryset-form-clear').hide()
        $('#table-subcategoryset-form-submit').text(' Add + ')
    }
    $(function(){
        $('#question-bank-subtitle-form').submit(function(e){
            e.preventDefault();
            var form=this;
            $('#question-bank-category-title').removeClass('is-invalid')
            $.post('{{route('admin.question-bank.subtitle')}}',$(form).serialize(),function(res){
                form.reset()
                $('#category-content-subtitle-'+res.category_id).text(res.title)
                $('#category-content-subtitle-edit-'+res.category_id).data('subtitle',res.title)
                $('#category-content-subtitle-edit-'+res.category_id).data('icon',res.icon)
                $('#category-content-icon-'+res.category_id).attr('src',res.icon)
                $('#question-bank-subtitle').modal('hide')
                showToast('Subtitle has been successfully updated', 'success');
            },'json').fail(function(){
                $('#question-bank-category-title').addClass('is-invalid')
            }).always(function(){

            })
        })

        $('#sub-category-create-modal').on('hidden.bs.modal', function (e) {
            if(activedata['subcategory']&&activedata['subcategoryseturl']){
                setlistrefresh(activedata['subcategoryseturl'],activedata['subcategory']);
            }
        })
        $('#table-subcategoryset-form-clear').click(clearsubcategoryset);
        $('#table-subcategoryset-form-create').on('submit', function(e) {
            e.preventDefault();
            $('.invalid-feedback').text("")
            $('.is-invalid').removeClass("is-invalid")
            if ($(this).data('save') == "create") {
                $.post($(this).data('action'), {
                    name: $('#name-table-subcategoryset-form-create').val(),
                    time_of_exam: $('#time_of_exam-table-subcategoryset-form-create').val(),
                }, function(res) {
                    subcatsettable.ajax.reload()
                    clearsubcategoryset()
                    showToast(res.success??'Sub Category has been successfully added', 'success');
                }).fail(function(xhr) {
                    try {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors,function(k,v){
                            $(`#${k}-error-table-subcategoryset-form-create`).text(v[0])
                            $(`#${k}-table-subcategoryset-form-create`).addClass("is-invalid")
                        })
                    } catch (error) {

                    }

                })
            } else if ($(this).data('save') == "update") {
                $.post($(this).data('action'), {
                    _method: "PUT",
                    name: $('#name-table-subcategoryset-form-create').val(),
                    time_of_exam: $('#time_of_exam-table-subcategoryset-form-create').val(),
                }, function(res) {
                    subcatsettable.ajax.reload()
                    clearsubcategoryset()
                    showToast(res.success??'Sub Category has been successfully updated', 'success');
                }).fail(function(xhr) {
                    try {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors,function(k,v){
                            $(`#${k}-error-table-subcategoryset-form-create`).text(v[0])
                            $(`#${k}-table-subcategoryset-form-create`).addClass("is-invalid")
                        })
                    } catch (error) {

                    }
                })
            } else {
                $('#name-error-table-subcategoryset-form-create').text("Invalid form")
                $('#name-table-subcategoryset-form-create').addClass("is-invalid")
            }
        })


        $('#time_of_exam-table-subcategoryset-form-create').each(function(){
            var mask = $(this).data('mask');
            var placeholder = $(this).data('placeholder')||" ";
            $(this).inputmask({
                placeholder:"HH : MM",
                regex: "^(0[0-9]|1[0-9]|2[0-4]) : [0-5][0-9]$",
                showMaskOnFocus: false
            });
        })
    })
</script>
@endpush
