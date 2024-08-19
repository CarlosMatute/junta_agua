@extends('../layouts/' . $layout)
@section('subhead')
    <title>Factura de pago</title>
@endsection
@section('subcontent')
<style>

#the-canvas {
    border: 1px solid black;
    direction: ltr;
}
        
</style>
<link
	rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.css"
	integrity="sha512-tKGnmy6w6vpt8VyMNuWbQtk6D6vwU8VCxUi0kEMXmtgwW+6F70iONzukEUC3gvb+KTJTLzDKAGGWc1R7rmIgxQ=="
	crossorigin="anonymous"
	referrerpolicy="no-referrer"
/>
<!-- BEGIN: Profile Info -->
<div class="intro-y box mt-5 px-5 pt-5">    
        <div class="flex flex-1 items-center justify-center px-5 lg:justify-start">            
        <lord-icon
            src="https://cdn.lordicon.com/yqiuuheo.json"
            trigger="in"
            delay="1500"
            state="in-reveal"
            style="width:150px;height:150px">
        </lord-icon>        
        <div class="ml-5">
                <div class="text-lg font-medium truncate w-240 sm:w-80 sm:whitespace-normal">

                    <h1 class="text-5xl font-medium leading-none">FACTURA</h1>
                </div>
                <div class="text-slate-500">Pantalla de Factura de pago.</div>
            </div>
        </div>
        <div class="flex flex-col space-y-4 sm:flex-row  sm:space-y-0">
            <a href="{{url('/contrato')}}" class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed bg-primary border-primary text-white dark:border-primary mb-2 mr-1 mb-2 mr-1">
                <lord-icon
                    src="https://cdn.lordicon.com/zutufmmf.json"
                    trigger="hover"
                    style="width:24px;height:24px">
                </lord-icon>
            </a>                        
        </div>    
</div>
<!-- END: Profile Info -->

<!-- BEGIN: Profile body -->
<div class="intro-y box mt-5 p-5">
    <div class="grid grid-cols-12 gap-6">
        <div class="intro-y col-span-6 lg:col-span-6">
            <div class="p-5">
                <h3 class="text-2xl font-medium leading-none"><div class="flex items-center">
                    <i data-lucide="List" class="w-6 h-6 mr-1"></i>
                        <span class="text-white-700"> Factura </span>
                    </div></h3>
            </div>
        </div>
        <div class="intro-y col-span-6 lg:col-span-6 text-right">
            <div class="p-5">                                                              
            </div>
        </div>
    </div>
    <div class="scrollbar-hidden overflow-x-auto">
        
        <div id="div_credencial_movil_descargar" style="display: none;">
            <a id="btn_imprimir_reporte" class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&:hover:not(:disabled)]:bg-opacity-90 [&:hover:not(:disabled)]:border-opacity-90 [&:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed bg-primary border-primary text-white dark:border-primary mb-2 mr-2 w-32 mb-2 mr-2 w-32"><i class="fa fa-file-text">Imprimir</i></a>        
        </div>
        
        <div id="div_credencial_movil_pdf" style="display: none;">
            <canvas id="the-canvas"></canvas>
        </div>        

<!--         Si es ordenador de escritorio has lo que necesites-->
        <div id="div_credencial_ordenador" style="display: none;">   
                <embed
                src="" type="application/pdf" width="100%" height="500px" 
                id="preview_report"
                />
        </div>

    </div>
</div>
<!-- BEGIN: Profile body --> 
@endsection
@once
    @push('scripts')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite('resources/js/pages/modal/index.js')
        @vite('resources/js/vendor/toastify/index.js')
        @vite('resources/js/pages/notification/index.js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.12/pdfmake.min.js" integrity="sha512-axXaF5grZBaYl7qiM6OMHgsgVXdSLxqq0w7F4CQxuFyrcPmn0JfnqsOtYHUun80g6mRRdvJDrTCyL8LQqBOt/Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.12/vfs_fonts.js" integrity="sha512-nNkHPz+lD0Wf0eFGO0ZDxr+lWiFalFutgVeGkPdVgrG4eXDYUnhfEj9Zmg1QkrJFLC0tGs8ZExyU/1mjs4j93w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>        
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.10.111/pdf.worker.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.10.111/pdf.min.js" integrity="sha512-hoZmP5l0sJQzHzkXQS3ZCj/H7bOn8JKmbHd/s2trPUoMcvPaBfLSE9/92cpwYzcXBaEtVT/aCQ9P97rkTSWqcw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.js" integrity="sha512-/fgTphwXa3lqAhN+I8gG8AvuaTErm1YxpUjbdCvwfTMyv8UZnFyId7ft5736xQ6CyQN4Nzr21lBuWWA9RTCXCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.lordicon.com/lordicon.js"></script>
<script type="module">

var ancho_ventana = window.innerWidth;
var alto_ventana = window.innerHeight;
var ancho = null;
var alto = null;
var es_movil = null;
var id_movimiento = {{ $idMovimiento }};
var url_generar_factura= "{{url('/movimientos/factura')}}";
var uri_reporte_generado = null;
var titleMsg = null;
var textMsg = null;
var typeMsg = null;
var docDefinition = null;

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
               
    generarFactura();
    
    $('#btn_imprimir_reporte').on( "click", function(e){                
        //window.print();
        printJS('the-canvas', 'html');
        //console.log(uri_reporte_generado);
        //printJS({printable: uri_reporte_generado, type:'pdf', showModal:true});                
    });

});

function generarFactura(){

$.ajax({
    type: "post",
    url:url_generar_factura,
    data: {
     "id_movimiento": id_movimiento,
    },
    success: function (data) {
            if(data.msgError!=null){
            titleMsg="Error al Guardar";
            textMsg=data.msgError;
            typeMsg="error";

        }else{

            titleMsg="Datos Guardados";
            textMsg=data.msgSuccess;
            typeMsg="success";    

            for(var i = 0; i < data.tbl_movimientos_list.length; i++) {
                var row= data.tbl_movimientos_list[i];

                var parteSup = [
                    {text: row.servicio, style: "header", alignment: 'center',fontSize: 50},
                    {text: row.cliente, style: "header", alignment: 'center',fontSize: 48},
                    {text: "FACTURA", style: "subheader", alignment: 'center',fontSize: 45},
                    {text: '***************************************************************************************************', style: 'subheader', alignment: 'center'},
                    {text: 'Casa:', style: 'subheader', alignment: 'center',fontSize: 40}, 
                    {text: row.contrato, style: "subheader", alignment: 'center',fontSize: 40},
                    {text: '\n', style: "subheader", alignment: 'center'},
                    {text: 'Descripción del pago:', style: 'subheader', alignment: 'center',fontSize: 40}, 
                    {text: row.pago_servicio, style: "subheader", alignment: 'center',fontSize: 40},
                    {text: '\n', style: "subheader", alignment: 'center'},
                    {text: 'Monto pagado en Lempiras:', style: 'subheader', alignment: 'center',fontSize: 40}, 
                    {text: 'L '+row.monto_pago, style: "subheader", alignment: 'center',fontSize: 40},
                    {text: '\n', style: "subheader", alignment: 'center'},
                    {text: 'Fecha y hora del pago:', style: 'subheader', alignment: 'center',fontSize: 40}, 
                    {text: row.fecha_hora_pago, style: "subheader", alignment: 'center',fontSize: 40},
                    {text: '\n', style: "subheader", alignment: 'center'},
                    {text: 'Cobrador:', style: 'subheader', alignment: 'center',fontSize: 40}, 
                    {text: row.cobrador, style: "subheader", alignment: 'center',fontSize: 40},               
                    {text: '***************************************************************************************************', style: 'subheader', alignment: 'center'},   
                    {text: 'Copia del cliente', style: 'subheader', alignment: 'center',fontSize: 37},
                    {text: '\n\n\n', style: "subheader", alignment: 'center'}                   
                ];

            }

            docDefinition = {
                pageSize: 'LEGAL',
                pageMargins: [ 5, 5 ],
                content: [
                    parteSup,            
                ]
            }            
            //pdfMake.createPdf(docDefinition).download();
            //pdfMake.createPdf(docDefinition).print();
            //pdfMake.createPdf(docDefinition).open();
            //pdfMake.createPdf(docDefinition).open({}, window);
            //pdfMake.createPdf(docDefinition).print({}, window);

            const pdfDocGenerator = pdfMake.createPdf(docDefinition);
            pdfDocGenerator.getDataUrl((dataUrl) => {
                
                
                es_movil = detectar_dispositivo();
    
                if(es_movil){
                    $('#div_credencial_movil_descargar').show();
                    $('#div_credencial_movil_pdf').show();
                    $('#div_credencial_ordenador').hide();        

                    uri_reporte_generado = dataUrl;                                        

                    // If absolute URL from the remote server is provided, configure the CORS
                    // header on that server.
                    var url = uri_reporte_generado;

                    // Loaded via <script> tag, create shortcut to access PDF.js exports.
                    var pdfjsLib = window['pdfjs-dist/build/pdf'];

                    // The workerSrc property shall be specified.
                    pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

                    // Asynchronous download of PDF
                    var loadingTask = pdfjsLib.getDocument(url);
                    loadingTask.promise.then(function(pdf) {
                      //console.log('PDF loaded');

                      // Fetch the first page
                      var pageNumber = 1;
                      pdf.getPage(pageNumber).then(function(page) {
                        //console.log('Page loaded');

                        var scale = 0.9;
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
                          //console.log('Page rendered');
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

                    //const targetElement = document.querySelector('#iframeContainer');
                    //const iframe = document.createElement('iframe');
                    //iframe.src = dataUrl;
                    //targetElement.appendChild(iframe);
                    
                    $("#preview_report").attr( "src", dataUrl );
                    
                }
    
                    
                    

        
            });
            
            


        }
    },
        error: function (xhr, status, error) {
        alert(xhr.responseText);
    }

    
});

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

    //realiza el despliegue de mensage de exito o erro
    function mensage (data) {

            var type = null;

            if(data.msgError!=null){

                    titleMsg="Dato Faltante";;
                    textMsg=data.msgError;
                    typeMsg = "danger";
                    type = "#danger-notification-content";

            }else if(data.msgAlert!=null){
                    titleMsg="Adevertencia";;
                    textMsg=data.msgAlert;
                    typeMsg = "danger";
                    type = "#danger-notification-content";
            }else{

                    titleMsg="Datos Guardados";
                    textMsg=data.msgExito;
                    typeMsg='success';
                    type = "#success-notification-content";

            }

            $("#"+typeMsg+"-notification").html('<div class="font-medium">' + titleMsg + "</div>" + '<div class="mt-1 text-slate-500">' + textMsg + "</div>");

            Toastify({
                    node: $(type).clone().removeClass("hidden")[0],
                    duration: 5000,
                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: "right",
                    stopOnFocus: true,
            }).showToast();
    }

</script>
@endpush
@endonce