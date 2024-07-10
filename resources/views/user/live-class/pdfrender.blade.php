@extends('layouts.exam')
@section('title', ucfirst($subLessonMaterial->pdf_name))
@section('content')
    <style>
        canvas {
            border: 1px solid black;
        }
    </style>
    <section class="exam-container">
        <div class="container-wrap" id="question-answer-page">
            <div class="lesson">
                <a class="lesson-exit float-start"
                    href="{{ route('live-class.privateclass.lessonshow', ['live' => $user->slug, 'lesson_material' => $lessonMaterial->slug]) }}">
                    <img src="{{ asset('assets/images/exiticon.svg') }}" alt="exiticon">
                </a>
                <div class="lesson-title">
                    <h3><span>{{ ucfirst($subLessonMaterial->pdf_name) }}</h3>
                </div>
                <div class="lesson-body">
                    <div id="lesson-pdf-body" class="lesson-pdf-body"> 
                        <canvas id="image-render" width="570" height="{{800*($pdfmap["count"]??1)}}"></canvas>
                        <div class="canover"></div>
                    </div>
                </div>
                <div class="lesson-footer" id="lesson-footer-pagination">
                </div>
            </div>
        </div>
    </section>

@endsection

@push('footer-script')
    <script>
        var imgdata = @json($imgdata);
        var canvas = document.getElementById('image-render');
        var pdfwidth = imgdata[0].width||canvas.width; 
        var pdfheight = imgdata[0].height*imgdata.length||canvas.height; 
        canvas.width=pdfwidth;
        canvas.height=pdfheight; 
        var ctx = canvas.getContext('2d');
        function renderPdf() {
            ctx.clearRect(0,0,pdfwidth,pdfheight);
            for (let index = 0; index < imgdata.length; index++) {
                const element = imgdata[index]; 
                // let imageData = ctx.createImageData(element.width, element.height);
                if(element.render){   
                    // for (let i = 0; i < element.render.length&&i<imageData.data.length; i++) {
                    //     imageData.data[i] = element.render[i];
                    // }  
                    ctx.drawImage(element.render, 0, index*element.height,element.width, element.height);          
                }
                // ctx.putImageData(imageData, 0, index*element.height);
            }  
            requestAnimationFrame(renderPdf);
        } 
        function loadimage(k,v){
            const image = new Image(); 
            image.onload = function() {
                imgdata[k].render=image
            };
            image.src = v.url;
        }
        $(function(){
            renderPdf()
            $.each(imgdata,function(k,v){ 
                loadimage(k,v)
            })
        })
    </script>
    {{-- <script> 
        var pdfdata = @json($pdfmap);
        var canvas = document.getElementById('image-render');
        var pdfwidth = pdfdata.data[0].width||canvas.width; 
        var pdfheight = pdfdata.data[0].height*pdfdata.count||canvas.height; 
        canvas.width=pdfwidth;
        canvas.height=pdfheight; 
        var defaultimg = new Uint8Array([]);
        var ctx = canvas.getContext('2d');
        
        const worker = new Worker('{{asset("assets/js/worker.js")}}');
        worker.onmessage =function(e){ 
            const { action, data } = e.data;
             if (action=="page") {
                console.log(typeof data.render)
                pdfdata.data[data.index].render=data.render;
             } 
        };
        async function loadpdfdata(){
            renderPdf() 
            // const response = await fetch('{{asset("assets/images/loader.svg")}}');
            // const buffer = await response.arrayBuffer();
            // defaultimg = await new Uint8Array(buffer)
            // // for (let index = 0; index < pdfdata.data.length; index++) {
            // //     pdfdata.data[index].render=img;
            // // } 
            // // worker.postMessage({ action: 'render', data: pdfdata })
        }
        $(function(){
            loadpdfdata()
        })

        function renderPdf() {
            ctx.clearRect(0,0,pdfwidth,pdfheight);
            for (let index = 0; index < pdfdata.data.length; index++) {
                const element = pdfdata.data[index]; 
                let imageData = ctx.createImageData(element.width, element.height);
                if(element.render){   
                    for (let i = 0; i < element.render.length&&i<imageData.data.length; i++) {
                        imageData.data[i] = element.render[i];
                    }            
                }
                ctx.putImageData(imageData, 0, index*element.height);
            }  
            requestAnimationFrame(renderPdf);
        } 
    </script> --}}
@endpush
