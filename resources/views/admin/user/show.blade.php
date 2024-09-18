@extends('layouts.admin')
@section('title', 'User Detail')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>User Detail</h2>
        </div>
            <div class="header_right">
                @if (!$user->hasVerifiedEmail())
                <span class="badge bg-danger">Email Not Verified</span> 
                @else
                <span class="badge bg-success">Email Not Verified</span> 
                @endif
            </div>
    </div>
</section>

<section class="content_section">
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="user-info">
                        <h3>User Info</h3>
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Schooling Year:</strong> {{ $user->schooling_year }}</p>
                    </div>
                    <div class="user-info">
                        <h3>Subscription Info</h3>
                        
                        @if ((optional($user->subscription())->status??"")=="subscribed")
                             
                                <p><strong>Amount:</strong> ${{optional($user->subscription())->amount}} </p>
                                <p><strong>Start Date:</strong> {{optional($user->subscription())->created_at->toFormattedDateString()}} </p>
                                <p><strong>Status:</strong> Active</p>
                                <p>
                                    <strong>Expiration Date:</strong>
                                    @if(!empty(optional($user->subscription())->expire_at)) 
                                    {{ \Carbon\Carbon::parse(optional($user->subscription())->expire_at)->toFormattedDateString() }}
                                    @endif
                                </p>
                             
                            <br>
                        @elseif ((optional($user->subscription())->status??"")=="expired")
                         
                            <p><strong>Amount:</strong> ${{optional($user->subscription())->amount}} </p>
                            <p><strong>Start Date:</strong> {{optional($user->subscription())->created_at->toFormattedDateString()}} </p>
                            <p><strong>Status:</strong> Expired</p>
                            <p>
                                <strong>Expired Date:</strong> 
                                @if(!empty(optional($user->subscription())->expire_at)) 
                                {{ \Carbon\Carbon::parse(optional($user->subscription())->expire_at)->toFormattedDateString() }}
                                @endif
                            </p>
                         
                        <br>
                        @else
                        <p>No subscriptions found.</p>
                            
                        @endif
                    </div>

                    <x-ajax-table :coloumns='[
                        ["th"=>"Date","name"=>"created_at","data"=>"date"],
                        ["th"=>"Type","name"=>"stype","data"=>"stype"],
                        ["th" => "Amount", "name" => "amount", "data" => "amount"],
                        ["th" => "Status", "name" => "status", "data" => "status"],
                        ["th" => "Payment ID", "name" => "slug", "data" => "slug"],
                    ]' 
                    :action="false" />

                </div>
            </div>            
        </div>
    </div>
</section>
 

@endsection

@push('footer-script')
    <script>
        // Any custom JavaScript for this page
    </script>
@endpush
