@extends('layouts.admin')
@section('title', 'Tips n Advice')
@section('content')
{{-- <section class="header_nav">
    <div class="header_wrapp">
        <div class="header_title">
            <div class="back-btn"  id="back-btn" style="display: none">
                <a onclick="pagetoggle()"><img src="{{asset('assets/images/leftarrowblack.svg')}}" alt=""></a>
            </div>
            <h2>Tips and Advice</h2>
        </div>
    </div>
</section> --}}
{{-- <main class="content_outer"> --}}
    <section class="header_nav">
<div class="header_wrapp">
    <div class="header_title">
        <h2>Tips</h2>
    </div>
     <!-- Display success message -->
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<!-- Display validation errors -->
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
    <div class="header_right">
        <ul class="nav_bar">
            <li class="nav_item"><a href="{{route('admin.tip.storetip',$tip->id)}}" class="nav_link btn">Add +</a></li>
            {{-- <li class="nav_item import-upload-btn" >
                <button class="btn btn-dark" data-bs-toggle="modal" data-target="#import-b2c4d645f4971e9e48e35126f84d9df3-modal" data-bs-target="#import-b2c4d645f4971e9e48e35126f84d9df3-modal">Import</button>


            </li>  --}}
            {{-- <li class="nav_item import-cancel-btn"  style="display: none"  >
                <a href="http://localhost:8000/admin/upload/question-bank-import-question/cancel">
                    <p id="import-cancel-btn-text">0 % Complete</p>
                    <span class="btn btn-danger">Cancel</span>
                </a>
            </li> --}}
        </ul> 
    </div>
</div>
</section>
<section class="content_section">
<div class="container">
    <div class="row">
        <div class="table-outer table-categoryquestiontable-outer">
            <table class="table" id="table-categoryquestiontable" style="width: 100%">
                 <thead>
                         <tr>
                            <th data-th="Sl.No">Sl.No</th>
                            {{-- <th data-th="Date">Date</th> --}}
                            <th data-th="Question">Tip</th>
                            <th data-th="Advice">Advice</th>
                            {{-- <th data-th="Visible">Visible</th> --}}
                            <th data-th="Action">Action</th>
                        </tr>
                 </thead>
                <tbody> 
                </tbody>
            </table>
        </div>
    </div>
</div>

</section> 

{{-- </main> --}}
@endsection
