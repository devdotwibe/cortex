@extends('layouts.admin')
@section('title', 'Payment')
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>Payment Price</h2>
            </div>
        </div>
    </section>

    <section class="invite-wrap mt-2">
        <div class="payment-wrap">


            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if (session('__payment_price___', '') == 'section1') active @endif" id="section1-tab"
                        data-bs-toggle="tab" href="#section1" role="tab" aria-controls="section1"
                        @if (session('__payment_price___', '') == 'section1') aria-selected="true" @else aria-selected="false" @endif>Section
                        1</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if (session('__payment_price___', 'payment') == 'payment') active @endif" id="section-price-tab"
                        data-bs-toggle="tab" href="#section-price" role="tab" aria-controls="section-price"
                        @if (session('__payment_price___', 'payment') == 'payment') aria-selected="true" @else aria-selected="false" @endif>Section
                        2</a>
                </li>

                {{-- <li class="nav-item" role="presentation">
                    <a class="nav-link @if (session('__payment_price___', '') == 'section2') active @endif" id="section2-tab"
                        data-bs-toggle="tab" href="#section2" role="tab" aria-controls="section2"
                        @if (session('__payment_price___', '') == 'section2') aria-selected="true" @else aria-selected="false" @endif>Section
                        3</a>
                </li> --}}

                <li class="nav-item" role="presentation">
                    <a class="nav-link @if (session('__payment_price___', '') == 'section3') active @endif" id="section3-tab"
                        data-bs-toggle="tab" href="#section3" role="tab" aria-controls="section3"
                        @if (session('__payment_price___', '') == 'section3') aria-selected="true" @else aria-selected="false" @endif>Section
                        3</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link @if (session('__payment_price___', '') == 'section4') active @endif" id="section4-tab"
                        data-bs-toggle="tab" href="#section4" role="tab" aria-controls="section4"
                        @if (session('__payment_price___', '') == 'section4') aria-selected="true" @else aria-selected="false" @endif>Section
                        4</a>
                </li>

               


            </ul>



            <!-- Tabs Content -->
            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade  @if (session('__payment_price___', 'payment') == 'payment') show active @endif" id="section-price"
                    role="tabpanel" aria-labelledby="section-price-tab">


                    <div class="row">
                        <div class="col-md-12">
                            <div class="payment-workshop mb-2">
                                <div class="payment-title">
                                    <h3>Intensive Workshop Plan</h3>
                                </div>
                                <div class="amount-form">
                                    <div class="amout-item">
                                        <div class="amout-item-content">
                                            <div class="form">
                                                <form action="{{ route('admin.payment.store') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="name"
                                                        value="stripe.workshop.payment.amount">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <div class="form-data">
                                                                    <div class="forms-inputs mb-4">
                                                                        @if (!empty(old('workshop-payment-form-submit')))
                                                                            <input type="text" name="amount"
                                                                                class="form-control @error('amount') is-invalid @enderror"
                                                                                placeholder="Workshop Amount"
                                                                                value="{{ old('amount', get_option('stripe.workshop.payment.amount-price', '')) }}">
                                                                            @error('amount')
                                                                                <div class="invalid-feedback">
                                                                                    {{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        @else
                                                                            <input type="text" name="amount"
                                                                                class="form-control "
                                                                                placeholder="Workshop Amount"
                                                                                value="{{ get_option('stripe.workshop.payment.amount-price', '') }}">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <button type="submit" class="btn btn-dark workshop"
                                                                id="workshop-payment-form-submit"
                                                                name="workshop-payment-form-submit" value="Save">
                                                                Save</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="payment-title">
                                <h3>Subscription Plan</h3>
                            </div>
                            <ul class="nav nav-tabs" id="priceTab" role="tablist">
                                @foreach ($plans as $k => $item)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link @if (session('__payment_price_form___', $plans[0]->slug) == $item->slug) active @endif "
                                            id="price{{ $k }}-tab" data-bs-toggle="tab"
                                            data-bs-target="#price{{ $k }}" type="button" role="tab"
                                            aria-controls="price{{ $k }}"
                                            @if (session('__payment_price_form___', $plans[0]->slug) == $item->slug) aria-selected="true" @else aria-selected="false" @endif>Subscription
                                            {{ $k + 1 }}</button>
                                    </li>
                                @endforeach
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link bg-dark @if (session('__payment_price_form___', '') == 'payment' || count($plans) == 0) active @endif"
                                        id="add-price-tab" data-bs-toggle="tab" data-bs-target="#add-price" type="button"
                                        role="tab" aria-controls="add-price"
                                        @if (session('__payment_price_form___', '') == 'payment' || count($plans) == 0) aria-selected="true" @else aria-selected="false" @endif>
                                        <img src="{{ asset('assets/images/plus.svg') }}" alt=""><span
                                            class="text-white p-2">Add Subscription</span>
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="priceTabContent">
                                @foreach ($plans as $k => $item)
                                    <div class="tab-pane fade  @if (session('__payment_price_form___', $plans[0]->slug) == $item->slug) show active @endif "
                                        id="price{{ $k }}" role="tabpanel"
                                        aria-labelledby="price{{ $k }}-tab">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <a onclick="removeplan('{{ route('admin.payment-price.destroy', $item->slug) }}')"
                                                    class="float-end"> <img src="{{ asset('assets/images/delete.svg') }}"
                                                        alt=""></a>
                                            </div>
                                        </div>
                                        <div class="amount-form">
                                            <div class="amout-item">
                                                <div class="amout-item-content">
                                                    <div class="form">
                                                        <form
                                                            action="{{ route('admin.payment-price.update', $item->slug) }}"
                                                            name="{{ $item->name }}" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <div class="form-data">
                                                                            <div class="forms-inputs mb-4">
                                                                                <label
                                                                                    for="{{ $item->slug }}-title">Title</label>
                                                                                <input type="text"
                                                                                    name="{{ $item->slug }}[title]"
                                                                                    id="{{ $item->slug }}-title"
                                                                                    class="form-control  @error($item->slug . '.title') is-invalid @enderror"
                                                                                    value="{{ old($item->slug . '.title', $item->title) }}">
                                                                                @error($item->slug . '.title')
                                                                                    <div class="invalid-feedback">
                                                                                        {{ $message }} </div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="form-data">
                                                                            <div class="forms-inputs mb-4">
                                                                                <label class="file-upload"
                                                                                    for="{{ $item->slug }}-icon">Upload
                                                                                    Image <br>
                                                                                    <img src="{{ asset('assets/images/upfile.svg') }}"></label>
                                                                                <input type="file"
                                                                                    id="{{ $item->slug }}-icon"
                                                                                    data-form="{{ $item->slug }}"
                                                                                    class="form-control icon-file @error($item->slug . '.icon') is-invalid @enderror"
                                                                                    style="display:none">
                                                                                <input type="hidden"
                                                                                    id="{{ $item->slug }}-icon-input"
                                                                                    name="{{ $item->slug }}[icon]"
                                                                                    value="{{ old($item->slug . '.icon', $item->icon) }}">
                                                                                @error($item->slug . '.icon')
                                                                                    <div class="invalid-feedback">
                                                                                        {{ $message }} </div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group"
                                                                        id="{{ $item->slug }}-icon-preview">
                                                                        @if (!empty(old($item->slug . '.icon', $item->icon)))
                                                                            <div class="image-group">
                                                                                <img src="{{ url('/d0' . '/' . old($item->slug . '.icon', $item->icon)) }}"
                                                                                    alt="">

                                                                                <button type="button"
                                                                                    onclick="removeicon('{{ $item->slug }}')">
                                                                                    <img src="{{ asset('assets/images/delete-icon.svg') }}"
                                                                                        alt="">
                                                                                </button>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <div class="form-data">
                                                                                    <div class="forms-inputs mb-4">
                                                                                        <div class="price-role-switch">
                                                                                            <label class="form-check-label"
                                                                                                for="{{ $item->slug }}-active-toggle">Subscription</label>
                                                                                            <div
                                                                                                class="form-check form-switch">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    onchange="changeaction('.action-{{ $item->slug }}',this.checked)"
                                                                                                    name="{{ $item->slug }}[is_external]"
                                                                                                    type="checkbox"
                                                                                                    role="switch"
                                                                                                    id="{{ $item->slug }}-active-toggle"
                                                                                                    value="Y"
                                                                                                    @checked(
                                                                                                        (old('subscription_plan', '') == $item->slug && old($item->slug . '.is_external', '') == 'Y') ||
                                                                                                            (empty(old('subscription_plan', '')) && $item->is_external)) />
                                                                                            </div>
                                                                                            <label class="form-check-label"
                                                                                                for="{{ $item->slug }}-active-toggle">External
                                                                                                Link</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row action-{{ $item->slug }} action-{{ $item->slug }}-amount"
                                                                        @if (
                                                                            (old('subscription_plan', '') == $item->slug && old($item->slug . '.is_external', '') == 'Y') ||
                                                                                (empty(old('subscription_plan', '')) && $item->is_external)) style="display:none" @endif>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <div class="form-data">
                                                                                    <div class="forms-inputs mb-4">
                                                                                        <label
                                                                                            for="{{ $item->slug }}-basic_amount">Subscription
                                                                                            Basic Amount </label>
                                                                                        <input type="text"
                                                                                            id="{{ $item->slug }}-basic_amount"
                                                                                            name="{{ $item->slug }}[basic_amount]"
                                                                                            class="form-control @error($item->slug . '.basic_amount') is-invalid @enderror"
                                                                                            value="{{ old($item->slug . '.basic_amount', $item->basic_amount) }}">
                                                                                        @error($item->slug .
                                                                                            '.basic_amount')
                                                                                            <div class="invalid-feedback">
                                                                                                {{ $message }} </div>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <div class="form-data">
                                                                                    <div class="forms-inputs mb-4">
                                                                                        <label
                                                                                            for="{{ $item->slug }}-combo_amount">Subscription
                                                                                            Combo Amount</label>
                                                                                        <input type="text"
                                                                                            id="{{ $item->slug }}-combo_amount"
                                                                                            name="{{ $item->slug }}[combo_amount]"
                                                                                            class="form-control @error($item->slug . '.combo_amount') is-invalid @enderror"
                                                                                            value="{{ old($item->slug . '.combo_amount', $item->combo_amount) }}">
                                                                                        @error($item->slug .
                                                                                            '.combo_amount')
                                                                                            <div class="invalid-feedback">
                                                                                                {{ $message }} </div>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row action-{{ $item->slug }} action-{{ $item->slug }}-amount"
                                                                        @if (
                                                                            (old('subscription_plan', '') == $item->slug && old($item->slug . '.is_external', '') == 'Y') ||
                                                                                (empty(old('subscription_plan', '')) && $item->is_external)) style="display:none" @endif>
                                                                        {{-- <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <div class="form-data">
                                                                                    <div class="forms-inputs mb-4">
                                                                                        <label
                                                                                            for="{{ $item->slug }}-start_plan">Start Plan </label>
                                                                                        <input type="text"
                                                                                            id="{{ $item->slug }}-start_plan"
                                                                                            name="{{ $item->slug }}[start_plan]"
                                                                                            class="form-control datepicker start-datepicker @error($item->slug . '.start_plan') is-invalid @enderror"
                                                                                            value="{{ old($item->slug . '.start_plan', $item->start_plan) }}"  data-target="#{{ $item->slug }}-end_plan"  readonly>
                                                                                        @error($item->slug . '.start_plan')
                                                                                            <div class="invalid-feedback">
                                                                                                {{ $message }} </div>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div> --}}
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <div class="form-data">
                                                                                    <div class="forms-inputs mb-4">
                                                                                        <label
                                                                                            for="{{ $item->slug }}-end_plan">End
                                                                                            Plan</label>
                                                                                        <input type="text"
                                                                                            id="{{ $item->slug }}-end_plan"
                                                                                            name="{{ $item->slug }}[end_plan]"
                                                                                            class="form-control datepicker end-datepicker @error($item->slug . '.end_plan') is-invalid @enderror"
                                                                                            value="{{ old($item->slug . '.end_plan', $item->end_plan) }}"
                                                                                            readonly>
                                                                                        @error($item->slug . '.end_plan')
                                                                                            <div class="invalid-feedback">
                                                                                                {{ $message }} </div>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row action-{{ $item->slug }} action-{{ $item->slug }}-ext"
                                                                        @if (
                                                                            !(
                                                                                (old('subscription_plan', '') == $item->slug && old($item->slug . '.is_external', '') == 'Y') ||
                                                                                (empty(old('subscription_plan', '')) && $item->is_external)
                                                                            )) style="display:none" @endif>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <div class="form-data">
                                                                                    <div class="forms-inputs mb-4">
                                                                                        <label
                                                                                            for="{{ $item->slug }}-external_label">External
                                                                                            Label </label>
                                                                                        <input type="text"
                                                                                            name="{{ $item->slug }}[external_label]"
                                                                                            id="{{ $item->slug }}-external_label"
                                                                                            class="form-control @error($item->slug . '.external_label') is-invalid @enderror"
                                                                                            value="{{ old($item->slug . '.external_label', $item->external_label) }}">
                                                                                        @error($item->slug .
                                                                                            '.external_label')
                                                                                            <div class="invalid-feedback">
                                                                                                {{ $message }} </div>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <div class="form-data">
                                                                                    <div class="forms-inputs mb-4">
                                                                                        <label
                                                                                            for="{{ $item->slug }}-external_link">External
                                                                                            Link</label>
                                                                                        <input type="text"
                                                                                            id="{{ $item->slug }}-external_link"
                                                                                            name="{{ $item->slug }}[external_link]"
                                                                                            class="form-control @error($item->slug . '.external_link') is-invalid @enderror"
                                                                                            value="{{ old($item->slug . '.external_link', $item->external_link) }}">
                                                                                        @error($item->slug .
                                                                                            '.external_link')
                                                                                            <div class="invalid-feedback">
                                                                                                {{ $message }} </div>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <div class="form-data">
                                                                            <div class="forms-inputs mb-4">
                                                                                <label
                                                                                    for="{{ $item->slug }}-content">Content</label>
                                                                                <textarea name="{{ $item->slug }}[content]" id="{{ $item->slug }}-content" class="form-control texteditor">{{ old($item->slug . '.content', $item->content) }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <button type="submit" class="btn btn-dark subscribe"
                                                                        name="subscription_plan"
                                                                        value="{{ $item->slug }}"> Save</button>


                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                                <div class="tab-pane fade  @if (session('__payment_price_form___', '') == 'payment' || count($plans) == 0) show active @endif "
                                    id="add-price" role="tabpanel" aria-labelledby="add-price-tab">
                                    <div class="amount-form">
                                        <div class="amout-item">
                                            <div class="amout-item-content">
                                                <div class="form">
                                                    <form action="{{ route('admin.payment-price.store') }}"
                                                        method="post">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <div class="form-data">
                                                                        <div class="forms-inputs mb-4">
                                                                            <label for="payment-title">Title</label>
                                                                            <input type="text" name="payment[title]"
                                                                                id="payment-title"
                                                                                class="form-control  @error('payment.title') is-invalid @enderror"
                                                                                value="{{ old('payment.title') }}">
                                                                            @error('payment.title')
                                                                                <div class="invalid-feedback">
                                                                                    {{ $message }} </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="form-data">
                                                                        <div class="forms-inputs mb-4">
                                                                            <label for="payment-icon">Icon</label>
                                                                            <input type="file" id="payment-icon"
                                                                                data-form="payment"
                                                                                class="form-control icon-file @error('payment.icon') is-invalid @enderror">
                                                                            <input type="hidden" id="payment-icon-input"
                                                                                name="payment[icon]"
                                                                                value="{{ old('payment.icon') }}">
                                                                            @error('payment.icon')
                                                                                <div class="invalid-feedback">
                                                                                    {{ $message }} </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group" id="payment-icon-preview">
                                                                    @if (!empty(old('payment.icon')))
                                                                        <div class="image-group">
                                                                            <img src="{{ url('/d0' . '/' . old('payment.icon')) }}"
                                                                                alt="">
                                                                            <button type="button"
                                                                                onclick="removeicon('payment')">
                                                                                <img src="{{ asset('assets/images/delete-icon.svg') }}"
                                                                                    alt="">
                                                                            </button>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <div class="form-data">
                                                                                <div class="forms-inputs mb-4">
                                                                                    <div class="price-role-switch">
                                                                                        <label class="form-check-label"
                                                                                            for="payment-active-toggle">Subscription</label>
                                                                                        <div
                                                                                            class="form-check form-switch">
                                                                                            <input class="form-check-input"
                                                                                                onchange="changeaction('.action-payment',this.checked)"
                                                                                                name="payment[is_external]"
                                                                                                type="checkbox"
                                                                                                role="switch"
                                                                                                id="payment-active-toggle"
                                                                                                value="Y"
                                                                                                @checked(old('payment.is_external', '') == 'Y') />
                                                                                        </div>
                                                                                        <label class="form-check-label"
                                                                                            for="payment-active-toggle">External
                                                                                            Link</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row action-payment action-payment-amount"
                                                                    @if (old('payment.is_external', '') == 'Y') style="display:none" @endif>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <div class="form-data">
                                                                                <div class="forms-inputs mb-4">
                                                                                    <label
                                                                                        for="payment-basic_amount">Subscription
                                                                                        Basic Amount </label>
                                                                                    <input type="text"
                                                                                        id="payment-basic_amount"
                                                                                        name="payment[basic_amount]"
                                                                                        class="form-control @error('payment.basic_amount') is-invalid @enderror"
                                                                                        value="{{ old('payment.basic_amount') }}">
                                                                                    @error('payment.basic_amount')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }} </div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <div class="form-data">
                                                                                <div class="forms-inputs mb-4">
                                                                                    <label
                                                                                        for="payment-combo_amount">Subscription
                                                                                        Combo Amount</label>
                                                                                    <input type="text"
                                                                                        id="payment-combo_amount"
                                                                                        name="payment[combo_amount]"
                                                                                        class="form-control @error('payment.combo_amount') is-invalid @enderror"
                                                                                        value="{{ old('payment.combo_amount') }}">
                                                                                    @error('payment.combo_amount')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }} </div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row action-payment action-payment-amount"
                                                                    @if (old('payment.is_external', '') == 'Y') style="display:none" @endif>
                                                                    {{-- <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <div class="form-data">
                                                                                <div class="forms-inputs mb-4">
                                                                                    <label
                                                                                        for="payment-start_plan">Start Plan </label>
                                                                                    <input type="text"
                                                                                        id="payment-start_plan"
                                                                                        name="payment[start_plan]"
                                                                                        class="form-control datepicker start-datepicker @error('payment.start_plan') is-invalid @enderror"
                                                                                        value="{{ old('payment.start_plan') }}" data-target="#payment-end_plan" readonly >
                                                                                    @error('payment.start_plan')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }} </div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div> --}}
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <div class="form-data">
                                                                                <div class="forms-inputs mb-4">
                                                                                    <label for="payment-end_plan">End
                                                                                        Plan</label>
                                                                                    <input type="text"
                                                                                        id="payment-end_plan"
                                                                                        name="payment[end_plan]"
                                                                                        class="form-control datepicker end-datepicker @error('payment.end_plan') is-invalid @enderror"
                                                                                        value="{{ old('payment.end_plan') }}"
                                                                                        readonly>
                                                                                    @error('payment.end_plan')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }} </div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row action-payment action-payment-ext"
                                                                    @if (old('payment.is_external', '') !== 'Y') style="display:none" @endif>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <div class="form-data">
                                                                                <div class="forms-inputs mb-4">
                                                                                    <label
                                                                                        for="payment-external_label">External
                                                                                        Label </label>
                                                                                    <input type="text"
                                                                                        name="payment[external_label]"
                                                                                        id="payment-external_label"
                                                                                        class="form-control @error('payment.external_label') is-invalid @enderror"
                                                                                        value="{{ old('payment.external_label') }}">
                                                                                    @error('payment.external_label')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }} </div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <div class="form-data">
                                                                                <div class="forms-inputs mb-4">
                                                                                    <label
                                                                                        for="payment-external_link">External
                                                                                        Link</label>
                                                                                    <input type="text"
                                                                                        id="payment-external_link"
                                                                                        name="payment[external_link]"
                                                                                        class="form-control @error('payment.external_link') is-invalid @enderror"
                                                                                        value="{{ old('payment.external_link') }}">
                                                                                    @error('payment.external_link')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }} </div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <div class="form-data">
                                                                        <div class="forms-inputs mb-4">
                                                                            <label for="payment-content">Content</label>
                                                                            <textarea name="payment[content]" id="payment-content" class="form-control texteditor">{{ old('payment.content') }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <button type="submit" class="btn btn-dark"
                                                                    name="subscription-payment-add" value="Add"> +
                                                                    Add</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>
                </div>


                <div class="tab-pane fade @if (session('__payment_price___', 'payment') == 'section1') show active @endif" id="section1"
                    role="tabpanel" aria-labelledby="section1-tab">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.payment-price.section1') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                    <div class="first">

                                        <!-- Price Banner Title -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="pricebannertitle">Price Banner Title</label>
                                                <textarea class="form-control texteditor" name="pricebannertitle" id="pricebannertitle">
                                    {{ old('pricebannertitle', optional($price)->pricebannertitle) }}
                                    
                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                            <div class="sec">
                                        <!-- Price Button Label -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="pricebuttonlabel">Price Button Label</label>
                                                        <input type="text" name="pricebuttonlabel"
                                                            id="pricebuttonlabel"
                                                            value="{{ old('pricebuttonlabel', optional($price)->pricebuttonlabel) }}"
                                                            class="form-control" placeholder="Price Button Label">
                                                        @error('pricebuttonlabel')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Price Button Link -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="pricebuttonlink">Price Button Link</label>
                                                        <input type="text" name="pricebuttonlink" id="pricebuttonlink"
                                                            value="{{ old('pricebuttonlink', optional($price)->pricebuttonlink) }}"
                                                            class="form-control" placeholder="Price Button Link">
                                                        @error('pricebuttonlink')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <!-- Image Upload -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="image">Upload Image</label>
                                                        <input type="file" name="image" id="image"
                                                            class="form-control"
                                                            onchange="previewImage(event, 'imagePreview')">
                                                        @error('image')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <!-- Image Upload -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="image" class="file-upload">
                                                            Upload Image
                                                            <br>
                                                            <img src="{{ asset('assets/images/upfile.svg') }}"
                                                                alt="Upload Icon">
                                                        </label>
                                                        <input type="file" name="image" id="image"
                                                            class="form-control" style="display: none;"
                                                            onchange="previewImage(event, 'imagePreview')">
                                                        @error('image')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                        <!-- Image Preview -->
                                        <div class="form-group">
                                            <label for="imagePreview">Image Preview</label>
                                            <div id="imagePreviewContainer"
                                                style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                                @if (isset($price) && $price->image)
                                                    <img id="imagePreview" src="{{ url('d0/' . $price->image) }}"
                                                        alt="Image Preview" style="width: 100%; height: auto;">
                                                @else
                                                    <img id="imagePreview" src="#" alt="Image Preview"
                                                        style="display: none; width: 100%; height: auto;">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="pricetitle">Price Title</label>
                                                <textarea class="form-control texteditor" name="pricetitle" id="pricetitle">
                                    {{ old('pricetitle', optional($price)->pricetitle) }}
                                    
                                </textarea>
                                            </div>
                                        </div>


                                        <!-- Price Button Label -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="pricetitlebuttonlabel">Pricetitle Button Label</label>
                                                        <input type="text" name="pricetitlebuttonlabel"
                                                            id="pricetitlebuttonlabel"
                                                            value="{{ old('pricetitlebuttonlabel', optional($price)->pricetitlebuttonlabel) }}"
                                                            class="form-control" placeholder="Price Button Label">
                                                        @error('pricetitlebuttonlabel')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Price Button Link -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="pricetitlebuttonlink">Pricetitle Button Link</label>
                                                        <input type="text" name="pricetitlebuttonlink"
                                                            id="pricetitlebuttonlink"
                                                            value="{{ old('pricetitlebuttonlink', optional($price)->pricetitlebuttonlink) }}"
                                                            class="form-control" placeholder="Price Button Link">
                                                        @error('pricetitlebuttonlink')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>





                                        <!-- Save Button -->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-dark price"
                                                    value="save">Save</button>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade @if (session('__payment_price___', 'payment') == 'section3') show active @endif" id="section3"
                    role="tabpanel" aria-labelledby="section3-tab">

                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.payment-price.section3') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">




                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="grouptitle">Group Title</label>
                                                    <input type="text" name="grouptitle" id="grouptitle"
                                                        value="{{ old('grouptitle', optional($price)->grouptitle) }}"
                                                        class="form-control" placeholder="Group Title">
                                                    @error('grouptitle')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                    <!-- Price Banner Title -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="feelingtitle">Feeling Title</label>
                                            <textarea class="form-control texteditor" name="feelingtitle" id="feelingtitle">
                                {{ old('feelingtitle', optional($price)->feelingtitle) }}
                                
                            </textarea>
                                        </div>
                                    </div>






                                    <!-- Image Upload -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-data">
                                                <div class="forms-inputs mb-4">
                                                    <label for="feelingimage"  class="file-upload" >Feeling Image  <br>
                                                        <img src="{{ asset('assets/images/upfile.svg') }}"
                                                            alt="Upload Icon"> </label>
                                                    <input type="file" name="feelingimage" id="feelingimage"
                                                        class="form-control"  style="display: none;"
                                                        onchange="previewImage(event, 'feelingimagePreview')">
                                                    @error('feelingimage')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

               


                                    <!-- Image Preview -->
                                    <div class="form-group">
                                        <label for="feelingimagePreview">Image Preview</label>
                                        <div id="feelingimageContainer"
                                            style="border: 1px solid #ddd; padding: 10px; width: 150px; height: 150px;">
                                            @if (isset($price) && $price->image)
                                                <img id="feelingimagePreview"
                                                    src="{{ url('d0/' . $price->feelingimage) }}"
                                                    alt="Image Preview" style="width: 100%; height: auto;">
                                            @else
                                                <img id="feelingimagePreview" src="#" alt="Image Preview"
                                                    style="display: none; width: 100%; height: auto;">
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Save Button -->
                                    <div class="col-md-12 mb-3">
                                        <button type="submit" class="btn btn-primary course" name="section"
                                            value="section3">Save</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


               
            <div class="tab-pane fade @if (session('__payment_price___', 'payment') == 'section4') show active @endif" id="section4"
                         role="tabpanel" aria-labelledby="section4-tab">

                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.payment-price.section4') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">



                                        <!-- Fourth Section Fields -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="exceltitle">Excel Title</label>

                                                        <textarea class="form-control texteditor" name="exceltitle" id="exceltitle">{{ old('exceltitle', optional($price)->exceltitle) }}</textarea>
                                                        @error('exceltitle')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                        <!-- Excel Button Label -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="excelbuttonlabel">Excel Button Label</label>
                                                        <input type="text" name="excelbuttonlabel"
                                                            id="excelbuttonlabel"
                                                            value="{{ old('excelbuttonlabel', optional($price)->excelbuttonlabel) }}"
                                                            class="form-control" placeholder="Excel Button Label">
                                                        @error('excelbuttonlabel')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Excel Button Link -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="excelbuttonlink">Excel Button Link</label>
                                                        <input type="text" name="excelbuttonlink" id="excelbuttonlink"
                                                            value="{{ old('excelbuttonlink', optional($price)->excelbuttonlink) }}"
                                                            class="form-control" placeholder="Excel Button Link">
                                                        @error('excelbuttonlink')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Excel Image -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-data">
                                                    <div class="forms-inputs mb-4">
                                                        <label for="excelimage" class="file-upload">Excel Image <br>   <img src="{{ asset('assets/images/upfile.svg') }}"
                                                            alt="Upload Icon"> </label>
                                                        <input type="file" name="excelimage" id="excelimage"
                                                            class="form-control" style="display: none;"
                                                            onchange="previewImage(event, 'excelImagePreview')">
                                                        @error('excelimage')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                       
                                        <!-- Image Preview -->
                                        <div class="form-group">
                                            <label for="excelImagePreview">Image Preview</label>
                                            <div id="imagePreviewContainer"
                                                style="border: 1px solid #ddd; padding: 10px; width: 132px; height: 150px;">
                                                @if (isset($price) && $price->excelimage)
                                                    <img id="excelImagePreview"
                                                        src="{{ url('d0/' . $price->excelimage) }}"
                                                        alt="Excel Image Preview" style="width: 100%; height: auto;">
                                                @else
                                                    <img id="excelImagePreview" src="#" alt="Excel Image Preview"
                                                        style="display: none; width: 100%; height: auto;">
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="coursetitle">Our Course Title</label>
                                                <textarea class="form-control texteditor" name="coursetitle" id="coursetitle">
                                                    {{ old('coursetitle', optional($price)->ourcoursetitle) }}
                                                    
                                                </textarea>
                                            </div>
                                        </div>



                                        <!-- Save Button -->
                                        <div class="col-md-12 mb-3">
                                            <button type="submit" class="btn btn-primary excel" name="section"
                                                value="section4">Save</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

    </section>

@endsection


@push('modals')
    <div class="modal fade" id="plan-delete" tabindex="-1" role="dialog" aria-labelledby="planLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="planLablel">Delete Confirmation Required</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="" id="plan-delete-form" method="post">
                        @csrf
                        @method('DELETE')
                        <p>Are you sure you want to delete the record </p>
                        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cancel</button><button
                            type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>

            </div>
        </div>




    </div>
@endpush

@push('footer-script')
    <script>
        function previewImage(event, previewId) {
            var reader = new FileReader();
            var imagePreview = document.getElementById(previewId);

            reader.onload = function() {
                if (imagePreview) {
                    imagePreview.src = reader.result;
                    imagePreview.style.display = 'block';
                }
            };

            if (event.target.files && event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
    {{-- <script>
    function previewImage1(event, previewId) {
        var reader = new FileReader();
        var imagePreview = document.getElementById(previewId);
        
        reader.onload = function() {
            if (imagePreview) {
                imagePreview.src = reader.result;
                imagePreview.style.display = 'block';
            }
        };

        if (event.target.files && event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script> --}}

    <script>
        // $('.start-datepicker').datepicker({
        //     dateFormat:'yy-mm-dd',
        //     minDate:0,
        //     onSelect: function(selectedDate) {  
        //         const target = $(this).data('target');
        //         $(target).datepicker("option", "minDate", selectedDate);
        //         $(target).datepicker("setDate", selectedDate);
        //     }
        // });
        $('.end-datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 0
        });

        function changeaction(e, c) {
            $(e).hide();
            $(e + (c ? "-ext" : "-amount")).fadeIn()
        }

        function removeplan(url) {
            $('#plan-delete-form').attr('action', url)
            $('#plan-delete').modal('show')
        }
        async function removeicon(formID) {
            if (await showConfirm({
                    title: "Are you sure you want to delete the Image"
                })) {
                $(`#${formID}-icon-input`).val('')
                $(`#${formID}-icon-preview`).html(``)
                $(`#${formID}-icon`).val('')
            }
        }
        $(".icon-file").change(function(e) {
            const files = e.target.files;
            const formID = $(this).data("form");
            if (files.length > 0) {
                var formData = new FormData();
                formData.append("file", files[0]);
                formData.append("foldername", "subscription");
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
                            <img src="${response.url}" alt="">
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
        })
        CKEDITOR.replaceAll('texteditor')
    </script>
@endpush
