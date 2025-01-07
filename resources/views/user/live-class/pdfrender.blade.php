@extends('layouts.exam')
@section('title', ucfirst($subLessonMaterial->pdf_name))
@section('content')
     <section class="exam-container pdfsection">
        <div class="container-wrap" id="question-answer-page">
            <div class="lesson">
                <a class="lesson-exit float-start"
                    href="{{ route('live-class.privateclass.lessonshow', ['live' => $user->slug, 'lesson_material' => $lessonMaterial->slug]) }}"  title="Exit" data-title="Exit" aria-label="Exit" data-toggle="tooltip" >
                    <img src="{{ asset('assets/images/exiticon.svg') }}" alt="exiticon">
                </a>
                <div class="lesson-title">
                    <button class="btn btn-danger btn-sm float-end print-bnt" onclick="printdata()" id="print-data">Print  <img src="{{ asset('assets/images/loader.gif') }}" alt="" style="display: none" width="50"></button>
                    <h5><span>{{ ucfirst($subLessonMaterial->pdf_name) }}</h5>
                </div>
                <div class="lesson-body">
                    <div id="lesson-pdf-body" class="lesson-pdf-body"> 
                        <iframe id="print-frame" frameborder="0" width="500" height="800"></iframe>
                        <div class="canover"></div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

@endsection

@push('footer-script')
    <script>
        var imgdata = @json($imgdata);
        let printFrame = document.getElementById("print-frame");
        var scale = 500/800;
        pdfwidth=$('#lesson-pdf-body').width()
        pdfheight= pdfwidth/scale

        printFrame.width=pdfwidth;
        printFrame.height=pdfheight*imgdata.length; 
       
        function printdata() {            
            printFrame.contentWindow.print();
        }
        

        $(function(){
           
            $('#print-data').prop("disabled", true);
            let htmlsection ="";
            $.each(imgdata,function(k,v){ 
                htmlsection+=`
                <section class="pdf-page">
                    <img src="${v.url}" alt="">
                </section>
                `
            })
            const windowContent = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>{{ ucfirst($subLessonMaterial->pdf_name) }}</title>
                    <style>
                        @page {
                            size: A5;
                            margin: 0;
                        }
                        @media print {
                            body {  margin:0;     }        
                            size: A5;
                        }
                        body {  margin:0;             
                                background: #e0e0e0; }                       
                        img{ width: 100% !important; /* Fit horizontally */
                            height: auto;
                            display: block; } 
                        .pdf-page {
                            overflow: hidden;
                            width: 595px; /* A4 width in pixels */
                            height: 842px; /* A4 height in pixels */
                            margin: 10px auto; /* Centering the page */
                            background-color: #fff; /* White background to simulate paper */
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }   
                    </style>
                </head>
                <body>
                    ${htmlsection}
                </body>
                </html>
            `;
            const doc = printFrame.contentWindow || printFrame.contentDocument;
            doc.document.open();
            doc.document.write(windowContent);
            doc.document.close();
            printFrame.onload = function() { 
                $('#print-data').prop("disabled", false); 
            };
        })
    </script>
@endpush
