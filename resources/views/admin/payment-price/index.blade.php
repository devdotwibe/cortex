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
                                                                        <div class="invalid-feedback">{{ $message }}
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
                                                    <button type="submit" class="btn btn-dark"
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
                        @foreach ($plans as $k=>$item)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if(old('subscription_plan')==$item->slug||($k==0&&empty(old('subscription_plan')))) active @endif " id="price{{$k}}-tab" data-bs-toggle="tab" data-bs-target="#price{{$k}}"
                                type="button" role="tab" aria-controls="price{{$k}}" @if(old('subscription_plan')==$item->slug||($k==0&&empty(old('subscription_plan'))))  aria-selected="true" @else aria-selected="false" @endif>Subscription {{$k+1}}</button>
                        </li>
                        @endforeach 
                        <li class="nav-item" role="presentation">
                            <button class="nav-link bg-dark @if (!empty(old('subscription-payment-add'))|| count($plans)==0) active @endif" id="add-price-tab" data-bs-toggle="tab" data-bs-target="#add-price"
                                type="button" role="tab" aria-controls="add-price" @if (!empty(old('subscription-payment-add'))||count($plans)==0) aria-selected="true" @else aria-selected="false" @endif>
                                <img src="{{asset('assets/images/plus.svg')}}" alt=""><span class="text-white p-2">Add Subscription</span>
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="priceTabContent">
                        @foreach ($plans as $k=>$item)
                        <div class="tab-pane fade  @if(old('subscription_plan')==$item->slug||($k==0&&empty(old('subscription_plan')))) show active @endif " id="price{{$k}}" role="tabpanel" aria-labelledby="price{{$k}}-tab">
                            <div class="amount-form">
                                <div class="amout-item">
                                    <div class="amout-item-action">
                                        <button  class="btn btn-danger" onclick="removeplan('{{route('admin.payment-price.destroy',$item->slug)}}')"> Delete <img src="{{asset('assets/images/delete.svg')}}" alt=""></button>
                                    </div>
                                    <div class="amout-item-content">
                                        <div class="form">
                                            <form action="{{ route('admin.payment-price.update',$item->slug) }}" name="{{$item->name}}" method="post">
                                                @csrf 
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">
                                                                    <label for="{{$item->slug}}-title">Title</label> 
                                                                    <input type="text" name="{{$item->slug}}[title]" id="{{$item->slug}}-title"  class="form-control  @error($item->slug.'.title') is-invalid @enderror"  value="{{old($item->slug.'.title',$item->title)}}" >
                                                                    @error($item->slug.'.title')
                                                                        <div class="invalid-feedback">{{ $message }} </div>
                                                                    @enderror 
                                                                </div>
                                                            </div>
                                                        </div>  
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4"> 
                                                                    <label for="{{$item->slug}}-icon">Subscription Basic Amount </label> 
                                                                    <input type="text" name="{{$item->slug}}[basic_amount]"  class="form-control @error($item->slug.'.basic_amount') is-invalid @enderror"  value="{{ old($item->slug.'.basic_amount',$item->basic_amount) }}">
                                                                    @error($item->slug.'.basic_amount')
                                                                        <div class="invalid-feedback">{{ $message }} </div>
                                                                    @enderror 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4"> 
                                                                    <label for="{{$item->slug}}-combo_amount">Subscription Combo Amount</label> 
                                                                    <input type="text" name="{{$item->slug}}[combo_amount]"  class="form-control @error($item->slug.'.combo_amount') is-invalid @enderror"  value="{{ old($item->slug.'.combo_amount',$item->combo_amount) }}">
                                                                    @error($item->slug.'.combo_amount')
                                                                        <div class="invalid-feedback">{{ $message }} </div>
                                                                    @enderror 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">
                                                                    <label for="{{$item->slug}}-icon">Icon</label> 
                                                                    <input type="file" id="{{$item->slug}}-icon"  class="form-control  @error($item->slug.'.icon') is-invalid @enderror" >
                                                                    <input type="hidden" id="{{$item->slug}}-icon-input" name="{{$item->slug}}[icon]" value="{{old($item->slug.'.icon',$item->icon)}}">
                                                                    @error($item->slug.'.icon')
                                                                        <div class="invalid-feedback">{{ $message }} </div>
                                                                    @enderror 
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group" id="{{$item->slug}}-icon-preview"> 
                                                            @if(!empty(old($item->slug.'.icon',$item->icon)))
                                                            <img src="{{url("/d0"."/".old($item->slug.'.icon',$item->icon))}}" alt="">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">
                                                                    <label for="{{$item->slug}}-content">Content</label>
                                                                    <textarea name="{{$item->slug}}[content]" id="{{$item->slug}}-content" class="form-control texteditor" >{{old($item->slug.'.content',$item->content)}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-dark"  name="subscription_plan" value="{{$item->slug}}" > Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> 

                        </div>
                        @endforeach  
                        <div class="tab-pane fade @if (!empty(old('subscription-payment-add'))||count($plans)==0) show active @endif " id="add-price" role="tabpanel" aria-labelledby="add-price-tab">
                            <div class="amount-form">
                                <div class="amout-item">
                                    <div class="amout-item-content">
                                        <div class="form">
                                            <form action="{{ route('admin.payment-price.store') }}" method="post">
                                                @csrf 
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">
                                                                    <label for="payment-title">Title</label> 
                                                                    <input type="text" name="payment[title]" id="payment-title"  class="form-control  @error('payment.title') is-invalid @enderror"  value="{{old('payment.title')}}" >
                                                                    @error('payment.title')
                                                                        <div class="invalid-feedback">{{ $message }} </div>
                                                                    @enderror 
                                                                </div>
                                                            </div>
                                                        </div>  
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4"> 
                                                                    <label for="payment-basic_amount">Subscription Basic Amount </label> 
                                                                    <input type="text" name="payment[basic_amount]"  class="form-control @error('payment.basic_amount') is-invalid @enderror"  value="{{ old('payment.basic_amount') }}">
                                                                    @error('payment.basic_amount')
                                                                        <div class="invalid-feedback">{{ $message }} </div>
                                                                    @enderror 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4"> 
                                                                    <label for="payment-combo_amount">Subscription Combo Amount</label> 
                                                                    <input type="text" name="payment[combo_amount]"  class="form-control @error('payment.combo_amount') is-invalid @enderror"  value="{{ old('payment.combo_amount') }}">
                                                                    @error('payment.combo_amount')
                                                                        <div class="invalid-feedback">{{ $message }} </div>
                                                                    @enderror 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">
                                                                    <label for="payment-icon">Icon</label> 
                                                                    <input type="file" id="payment-icon"  class="form-control  @error('payment.icon') is-invalid @enderror" >
                                                                    <input type="hidden" id="payment-icon-input" name="payment[icon]" value="{{old('payment.icon')}}">
                                                                    @error('payment.icon')
                                                                        <div class="invalid-feedback">{{ $message }} </div>
                                                                    @enderror 
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group" id="payment-icon-preview"> 
                                                            @if(!empty(old('payment.icon')))
                                                            <img src="{{url("/d0"."/".old('payment.icon'))}}" alt="">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="form-data">
                                                                <div class="forms-inputs mb-4">
                                                                    <label for="payment-content">Content</label>
                                                                    <textarea name="payment[content]" id="payment-content" class="form-control texteditor" >{{old('payment.content')}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-dark"  name="subscription-payment-add" value="Add" > + Add</button>
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
    </section>

@endsection


@push('modals') 

    <div class="modal fade" id="plan-delete" tabindex="-1" role="dialog"
        aria-labelledby="planLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="planLablel">Delete Confirmation Required</h5>
                    <button type="button" class="close"  data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action=""  id="plan-delete-form" method="post">
                        @csrf
                        @method("DELETE")
                        <p>Are you sure you want to delete the record </p>
                        <button type="button" data-bs-dismiss="modal"   class="btn btn-secondary">Cancel</button><button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endpush

@push('footer-script')
    <script>
        function removeplan(url){            
            $('#plan-delete-form').attr(url)
            $('#plan-delete').modal('show')
        }
        CKEDITOR.replaceAll('texteditor')
    </script>
@endpush
