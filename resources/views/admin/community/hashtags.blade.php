@extends('layouts.admin')
@section('title', 'Hashtags')
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
                            <form class="form" id="table-category-form-create" data-save="create"
                                data-action="{{ route('admin.category.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="name-table-category-form-create">Hashtags</label>
                                                    <input type="search" name="name"
                                                        id="name-table-category-form-create" class="form-control ">
                                                    <div class="invalid-feedback"
                                                        id="name-error-table-category-form-create"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pt-4">
                                        <button type="submit" class="btn btn-dark" id="table-category-form-submit"> Add +
                                        </button>
                                        <button type="button" class="btn btn-secondary" style="display: none"
                                            id="table-category-form-clear">Cancel</button>
                                    </div>
                                </div>
                            </form>
                            {{-- <x-ajax-table title="Add Category" :coloumns="[
                                ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                                ['th' => 'Category', 'name' => 'name', 'data' => 'name'],
                                ['th' => 'Visible', 'name' => 'visible_status', 'data' => 'visibility'],
                            ]"  tableinit="cattableinit"   /> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>

        </div>

    </section>