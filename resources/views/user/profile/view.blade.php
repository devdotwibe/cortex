@extends('layouts.user')
@section('title', 'Profile')
@section('content')
    <section class="header_nav">
        <div class="header_wrapp">
            <div class="header_title">
                <h2>Profile</h2>
            </div>
            <div class="header_right">
                <ul class="nav_bar">
                    <li class="nav_item"><a href="{{ route('profile.edit') }}" class="nav_link btn">Edit</a></li>
                </ul>
            </div>
        </div>

    </section>
    <section class="content_section">
        <div class="container">
            <div class="row mb-3">

                @if ((optional($user->subscription())->status ?? '') == 'subscribed')

                    <div class="card">
                        <div class="card-body">
                            <p><strong>Amount:</strong> ${{ optional($user->subscription())->amount }} </p>
                            <p><strong>Start Date:</strong>
                                {{ optional($user->subscription())->created_at->format('Y-m-d') }} </p>
                            <p><strong>Status:</strong> Active</p>
                            <p>
                                <strong>Expiration Date:</strong>
                                @if (empty(optional($user->subscription())->expire_at))
                                    {{ \Carbon\Carbon::parse(optional($user->subscription())->expire_at)->format('Y-m-d') }}
                                @endif
                            </p>
                        </div>
                    </div>
                @elseif ((optional($user->subscription())->status ?? '') == 'expired')
                    <div class="card">
                        <div class="card-body">
                            <p><strong>Amount:</strong> ${{ optional($user->subscription())->amount }} </p>
                            <p><strong>Start Date:</strong>
                                {{ optional($user->subscription())->created_at->format('Y-m-d') }} </p>
                            <p><strong>Status:</strong> Expired</p>
                            <p>
                                <strong>Expired Date:</strong>
                                @if (empty(optional($user->subscription())->expire_at))
                                    {{ \Carbon\Carbon::parse(optional($user->subscription())->expire_at)->format('Y-m-d') }}
                                @endif
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <x-show-fields :fields="[
                [
                    'name' => 'first_name',
                    'label' => 'First Name',
                    'size' => 6,
                    'value' => $user->first_name ?? $user->name,
                ],
                ['name' => 'last_name', 'label' => 'Last Name', 'size' => 6, 'value' => $user->last_name],
                ['name' => 'email', 'label' => 'email', 'size' => 6, 'value' => $user->email],
                ['name' => 'phone', 'label' => 'Phone No', 'size' => 6, 'value' => $user->phone],
                [
                    'name' => 'schooling_year',
                    'label' => 'Current year of schooling',
                    'size' => 6,
                    'value' => $user->schooling_year,
                ],
            ]" />

            <div class="row mt-3">
                <div class="col-md-12">
                    <h3>Transation History</h3>
                </div>
                <x-ajax-table :coloumns="[
                    ['th' => 'Date', 'name' => 'created_at', 'data' => 'date'],
                    ['th' => 'Type', 'name' => 'stype', 'data' => 'stype'],
                    ['th' => 'Amount', 'name' => 'amount', 'data' => 'amount'],
                    ['th' => 'Status', 'name' => 'status', 'data' => 'status'],
                    ['th' => 'Payment ID', 'name' => 'slug', 'data' => 'slug'],
                ]" :action="false" />

            </div>
        </div>
    </section>

@endsection
