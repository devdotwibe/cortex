@extends('layouts.exam')
@section('title', $exam->title)
@section('content')
<section class="exam-container">
    <div class="summery-wrap"> 
        <div class="summery-content">
            {!! get_option("exam_simulator_description") !!}
        </div>
        <div class="summery-content">
            
        </div>
    </div> 
</section> 
@endsection