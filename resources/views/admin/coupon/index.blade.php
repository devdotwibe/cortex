@extends('layouts.admin')
@section('title', 'Coupon')
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>Coupon</h2>
            </div>
            <div class="header_right">
                <ul class="nav_bar">
                    <li class="nav_item"><a data-bs-toggle="modal" data-bs-target="#coupen-modal" class="nav_link btn">+ Add
                            New</a></li>
                </ul>
            </div>
        </div>
    </section>
    <section class="invite-wrap mt-2">
        <div class="coupon-wrap">
            <div class="row">
                <div class="col-md-12">
                    <x-ajax-table :coloumns='[
                        ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                        ['th' => 'Offer Name', 'name' => 'name', 'data' => 'name'],
                        ['th' => 'Amount', 'name' => 'amount', 'data' => 'amount'],
                        ['th' => 'Expire', 'name' => 'expire', 'data' => 'expire'],
                    ]' tableinit="coupentableinit" />
                </div>
            </div>
        </div>
    </section>
@endsection
@push('modals')
    <div class="modal fade" id="coupen-modal" tabindex="-1" role="dialog" aria-labelledby="coupenLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="coupenLablel">Add Coupon</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="coupen-add-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Offer Name</label>
                                    <input type="text" name="name" value="" class="form-control"
                                        id="coupen-add-form-name">
                                    <div id="coupen-add-form-name-error" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="text" name="amount" value="" class="form-control"
                                        id="coupen-add-form-amount">
                                    <div id="coupen-add-form-amount-error" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="expire">Expire</label>
                                    <input type="text" name="expire" value="" class="form-control"
                                        id="coupen-add-form-expire">
                                    <div id="coupen-add-form-expire-error" class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-outline-dark m-1" data-bs-dismiss="modal"
                                    aria-label="Close">Close</button>
                                <button type="submit" class="btn btn-dark m-1"> + Add </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('footer-script')
    <script>
        let coupentable = null;
        const coupentableinit = (table) => {
            coupentable = table
        }
        $(() => {
            $('#coupen-modal').on('hidden.bs.modal', () => {
                $('#coupen-add-form').get(0).reset()
                $('.form-control').removeClass('is-invalid')
                $('.invalid-feedback').text('')
            });
            $('#coupen-add-form').submit((e) => {
                e.preventDefault()
                $('.form-control').removeClass('is-invalid')
                $('.invalid-feedback').text('')
                $.post("{{ route('admin.coupon.store') }}", $(this).serialize(), (res) => {
                    coupentable.ajax.reload()
                    $('#coupen-modal').modal('hide')
                    showToast(res.success || 'Coupon has been successfully added', 'success');
                }, 'json').fail((xhr) => {
                    try {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, (k, v) => {
                            $(`#coupen-add-form-${k}-error`).text(v[0])
                            $(`#coupen-add-form-${k}`).addClass('is-invalid')
                        })
                    } catch (error) {

                    }
                });
                return false;
            })
        });
    </script>
@endpush
