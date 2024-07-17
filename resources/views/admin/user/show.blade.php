@extends('layouts.admin')
@section('title', 'User Detail')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>User Detail</h2>
        </div>
        @if (!$user->hasVerifiedEmail())
            <div class="header_right">
                <ul class="nav_bar">
                    <li class="nav_item"><a class="nav_link btn">Email Not Verified</a></li>
                </ul>
            </div>
        @endif
    </div>
</section>

<section class="content_section">
    <div class="container">
        <div class="row">
            <div class="user-info">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Schooling Year:</strong> {{ $user->schooling_year }}</p>
            </div>
            <div class="subscription">
                <h3 class="subscription-info">Subscription Info</h3>
                
                @if ($user->progress('cortext-subscription-payment','')=="paid")
                    <div class="subscription-item">
                        <p><strong>Amount:</strong> ${{optional($user->subscription())->amount}} </p>
                        <p><strong>Start Date:</strong> {{optional($user->subscription())->created_at->toFormattedDateString()}} </p>
                        {{-- <p><strong>Expiration Date:</strong> {{ \Carbon\Carbon::parse($subscription->expiration_date)->toFormattedDateString() }}</p> --}}
                    </div>
                    <br>
                @else
                <p>No subscriptions found.</p>
                    
                @endif
            </div>
        </div>
    </div>
</section>

<section class="table-section">
    <div class="container">
        <div class="row">
            <x-ajax-table url="{{route('admin.user.students',$user->slug)}}" :coloumns='[
                ["th"=>"Title","name"=>"title","data"=>"title"],
                ["th"=>"Name","name"=>"name","data"=>"name"],
                ["th"=>"SubCategory","name"=>"sub_category_id","data"=>"sub_category_id"],
                ["th"=>"Category","name"=>"category_id","data"=>"category_id"],
                ["th"=>"SubCategorySet","name"=>"sub_category_set","data"=>"sub_category_set_id"],

            ]' />
        </div>
    </div>
</section>

@endsection

@push('footer-script')
    <script>
        // Any custom JavaScript for this page
    </script>
@endpush
