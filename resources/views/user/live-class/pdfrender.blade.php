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
        var pdfdata = @json($pdfmap);
        var canvas = document.getElementById('image-render');
        var pdfwidth = pdfdata.data[0].width||canvas.width; 
        var pdfheight = pdfdata.data[0].height*pdfdata.count||canvas.height; 
        canvas.width=pdfwidth;
        canvas.height=pdfheight; 
        var ctx = canvas.getContext('2d');
        const worker = new Worker('{{asset("assets/js/worker.js")}}');
        worker.onmessage =function(e){ 
            const { action, data } = e.data;
             if (action=="page") {
                console.log(typeof data.render)
                var dd=data.render.split("##**##")
                for (let index = 0; index < dd.length; index++) {
                    const ee = dd[index];
                    if(ee){
                        pdfdata.data[data.index].render=atob(ee);
                    }                                        
                }
             } 
        };
        async function loadpdfdata(){
            // const response = await fetch('{{asset("assets/images/loader.svg")}}');
            // const buffer = await response.arrayBuffer();
            // const img = await new Uint8Array(buffer)
            // for (let index = 0; index < pdfdata.data.length; index++) {
            //     pdfdata.data[index].render=img;
            // } 
            renderPdf() 
            worker.postMessage({ action: 'render', data: pdfdata })
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
                    const encoder = new TextEncoder();
                    var uint8Array = encoder.encode(element.render); 
                    for (let i = 0; i < uint8Array.length&&i<imageData.data.length; i++) {
                        imageData.data[i] = uint8Array[i];
                    }
                    // if (uint8Array.length % 4 !== 0) { 
                    //     let da=[];
                    //     for (let dx = 0; dx < (uint8Array.length % 4); dx++) { 
                    //         da.push(0);
                    //     } 
                    //     uint8Array=new Uint8Array([...da,...uint8Array])  
                    //     continue;
                    // }
                    // let imageData = new ImageData(new Uint8ClampedArray(uint8Array), element.width-1, element.height-1);
                    // ctx.putImageData(imageData,0,index*element.height)            
                }
                ctx.putImageData(imageData, 0, index*element.height);
            }  
            requestAnimationFrame(renderPdf);
        } 
    </script>
@endpush
