@extends('layouts.admin')
@section('title', 'Hashtag')
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>Hashtags</h2>
            </div>
        </div>
    </section>
    <section class="invite-wrap mt-2 categoryclass">
        <div class="container">
            <div class="container-wrap">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <form class="form" id="table-hashtag-form-create" data-save="create"
                                data-action="{{ route('admin.category.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="name-table-hashtag-form-create">Hashtag</label>
                                                    <input type="search" name="name"
                                                        id="name-table-hashtag-form-create" class="form-control ">
                                                    <div class="invalid-feedback"
                                                        id="name-error-table-hashtag-form-create"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pt-4">
                                        <button type="submit" class="btn btn-dark" id="table-hashtag-form-submit"> Add +
                                        </button>
                                        <button type="button" class="btn btn-secondary" style="display: none"
                                            id="table-hashtag-form-clear">Cancel</button>
                                    </div>
                                </div>
                            </form>
                            <x-ajax-table title="Add Hashtag" :coloumns="[
                                ['th' => 'Hashtag', 'name' => 'name', 'data' => 'name'],
                            ]" tableinit="cattableinit" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('modals')
  

@endpush

@push('footer-script')
   
@endpush
