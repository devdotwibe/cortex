@extends('layouts.admin')
@section('title', 'Exam Simulator Option')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Exam Simulator Option</h2>
        </div> 
    </div>
</section> 

<section class="invite-wrap mt-2">

    <div class="container">
        <section class="header_nav">
            <div class="header_wrapp">
                <div class="header_title">
                    <h2>Exam Simulator Option</h2>
                </div> 
            </div>
        </section>  
        <x-general-form :url="route('admin.exam.options')"   btnsubmit="Save" :fields='[ 
            ["name"=>"title","label"=>"Title","placeholder"=>"Title","size"=>12,"type"=>"text" ,"value"=>get_option("exam_simulator_title") ],
             ["name"=>"description","label"=>"Description","placeholder"=>"Description","size"=>12,"type"=>"editor" ,"value"=>get_option("exam_simulator_description") ],
              ["name"=>"title1","label"=>"Title","placeholder"=>"Title","size"=>12,"type"=>"text" ,"value"=>get_option("exam_simulator1_title") ],
             ["name"=>"description1","label"=>"Description","placeholder"=>"Description","size"=>12,"type"=>"editor" ,"value"=>get_option("exam_simulator1_description") ],
        ]' />
    </div>
</section>










@endsection
@push('footer-script')
    <script>
         
    </script>
@endpush