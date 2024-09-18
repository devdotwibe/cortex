
@extends('layouts.app')

@section('content')

   

    <section class="price-wrapp">
        <div class="container">
            <div class="price-row1">
               
                <h2>Terms & Conditions</h2>
               
                @if(!empty($TermsAndConditions->description))

                {!! $TermsAndConditions->description !!}
                @endif
            </div>

         
              
            
        </div>
    </section>


   
   

    @endsection

    @push('modals')
    
       

   
        
    
@endpush