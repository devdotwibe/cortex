<button class="btn btn-dark" data-bs-toggle="modal" data-target="#import-{{ $id }}-modal" data-bs-target="#import-{{ $id }}-modal">Import</button>

@push('modals')
    
<div id="import-{{ $id }}-modal" class="modal fade" role='dialog'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Import </h4>
                <button type="button" class="close" data-bs-dismiss="modal" ><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="select-file">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-data">
                                    <div class="forms-inputs mb-4"> 
                                        <label for="import-{{ $id }}-file">Select Import File</label>
                                        <input type="file"   class="form-control" accept=".xlsx, .xls, .csv" id="import-{{ $id }}-file">
                                        <div class="invalid-feedback" id="import-{{ $id }}-import_datas-error-message"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="process-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                @foreach ($fields as $item)  
                                <div class="form-data">
                                    <div class="forms-inputs mb-4"> 
                                        <label for="import-{{ $id }}-import_fields.{{$item->name}}">{{$item->label??ucfirst($item->name)}}</label>
                                        <select class="form-control import-{{ $id }}-fields" name="{{$item->name}}" id="import-{{ $id }}-import_fields.{{$item->name}}"></select>
                                        <div class="invalid-feedback" id="import-{{ $id }}-{{$item->name}}-error-message"></div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="form-data">
                                    <div class="forms-inputs mb-4"> 
                                        <div class="invalid-error text-danger" id="import-{{ $id }}-import_fields-error-message"></div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="process-progress">
                    <progress id="import-{{ $id }}-progress" max="100" value="0" style="display: none">0%</progress>
                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default"  data-bs-dismiss="modal" >Cancel</button>
                <button type="button" class="btn btn-dark" id="import-{{ $id }}-button" >import</button>
            </div>
        </div>
    </div>
</div>

@endpush

@push('footer-script')
    <script>
        let import_{{ $id }}_data = [];
        $('.import-{{ $id }}-fields').change(function(e) {
            selected_val = [];
            $('.import-{{ $id }}-fields').each(function(el) {
                if ($(this).val() != "") {
                    selected_val.push($(this).val());
                }
            })

            // options = "<option value=''>--Select--</option>";
            // $.each(field_keys, function(skey, sop) {
            //     if ($.inArray(sop, selected_val) == -1) {
            //         options += "<option value='" + sop + "'>" + sop + "</option>"
            //     }
            // })
            // $('.import-{{ $id }}-fields').each(function(el) {
            //     if ($(this).val() == "") {
            //         $(this).html(options)
            //     }
            // })
            $('.import-{{ $id }}-fields option').each(function(ky,el) {
                if ($.inArray(el.value, selected_val) == -1) {
                    $(el).removeClass('selected')
                }else{
                    $(el).addClass('selected')
                } 
            })
        })
        $('#import-{{ $id }}-file').change(function(e) {
            import_{{ $id }}_data = [];
            file = e.target.files[0];
            if (file) {
                if (typeof(FileReader) != "undefined") {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var data = e.target.result;
                        var workbook = XLSX.read(data, {
                            type: 'binary',
                            cellDates: true,
                            cellNF: false,
                            cellText: false
                        });
                        var sheet_name_list = workbook.SheetNames;
                        field_keys = [];
                        $.each(sheet_name_list, function(k, v) {
                            var exceljson = XLSX.utils.sheet_to_json(workbook.Sheets[v], {
                                raw: false,
                                dateNF: 'yyyy-mm-dd'
                            });
                            if (exceljson.length > 0) {
                                $.each(Object.keys(exceljson[0]), function(kkey, key) {
                                    field_keys.push(key.trim())
                                })
                                $.each(exceljson, function(rkey, row) {
                                    import_{{ $id }}_data.push(Object.entries(row).reduce((acc, [key, value]) => { acc[key.trim()] = value; return acc; }, {})) 
                                })
                            }
                            
                        })
                        options = "<option value=''>--Select--</option>";
                        $.each(field_keys, function(skey, sop) {
                            options += "<option value='" + sop + "'>" + sop + "</option>"
                        })
                        $('.import-{{ $id }}-fields').html(options)
                    }
                    reader.readAsArrayBuffer(file);
                } else {
                    showToast("Unable to handle this file", "warning")
                }

            } else {
                showToast("Unable to handle this file", "warning")
            }

        })

        $('#import-{{ $id }}-button').click(function(){
            let element=this;
            let isValid = true;
            console.log(import_{{ $id }}_data);
            if(import_{{ $id }}_data.length>0)
            {
                $(element).prop("disabled",true)
                $('#import-{{ $id }}-progress').show()
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-error').text('')

                var formData = new FormData();
                $('.import-{{ $id }}-fields').each(function(){

                    let fieldName = $(this).attr('name');
                    let fieldValue = $(this).val();

                    if (fieldName === 'description' && fieldValue === '') {
                        $('#import-{{ $id }}-' + fieldName + '-error-message').text('Left Question is required');
                        $(this).addClass('is-invalid');
                        isValid = false;
                    }

                    if (fieldName === 'answer_1' && fieldValue === '') {
                        $('#import-{{ $id }}-' + fieldName + '-error-message').text('Option A is required');
                        $(this).addClass('is-invalid');
                        isValid = false;
                    }

                    if (fieldName === 'answer_2' && fieldValue === '') {
                        $('#import-{{ $id }}-' + fieldName + '-error-message').text('Option B is required');
                        $(this).addClass('is-invalid');
                        isValid = false;
                    }

                    if (fieldName === 'iscorrect' && fieldValue === '') {
                        $('#import-{{ $id }}-' + fieldName + '-error-message').text('Correct Answer is required');
                        $(this).addClass('is-invalid');
                        isValid = false;
                    }

                    if (fieldValue !== '') {
                        $('#import-{{ $id }}-' + fieldName + '-error-message').text('');
                        $(this).removeClass('is-invalid');
                    }
                })


                if (isValid) {
                    $(element).prop("disabled", true);
                    $('#import-{{ $id }}-progress').show();

                    var formData = new FormData();
                    $('.import-{{ $id }}-fields').each(function() {
                        if ($(this).val() !== "") {
                            formData.append("import_fields[" + $(this).attr('name') + "]", $(this).val());
                        }
                    });

                    // Append file data
                    var file = new File([JSON.stringify(import_{{ $id }}_data)], "data.json", { type: "application/json" });
                    formData.append("import_datas", file);

                    $.ajax({
                        type:"POST",
                        url:'{{$url}}',
                        async: true,
                        data:formData,
                        contentType: false,
                        processData: false,
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = Math.floor((evt.loaded / evt.total) * 100);
                                    $('#import-{{ $id }}-progress').val(percentComplete);
                                    $('#import-{{ $id }}-progress').text(percentComplete+"%")
                                }
                            }, false);
                            return xhr;
                        },
                        success:function(res){
                            showToast(res.success,"success")
                            import_{{ $id }}_data=[];
                            $('.import-{{ $id }}-fields').html("")
                            $('#import-{{ $id }}-file').val("")
                            $(element).prop("disabled",false)
                            $('#import-{{ $id }}-progress').val(0).text("0%");
                            $('#import-{{ $id }}-progress').hide()
                            $('#import-{{ $id }}-modal').modal('hide')
                            @if(!empty($onupdate))
                            {{$onupdate}}(res)
                            @endif
                        },
                        error:function(xhr){
                            showToast("Unable to handle", "warning")
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('#import-{{ $id }}-'+key+'-error-message').text(value[0]);
                                $('#import-{{ $id }}-'+key).addClass('is-invalid')
                            });
                            $(element).prop("disabled",false)
                            $('#import-{{ $id }}-progress').val(0).text("0%");
                            $('#import-{{ $id }}-progress').hide()
                            $('#import-{{ $id }}-modal').modal('hide')

                        },
                    })
                } else {
                    // Re-enable button if form is invalid
                    $(element).prop("disabled", false);
                }
            }
        })
    </script>
@endpush
