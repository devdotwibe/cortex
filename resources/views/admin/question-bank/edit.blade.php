@extends('layouts.admin')
@section('title', $category->name.' - '.$subcategory->name.' - '.$setname->name.' - '.' Questions')
@section('content')
<section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <div class="back-btn" id="back-btn" style="display: block"> <!-- Ensure proper display value -->
                <a href="{{ route('admin.question-bank.show',$setname->slug') }}">
                    <img src="{{ asset('assets/images/leftarrowblack.svg') }}" alt="">
                </a>
            </div>


            {{-- <h2>{{$category->name}} - {{$subcategory->name}} - {{ $setname->name }} - Questions</h2> --}}


            <h2>
                <a href="">{{$category->name}}</a> -> 
                <a href="">{{$subcategory->name}}</a> -> 
                {{ $setname->name }} -> Questions
            </h2>

            

            
        </div> 
    </div>
</section>
<section class="invite-wrap mt-2">
    <div class="container"> 
        @php
            $choices=[];
            foreach ($question->answers as $ans) {
                $choices[]=[
                    "id"=>$ans->id,
                    "value"=>$ans->title,
                    "image"=>$ans->image ? asset('d0').'/'.$ans->image : Null,
                    "choice"=>$ans->iscorrect,
            ];
            }
        @endphp
        <x-edit-form name="admin.question" :id="$question->slug" btnsubmit="Save"  :cancel="route('admin.question-bank.show',$setname->slug)" :fields='[
            ["name"=>"exam_type", "value"=>"question-bank","type"=>"hidden"],
            ["name"=>"category_id", "value"=>$category->id,"type"=>"hidden"],
            ["name"=>"sub_category_id", "value"=>$subcategory->id,"type"=>"hidden"],
            ["name"=>"sub_category_set", "value"=>$setname->id,"type"=>"hidden"],
            ["name"=>"redirect", "value"=>route("admin.question-bank.show",$setname->slug),"type"=>"hidden"],
             
            ["name"=>"title_text","label"=>"Title Text","size"=>12,"type"=>"editor","value"=>$question->title_text],
            ["name"=>"description","label"=>"Left Question","size"=>12,"type"=>"editor","value"=>$question->description], 
            ["name"=>"sub_question","label"=>"Right Question","size"=>12,"type"=>"editor","value"=>$question->sub_question],             
            ["name"=>"answer","label"=>"answer" ,"type"=>"choice" ,"size"=>6,"value"=>$choices ],
            ["name"=>"explanation","label"=>"Explanation","size"=>12,"type"=>"editor" ,"value"=>$question->explanation],
        ]' /> 
    </div>
</section> 
@endsection

@push('footer-script')
    <script>
         
    </script>
@endpush