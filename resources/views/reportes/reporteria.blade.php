
@extends('../layouts/' . $layout)

@section('subhead')
    <title>Reporteria</title>
@endsection

@section('subcontent')
    
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<style>
    

    
.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 50px;
    margin: 4px 2px;
    cursor: pointer;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
}

.button {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
}


.step::before {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    background-color: inherit;
    z-index: -1;
    animation: ripple 1.5s ease-out infinite;
}
      

.step:last-child {
  transform: scale(0.6);
}

.step:last-child::before {
  animation-delay: 1s;
}

@keyframes ripple {
  from {
    opacity: 1;
    transform: scale(0);
  }
  to {
    opacity: 0;
    transform: scale(3);
  }
}


#the-canvas {
    border: 1px solid black;
    direction: ltr;
}
        

</style>


<!-- Si es tablet has lo que necesites-->
<div id="div_credencial_movil_descargar" style="display: none;">
    <a download href="{{ asset($reportName) }}" class="btn button step"><i class="fa fa-file-text">Descargar</i></a>
</div>
<div id="div_credencial_movil_pdf" style="display: none;">
    <canvas id="the-canvas"></canvas>
</div>


<!-- Si es ordenador de escritorio has lo que necesites-->
<div id="div_credencial_ordenador" style="display: none;">   
        <embed
	src="{{ asset($reportName) }}" type="application/pdf" width="100%" height="100%" 
	id="preview_report"
	/>
</div>

<a download href="{{ asset($reportName) }}" class="btn button step"><i class="fa fa-file-text">Descargar</i></a>



{{$reportName}}
<!-- jQuery -->
@endsection
@once

    @push('scripts')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite('resources/js/pages/modal/index.js')
        @vite('resources/js/vendor/toastify/index.js')
        @vite('resources/js/pages/notification/index.js')
        
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.10.111/pdf.worker.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.10.111/pdf.min.js" integrity="sha512-hoZmP5l0sJQzHzkXQS3ZCj/H7bOn8JKmbHd/s2trPUoMcvPaBfLSE9/92cpwYzcXBaEtVT/aCQ9P97rkTSWqcw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>

<script type="module">

var ancho_ventana = window.innerWidth;
var alto_ventana = window.innerHeight;
var ancho = null;
var alto = null;
var es_movil = null;

   
$(document).ready(function () {  
   
desplegar_reporte();

//console.log(es_movil);
            
});


function desplegar_reporte() {
    
    es_movil = detectar_dispositivo();
    
    if(es_movil){
        $('#div_credencial_movil_descargar').show();
        $('#div_credencial_movil_pdf').show();
        $('#div_credencial_ordenador').hide();
        
        
        // If absolute URL from the remote server is provided, configure the CORS
        // header on that server.
        var url = '{{ asset($reportName) }}';

        // Loaded via <script> tag, create shortcut to access PDF.js exports.
        var pdfjsLib = window['pdfjs-dist/build/pdf'];

        // The workerSrc property shall be specified.
        pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

        // Asynchronous download of PDF
        var loadingTask = pdfjsLib.getDocument(url);
        loadingTask.promise.then(function(pdf) {
          console.log('PDF loaded');

          // Fetch the first page
          var pageNumber = 1;
          pdf.getPage(pageNumber).then(function(page) {
            //console.log('Page loaded');

            var scale = 1.5;
            var viewport = page.getViewport({scale: scale});

            // Prepare canvas using PDF page dimensions
            var canvas = document.getElementById('the-canvas');
            var context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            // Render PDF page into canvas context
            var renderContext = {
              canvasContext: context,
              viewport: viewport
            };
            var renderTask = page.render(renderContext);
            renderTask.promise.then(function () {
              console.log('Page rendered');
            });
          });
        }, function (reason) {
          // PDF loading error
          console.error(reason);
        });



    }else{
        $('#div_credencial_ordenador').show();        
        $('#div_credencial_movil_descargar').hide();
        $('#div_credencial_movil_pdf').hide();
    }
    
}    

function detectar_dispositivo() {
    //devuelve "true" si es navegador celular, "false" si es computadora
    const toMatch = [
        /Android/i,
        /webOS/i,
        /iPhone/i,
        /iPad/i,
        /iPod/i,
        /BlackBerry/i,
        /Windows Phone/i
    ];
    
    return toMatch.some((toMatchItem) => {
        return navigator.userAgent.match(toMatchItem);
    });
}
     
        </script>
    @endpush
@endonce