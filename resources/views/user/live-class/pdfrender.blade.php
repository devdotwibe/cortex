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
                        {{-- <canvas id="image-render" width="500" height="800"></canvas> --}}
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
        // var canvas = document.getElementById('image-render');
        let printFrame = document.getElementById("print-frame");
        var scale = 500/800;
        pdfwidth=$('#lesson-pdf-body').width()
        pdfheight= pdfwidth/scale

        printFrame.width=pdfwidth;
        printFrame.height=pdfheight*imgdata.length; 
        // canvas.width=pdfwidth;
        // canvas.height=pdfheight*imgdata.length; 
        // var ctx = canvas.getContext('2d');
         
        // function renderPdf() {
        //     ctx.clearRect(0,0,canvas.width,canvas.height);
        //     for (let index = 0; index < imgdata.length; index++) {
        //         const element = imgdata[index]; 
        //         // let imageData = ctx.createImageData(element.width, element.height);
        //         if(element.render){   
        //             // for (let i = 0; i < element.render.length&&i<imageData.data.length; i++) {
        //             //     imageData.data[i] = element.render[i];
        //             // }   
        //             ctx.drawImage(element.render, 0, index*pdfheight,pdfwidth,pdfheight);          
        //         }
        //         // ctx.putImageData(imageData, 0, index*element.height);
        //     }  
        //     requestAnimationFrame(renderPdf);
        // } 
        // function loadimage(k,v){
        //     const image = new Image(); 
        //     image.crossOrigin = 'anonymous';
        //     image.onload = function() {
        //         imgdata[k].render=image
        //     };
        //     image.src = v.url; 
        //     image.onerror = () => {
        //         console.error('Failed to load the image');
        //     };
        // }
        function printdata() {            
            printFrame.contentWindow.print();
        }
        /*
        function printdata() {
            // Check if an iframe already exists; if not, create it
            let printFrame = document.getElementById("print-frame");
            if (!printFrame) {
                printFrame = document.createElement("iframe");
                printFrame.id = "print-frame";
                printFrame.style.position = "absolute";
                printFrame.style.width = "0";
                printFrame.style.height = "0";
                printFrame.style.border = "none";
                document.body.appendChild(printFrame);
            }
            $('#print-data').prop("disabled", true);
            $('#print-data img').show();


            // Prepare content with the canvas image
            // const windowContent = `
            //     <!DOCTYPE html>
            //     <html>
            //     <head>
            //         <title>{{ ucfirst($subLessonMaterial->pdf_name) }}</title>
            //         <style>
            //             @page {
            //                 size: A4;
            //                 margin: 0;
            //             }
            //             @media print {
            //                 body { margin: 0; }
            //                 img{ width:100%!important; } 
            //                 .pagebreak { page-break-after: always; } 
            //             }
            //         </style>
            //     </head>
            //     <body>
            //         <img src="${canvas.toDataURL()}"  >
            //     </body>
            //     </html>
            // `;
            let htmlsection ="";
            $.each(imgdata,function(k,v){ 
                htmlsection+=`
                <section >
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
                            size: A4;
                            margin: 0;
                        }
                        @media print {
                            body { margin: 0; }
                            img{ width:100%!important; } 
                            .pagebreak { page-break-after: always; } 
                        }
                    </style>
                </head>
                <body>
                    ${htmlsection}
                </body>
                </html>
            `;

            // Write the content to the iframe and wait for it to load before printing
            const doc = printFrame.contentWindow || printFrame.contentDocument;
            doc.document.open();
            doc.document.write(windowContent);
            doc.document.close();

            // Trigger print after the iframe content has loaded
            printFrame.onload = function() {
                printFrame.contentWindow.print();
                $('#print-data').prop("disabled", false);
                $('#print-data img').hide();
            };
        }
            */

        $(function(){
            // renderPdf()
            // $.each(imgdata,function(k,v){ 
            //     loadimage(k,v)
            // })
            $('#print-data').prop("disabled", true);
            let htmlsection ="";
            $.each(imgdata,function(k,v){ 
                htmlsection+=`
                <section >
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
                            size: A4;
                            margin: 0;
                        }
                        @media print {
                            body { margin: 0; }
                            img{ width:100%!important; } 
                            .pagebreak { page-break-after: always; } 
                        }
                        body { margin: 0; }
                        img{ width:100%!important; } 
                        section {
    border: 1px solid red; /* Temporary debugging */
    margin: 0;
    padding: 0;
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
