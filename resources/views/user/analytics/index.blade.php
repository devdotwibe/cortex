@extends('layouts.user')
@section('title', 'Analytics')
@section('content')

<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Analytics</h2>
        </div> 
        <div class="header_content">
            <div class="form-group">
                <select class="form-control" id="">

                </select>
            </div>
        </div>
    </div>
</section>


<section class="content_section">
    <div class="container"> 
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="analytic-list">
                        <div class="analytic-item active" id="topic-test-result">

                        </div>
                        <div class="analytic-item" id="topic-test-result">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 

@endsection

@push('footer-script')  
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(function(){

        })
    </script>
@endpush