@extends('layouts.app')

@section('content')
    <section class="banner-wrapp banner-wrapp3">
        <div class="container">
            <div class="banner-row">
                <div class="banner-col1">

                    @if (!empty($price->pricebannertitle))
                        {!! $price->pricebannertitle !!}
                    @endif
                    @if (!empty($price->pricebuttonlink) && !empty($price->pricebuttonlabel))
                        <a href="{{ $price->pricebuttonlink }}" class="banner-btn1">{{ $price->pricebuttonlabel }}</a>
                    @endif
                </div>
                <div class="banner-col2">
                    <div class="banner-img">
                        @if (!empty($price->image))
                            <img src="{{ url('d0/' . $price->image) }}" alt="Header Image">
                        @endif
                        {{-- <img src="{{asset('assets/images/home3-banner.png')}}" alt=""> --}}
                        <span class="banner-shape"><img src="{{ asset('assets/images/bgcircleheader.png') }}"
                                alt=""></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="price-wrapp" id="subscription" >
        <div class="container">
            <div class="price-row1">
                <div class="gif"><img src="{{ asset('assets/images/loader.gif') }}" alt=""></div>
                @if (!empty($price->pricetitle))
                    {!! $price->pricetitle !!}
                @endif
                {{-- <a href="{{route('login')}}" class="join-btn">Join for free</a> --}}
                @if (!empty($price->pricetitlebuttonlink) && !empty($price->pricetitlebuttonlabel))
                    <a href="{{ $price->pricetitlebuttonlink }}" class="join-btn">{{ $price->pricetitlebuttonlabel }}</a>
                @endif
            </div>

            <div class="price-row2">
                @foreach ($subscriptionPlans as $plan)
                    <div class="price-col1">
                        <ss style="display: none">@json($plan)</ss>
                        <div class="price-icon">
                            <img @if (empty($plan->icon)) src="{{ asset('assets/images/cap.svg') }}" @else src="{{ url("d0/{$plan->icon}") }}" @endif
                                alt="">
                        </div>
                        <h2>{{ $plan->title }}</h2>
                        <div class="content">
                            {!! $plan->content !!}
                        </div>
                        @if ($plan->is_external)
                            <a href="{{ $plan->external_link }}" class="buy-btn">{{ $plan->external_label }}</a>
                        @else
                            <h6>FROM @if (($plan->basic_amount ?? 0) < $plan->combo_amount)
                                    <span>${{ $plan->basic_amount ?? 0 }}</span>
                                @else
                                    <span>${{ $plan->combo_amount ?? 0 }}</span>
                                @endif
                            </h6>
                            <div class="price-detail">
                                <h5>GROUP: <span class="amount">${{ $plan->combo_amount }}</span>/<span
                                        class="divident">Per Person</span></h5>
                                <h5>INDIVIDUAL: <span>${{ $plan->basic_amount ?? 0 }}</span></h5>
                            </div>
                            @guest('admin')
                                @auth('web')
                                    @if ((optional(auth('web')->user()->subscription())->status ?? '') !== 'subscribed')
                                        <a class="buy-btn" onclick="paymodel('{{ route('pricing.pay', $plan->slug) }}')">Pay</a>
                                    @elseif((optional(auth('web')->user()->subscription())->subscription_plan_id ?? '') == $plan->id)
                                        <a class="buy-btn">Subscribed</a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="buy-btn">Pay</a>
                                @endauth
                            @endguest
                        @endif
                    </div>
                @endforeach
                {{-- <div class="price-col1">
                    <div class="price-icon">
                        <img src="./assets/images/cap.svg" alt="">
                    </div>
                    <h2>Trainee</h2>
                    <h6>Valid for Year 5</h6>
                    <h6>Access until 2026 Selective Test</h6>
                    <p>Get exam ready with Cortex Every test comes with detailed explanations.</p>
                    <ul>
                        <li class="valid"><strong>16</strong> Informative Writing Lessons</li>
                        <li class="valid"><strong>18</strong> Persuasive Writing Lessons</li>
                        <li class="valid"><strong>16</strong> Informative Writing Lessons</li>
                        <li class="valid"><strong>18</strong> x Thinking Skills (Full Tests & Concept Checks)</li>
                        <li class="valid">365 Days Validity</li>
                        <li class="valid">Detailed answer explanations</li>
                        <li class="valid">Unlimited Test Attempts</li>
                        <li class="valid"><strong>1</strong> x Vocabulary Booklet</li>
                        <li class="invalid">2 x Writing Tests with feedback</li>
                        <li class="invalid">NEW Thinking Skills Course</li>
                        <li class="invalid">NEW Reading Course</li>
                        <li class="invalid">NEW Mathematical Reasoning Tests</li>
                        <li class="invalid">First Priority to New Resources</li>
                        <li class="invalid">Informative Writing Lessons</li>
                    </ul>

                    <h6>FROM <span>$120</span></h6>
                    <div class="price-detail">
                        <h5>GROUP: <span>$120</span></h5>
                        <h5>INDIVIDUAL: <span>$160</span></h5>
                    </div>
                    <a href="" class="buy-btn">Buy Now</a>
                </div>
                <div class="price-col1 active">
                    <span class="tag">Most popular</span>
                    <div class="price-icon">
                        <img src="./assets/images/learner.svg" alt="">
                    </div>
                    <h2>Trainee</h2>
                    <h6>Valid for Year 5</h6>
                    <h6>Access until 2026 Selective Test</h6>
                    <p>Get exam ready with Cortex Every test comes with detailed explanations.</p>
                    <ul>
                        <li class="valid"><strong>16</strong> Informative Writing Lessons</li>
                        <li class="valid"><strong>18</strong> Persuasive Writing Lessons</li>
                        <li class="valid"><strong>16</strong> Informative Writing Lessons</li>
                        <li class="valid"><strong>18</strong> x Thinking Skills (Full Tests & Concept Checks)</li>
                        <li class="valid">365 Days Validity</li>
                        <li class="valid">Detailed answer explanations</li>
                        <li class="valid">Unlimited Test Attempts</li>
                        <li class="valid"><span>NEW</span> Thinking Skills Course</li>
                        <li class="valid"><span>NEW</span> Reading Course</li>
                        <li class="valid"><span>NEW</span> Mathematical Reasoning Tests</li>
                        <li class="valid">NEW Reading Course</li>
                        <li class="valid">NEW Mathematical Reasoning Tests</li>
                        <li class="valid">First Priority to New Resources</li>
                        <li class="valid">Informative Writing Lessons</li>
                    </ul>
                    <h6>FROM <span>$120</span></h6>
                    <div class="price-detail">
                        <h5>GROUP: <span>$120</span></h5>
                        <h5>INDIVIDUAL: <span>$160</span></h5>
                    </div>
                    <a href="" class="buy-btn">Buy Now</a>
                </div>
                <div class="price-col1">
                    <div class="price-icon">
                        <img src="./assets/images/scholar.svg" alt="">
                    </div>
                    <h2>Trainee</h2>
                    <h6>Valid for Year 5</h6>
                    <h6>Access until 2026 Selective Test</h6>
                    <p>Get exam ready with Cortex Every test comes with detailed explanations.</p>
                    <ul>
                        <li class="valid"><strong>16</strong> Informative Writing Lessons</li>
                        <li class="valid"><strong>18</strong> Persuasive Writing Lessons</li>
                        <li class="valid"><strong>16</strong> Informative Writing Lessons</li>
                        <li class="valid"><strong>18</strong> x Thinking Skills (Full Tests & Concept Checks)</li>
                        <li class="valid">365 Days Validity</li>
                        <li class="valid">Detailed answer explanations</li>
                        <li class="valid">Unlimited Test Attempts</li>
                        <li class="valid"><strong>1</strong> x Vocabulary Booklet</li>
                        <li class="valid">2 x Writing Tests with feedback</li>
                        <li class="valid">NEW Thinking Skills Course</li>
                        <li class="valid">NEW Reading Course</li>
                        <li class="valid">NEW Mathematical Reasoning Tests</li>
                        <li class="valid">First Priority to New Resources</li>
                        <li class="valid">Informative Writing Lessons</li>
                    </ul>
                    <h6>FROM <span>$120</span></h6>
                    <div class="price-detail">
                        <h5>GROUP: <span>$120</span></h5>
                        <h5>INDIVIDUAL: <span>$160</span></h5>
                    </div>
                    <a href="" class="buy-btn">Buy Now</a>
                </div> --}}
            </div>
            <div class="note">
                <h3>
                    @if (!empty($price->grouptitle))
                        {!! $price->grouptitle !!}
                    @endif
                </h3>
            </div>
        </div>
    </section>


    <section class="unsure-wrapp">
        <div class="container">
            <div class="unsure-row">
                <div class="unsure-icon">
                    @if (!empty($price->feelingimage))
                        <img src="{{ url('d0/' . $price->feelingimage) }}" alt="">
                    @endif
                    {{-- <img src="./assets/images/image 45.png" alt=""> --}}
                </div>
                <div class="unsure-content">
                    @if (!empty($price->feelingtitle))
                        {!! $price->feelingtitle !!}
                    @endif
                </div>
            </div>
        </div>
    </section>


    
    <section class="learning-wrapp">
        <div class="container">
            <div class="learning-row">
                <div class="learning-col1">
                    @if (!empty($price->exceltitle))
                    {!! $price->exceltitle !!}
                @endif

                @if (!empty($price->excelbuttonlink) && !empty($price->excelbuttonlabel))
                <a href="{{ $price->excelbuttonlink }}"
                    class="learning-btn">{{ $price->excelbuttonlabel }}</a>
            @endif


                </div>
                <div class="learning-col2">
                    @if (!empty($price->excelimage))
                        <img src="{{ url('d0/' . $price->excelimage) }}" alt="Header Image">
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="contact-wrapp" id="our-courses">
        <div class="container">
            <div class="contact-row">
                @if (!empty($price->ourcoursetitle))
                    {!! $price->ourcoursetitle !!}
                @endif

                <div class="btn-success"></div>

                


                <div class="alert alert-success alert-dismissible fade"id="form-messages">

                    Thank you for your message. We will get back to you soon.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>



                <form id="contact_form" action="" method="post">
                    @csrf <!-- Include the CSRF token -->
                    <div class="text-fields">
                        <div class="text-field">
                            <input type="text" name="first_name" id="first_name" placeholder="First Name">
                            <div class="error text-danger" id="first_name_error"></div>
                        </div>
                        <div class="text-field">
                            <input type="text" name="last_name" id="last_name" placeholder="Last Name">
                            <div class="error text-danger" id="last_name_error"></div>
                        </div>
                        <div class="text-field">
                            <input type="text" name="phone_number" id="phone_number" placeholder="Phone Number"
                                onkeypress="return isNumberKey(event)">
                            <div class="error text-danger" id="phone_number_error"></div>
                        </div>

                        <div class="text-field">
                            <input type="text" name="email" id="email" placeholder="Email">
                            <div class="error text-danger" id="email_error"></div>
                        </div>
                        <div class="text-field">
                            <textarea name="message" id="message" placeholder="Your Message"></textarea>
                            <div class="error text-danger" id="message_error"></div>
                        </div>
                    </div>
                    <div class="form-btn">
                        <button type="submit" class="submit-btn">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </section>
@endsection

@push('modals')

    @auth('web')
        <div class="modal fade" id="tabs2-cortext-subscription-payment-modal" tabindex="-1" data-bs-backdrop="static"
            data-bs-keyboard="false" role="dialog" aria-labelledby="tabs2-cortext-subscription-paymentLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tabs2-cortext-subscription-paymentLablel">Subscription</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" onchange="changetab('#tabs2-tabs2a','.tabs2')"
                                    name="tabs2" id="tabs2a" autocomplete="off">
                                <label for="tabs2a" class="form-check-label">Group </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" onchange="changetab('#tabs2-tabs2b','.tabs2')"
                                    name="tabs2" id="tabs2b" autocomplete="off" checked>
                                <label for="tabs2b" class="form-check-label">Induvidual</label>
                            </div>
                        </div>
                        <div class="tabs2" id="tabs2-tabs2a" style="display: none">
                            <form action="{{ route('pricing.index') }}" id="tabs2-cortext-combo-subscription-payment-form"
                                method="POST">
                                @csrf
                                <input type="hidden" name="subscription" id="subscription-combo" value="">
                                <input type="hidden" name="plan" value="combo">
                                <input type="hidden" name="year" value="{{ date('Y') + 0 }}-{{ date('Y') + 1 }}">
                                <div class="form-group">
                                    {{-- <label for="email-2">Invite User</label> --}}
                                    <div class="input-group ">
                                        <input type="email" name="email" id="tabs2-combo-email"
                                            placeholder="Enter email address" class="form-control" />
                                        <button class="btn btn-outline-secondary" type="button"
                                            id="tabs2-mail-verify-button">Confirm Email</button>
                                        <div class="invalid-feedback" id="tabs2-error-combo-email-message"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{-- <label for="combo-coupon">Coupon Code</label> --}}
                                    <div class="input-group ">
                                        <input type="text" name="coupon" id="tabs2-combo-coupon"
                                            placeholder="Enter Coupon Code" class="form-control" />
                                        <button class="btn btn-outline-secondary" type="button"
                                            id="tabs2-combo-coupon-verify-button">Apply</button>
                                        <div class="invalid-feedback" id="tabs2-error-combo-coupon-message"></div>
                                    </div>
                                </div>
                                <div class="form-group" id="tabs2-combo-message-area">
                                </div>
                                <div class="form-group mt-2">
                                    <input type="hidden" name="verify" value="N" id="tabs2-verify-mail">
                                    <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cancel</button>
                                    <button type="button" class="btn btn-dark"
                                        id="tabs2-cortext-combo-subscription-payment-form-buttom">Pay Now $<span
                                            class="amount"
                                            id="tabs2-cortext-combo-subscription-payment-form-buttom-price"></span> </button>
                                </div>
                            </form>
                        </div>
                        <div class="tabs2" id="tabs2-tabs2b">
                            <form action="{{ route('pricing.index') }}" id="tabs2-cortext-subscription-payment-form"
                                method="POST">
                                @csrf
                                <input type="hidden" name="subscription" id="subscription-single" value="">
                                <input type="hidden" name="plan" value="single">
                                <input type="hidden" name="year" value="{{ date('Y') + 0 }}-{{ date('Y') + 1 }}">
                                <div class="form-group">
                                    {{-- <label for="coupon">Coupon Code</label> --}}
                                    <div class="input-group ">
                                        <input type="text" name="coupon" id="tabs2-coupon"
                                            placeholder="Enter Coupon Code" class="form-control" />
                                        <button class="btn btn-outline-secondary" type="button"
                                            id="tabs2-coupon-verify-button">Apply</button>
                                        <div class="invalid-feedback" id="tabs2-error-coupon-message"></div>
                                    </div>
                                </div>
                                <div class="form-group" id="tabs2-message-area">
                                </div>
                                <div class="form-group mt-2">
                                    <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cancel</button>
                                    <button type="button" class="btn btn-dark price-norm"
                                        id="tabs2-cortext-subscription-payment-form-buttom">Pay Now $<span class="amount"
                                            id="tabs2-cortext-subscription-payment-form-buttom-price"></span> </button>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    @endauth

@endpush

@push('scripts')

    <script>
        $(function() {

            $('#contact_form').on('submit', function(event) {
                event.preventDefault();

                // Clear previous error messages
                $('.error').html(''); // Clear all error fields
                $('#form-messages').removeClass('show');

                const formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('contact.submit') }}',
                    data: formData,
                    success: function(response) {
                        $('#form-messages').addClass('show');
                        $('#contact_form').trigger('reset'); // Reset the form fields
                    },
                    error: function(response) {
                        let errors = response.responseJSON.errors;


                        $('#first_name_error').text(errors.first_name);
                        $('#last_name_error').text(errors.last_name);
                        $('#phone_number_error').text(errors.phone_number);
                        $('#email_error').text(errors.email);
                        $('#message_error').text(errors.message);   
                    }
                });
            });
        });
    </script>

    <script>
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            // Allow only numbers (charCode 48-57 are 0-9)
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false; // Block non-numeric characters
            }
            return true; // Allow numbers
        }
    </script>

    @auth('web')
        <script>
            function changetab(e, o) {
                $(o).hide()
                $(e).fadeIn()
            }

            function paymodel(url) {
                $.get(url, function(res) {
                    $('#subscription-single').val(res.slug)
                    $('#subscription-combo').val(res.slug)
                    $('#tabs2-cortext-combo-subscription-payment-form').attr('action', url)
                    $('#tabs2-cortext-subscription-payment-form').attr('action', url)
                    $('#tabs2-cortext-subscription-payment-modal').modal('show');
                    $('#tabs2-cortext-subscription-payment-form-buttom-price').text(res.basic_amount)
                    $('#tabs2-cortext-combo-subscription-payment-form-buttom-price').text(res.combo_amount * 2)
                }, 'json')
            }



            $('#tabs2-cortext-subscription-payment-modal').on('hidden.bs.modal', function() {
                $('#tabs2-combo-email').val('')
                $('#tabs2-verify-mail').val('N')
                $('#tabs2-coupon').val('')
                $('#tabs2-message-area').html('')
                $('#tabs2-combo-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid')
            });
            $('#tabs2-cortext-combo-subscription-payment-form-buttom').click(function(e) {
                e.preventDefault();
                $('#tabs2-combo-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid')
                $.post($('#tabs2-cortext-combo-subscription-payment-form').attr('action'), $(
                    '#tabs2-cortext-combo-subscription-payment-form').serialize(), function(res) {
                    if ($('#tabs2-verify-mail').val() == "Y") {
                        $('#tabs2-cortext-combo-subscription-payment-form').submit()
                    } else {
                        $('#tabs2-combo-message-area').html(`
                            <div class="alert alert-danger" role="alert">
                                Please confirm your inviting friend mail by click on "Confirm Email" button.
                            </div>                        
                        `)
                    }
                }, 'json').fail(function(xhr) {
                    $.each(xhr.responseJSON.errors, function(k, v) {
                        $('#tabs2-error-combo-' + k + '-message').text(v[0])
                        $('#tabs2-combo-' + k).addClass('is-invalid')
                    });
                });
            })
            $('#tabs2-combo-email').change(function() {
                $('#tabs2-verify-mail').val('N')
            })
            $('#tabs2-coupon-verify-button').click(function(e) {
                e.preventDefault();
                $('#tabs2-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid')
                var coupen = $('#tabs2-coupon').val();
                if (coupen) {
                    $.get('{{ route('coupon-verify') }}', {
                        coupon: coupen,
                        subscription: $('#subscription-single').val()
                    }, function(res) {
                        if (res.message) {
                            $('#tabs2-message-area').html(`
                                <div class="alert alert-info" role="alert">
                                    ${res.message}
                                </div>                        
                            `)
                        }
                        if (res.pay) {
                            $('#tabs2-cortext-subscription-payment-form-buttom-price').text(res.pay)
                        }
                    }, 'json').fail(function(xhr) {
                        $.each(xhr.responseJSON.errors, function(k, v) {
                            $('#tabs2-error-' + k + '-message').text(v[0])
                            $('#tabs2-' + k).addClass('is-invalid')
                        });
                    })
                }
            })
            $('#tabs2-combo-coupon-verify-button').click(function(e) {
                e.preventDefault();
                $('#tabs2-combo-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid')
                var coupen = $('#tabs2-combo-coupon').val();
                if (coupen) {
                    $.get('{{ route('coupon-verify') }}', {
                        type: "combo",
                        coupon: coupen,
                        subscription: $('#subscription-combo').val()
                    }, function(res) {
                        if (res.message) {
                            $('#tabs2-combo-message-area').html(`
                                <div class="alert alert-info" role="alert">
                                    ${res.message}
                                </div>                        
                            `)
                        }
                        if (res.pay) {
                            $('#tabs2-cortext-combo-subscription-payment-form-buttom-price').text(res.pay)
                        }
                    }, 'json').fail(function(xhr) {
                        $.each(xhr.responseJSON.errors, function(k, v) {
                            $('#tabs2-error-combo-' + k + '-message').text(v[0])
                            $('#tabs2-combo-' + k).addClass('is-invalid')
                        });
                    })
                }
            })
            $('#tabs2-mail-verify-button').click(function(e) {
                e.preventDefault();
                $('#tabs2-combo-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid')
                $.post("{{ route('combo-email') }}", {
                    email: $('#tabs2-combo-email').val(),
                    year: $('#tabs2-combo-year').val()
                }, function(res) {
                    if (res.message) {
                        $('#tabs2-combo-message-area').html(`
                            <div class="alert alert-info" role="alert">
                                ${res.message}
                            </div>                        
                        `)
                        $('#tabs2-verify-mail').val('Y')
                    }
                }, 'json').fail(function(xhr) {
                    $.each(xhr.responseJSON.errors, function(k, v) {
                        $('#tabs2-error-combo-' + k + '-message').text(v[0])
                        $('#tabs2-combo-' + k).addClass('is-invalid')
                    });
                })
            })
            $('#tabs2-cortext-subscription-payment-form-buttom').click(function(e) {
                e.preventDefault();
                $('#tabs2-message-area').html('')
                $('.invalid-feedback').text('')
                $('.form-control').removeClass('is-invalid')
                $.post($('#tabs2-cortext-subscription-payment-form').attr("action"), $(
                    '#tabs2-cortext-subscription-payment-form').serialize(), function(res) {
                    $('#tabs2-cortext-subscription-payment-form').submit()
                }, 'json').fail(function(xhr) {
                    $.each(xhr.responseJSON.errors, function(k, v) {
                        $('#tabs2-error-' + k + '-message').text(v[0])
                        $('#tabs2-' + k).addClass('is-invalid')
                    });
                });
            })
        </script>
        
    @endauth

@endpush
