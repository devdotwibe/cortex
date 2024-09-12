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
            <p>{{$user->progress('cortext-subscription-payment','-')}}</p>
            @if ($user->progress('cortext-subscription-payment','')=="paid")
            <div class="card">
                <div class="card-body">
                    <p> <span>Subscription Amount</span> : {{optional($user->subscription())->amount}} </p>
                    <p> <span>Paid At</span> : {{optional($user->subscription())->created_at->format("Y-m-d")}} </p>
                    <p> <span>Expire</span>  : </p>
                </div>
            </div>
            @else
                @if(!auth('web')->user()->is_free_access)
                <div class="card ">
                    <div class="card-body">
                        <form action="{{route('payment.subscription')}}"  id="cortext-subscription-payment-form" >
                            <p>The {{config('app.name')}} Subscription Peyment required </p> 
                            <button type="submit" class="btn btn-dark">Pay Now ${{ get_option('stripe.subscription.payment.amount-price','0') }} </button>
                        </form>
                    </div>
                </div>
                @endif
            @endif
        </div>

            <x-show-fields :fields='[
                ["name"=>"first_name", "label"=>"First Name" ,"size"=>6,"value"=>$user->first_name?? $user->name],
                ["name"=>"last_name","label"=>"Last Name" ,"size"=>6,"value"=>$user->last_name], 
                ["name"=>"email","label"=>"email", "size"=>6,"value"=>$user->email],
                ["name"=>"phone", "label"=>"Phone No", "size"=>6,"value"=>$user->phone], 
                ["name"=>"schooling_year", "label"=>"Current year of schooling", "size"=>6,"value"=>$user->schooling_year],  
               
            ]' /> 
         
        <div class="row mt-3">
            <div class="col-md-12">
                <h3>Transation History</h3>
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
</section>

@endsection