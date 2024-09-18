
@extends('layouts.app')

@section('content')

   

    <section class="price-wrapp">
        <div class="container">
            <div class="price-row1">
               
                <h2>Privacy Policy</h2>
               
                @if(!empty($privacy->description))

                {!! $privacy->description !!}
                @endif
            </div>

         
              
            
        </div>
    </section>


   
   

    @endsection

    @push('modals')
    
       

   
        
    
@endpush