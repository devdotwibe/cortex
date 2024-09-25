@extends('layouts.admin')
@section('title', 'Learn')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Learn</h2>
        </div>
    </div>
</section>
<section class="content_section admin_section ">
    <div class="container">
        <div class="row">
            @foreach ($categorys as $k=>$item)
            <div class="col-md-6 pt-4">

                <a href="{{route('admin.learn.show',$item->slug)}}">
                    <div class="card">
                        <div class="card-body">
                            <div class="category">
                                <div class="category-image">
                                    <img src="{{$exam->examIcon($item->id,asset("assets/images/User-red.png"))}}" id="category-content-icon-{{$item->id}}">
                                </div>
                                <div class="category-content">
                                    <h5><span id="category-content-subtitle-{{$item->id}}"> {{$exam->subtitle($item->id,"Module ".($item->getIdx()+1))}} </span> <i id="category-content-subtitle-edit-{{$item->id}}" onclick="editsubtitle(event,this)" data-title="{{$item->name}}" data-icon="{{$exam->examIcon($item->id,asset("assets/images/User-red.png"))}}" data-subtitle="{{$exam->subtitle($item->id,"Module ".($item->getIdx()+1))}}" data-category="{{$item->id}}"><img src="{{asset('assets/images/pen.png')}}" width="15" alt=""> </i></h5>
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
@endsection

@push('modals')

<div class="modal fade" id="question-bank-subtitle" tabindex="-1" role="dialog" aria-labelledby="question-bank-subtitleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="question-bank-subtitleLablel"></h5>
                <button type="button" class="close"  data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
@endpush

@push('footer-script')
    <script>
         function editsubtitle(event,element){
            event.preventDefault()
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
         $(function(){
            $('#question-bank-subtitle-form').submit(function(e){
                e.preventDefault();
                var form=this;
                $('#question-bank-category-title').removeClass('is-invalid')
                $.post('{{route('admin.question-bank.subtitle')}}',$(form).serialize(),function(res){
                    form.reset()
                    $('#category-content-subtitle-'+res.category_id).text(res.title)
                    $('#category-content-subtitle-edit-'+res.category_id).data('subtitle',res.title)
                    $('#category-content-icon-'+res.category_id).attr('src',res.icon)
                    $('#question-bank-subtitle').modal('hide')
                    showToast('Subtitle has been successfully updated', 'success');
                },'json').fail(function(){
                    $('#question-bank-category-title').addClass('is-invalid')
                }).always(function(){

                })
            })
         })
    </script>
@endpush
