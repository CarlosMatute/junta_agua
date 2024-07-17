@extends("../layouts/" . $layout)
@section("subhead")
	<title>Movimientos - cobros</title>
@endsection
@section("subcontent")

<!-- BEGIN: Profile Info -->
<div class="intro-y box mt-5 px-5 pt-5">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
        <div class="flex flex-1 items-center justify-center px-5 lg:justify-start">
            
        <lord-icon
                src="https://cdn.lordicon.com/qtnfcnne.json"
                trigger="loop"
                delay="2000"
                style="width:150px;height:150px">
            </lord-icon>
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">Pantalla de Saldos</h1>
        </div>
        <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
            <a href="{{url('/contrato')}}" class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed bg-primary border-primary text-white dark:border-primary mb-2 mr-1 mb-2 mr-1">
                <lord-icon
                    src="https://cdn.lordicon.com/zutufmmf.json"
                    trigger="hover"
                    style="width:24px;height:24px">
                </lord-icon>
            </a>
        </div>
    </div>    
</div>
<!-- END: Profile Info -->
<script src="https://cdn.lordicon.com/lordicon.js"></script>

<!-- BEGIN: Profile body -->
<div class="intro-y box mt-5 p-5">
    <div class="grid grid-cols-12 gap-6">
        <div class="intro-y col-span-6 lg:col-span-6">
            <div class="p-5">
                <h3 class="text-2xl font-medium leading-none"><div class="flex items-center">
                    <i data-lucide="List" class="w-6 h-6 mr-1"></i>
                        <span class="text-white-700">Movimientos - cobros</span>
                    </div></h3>
            </div>
        </div>
        <div class="intro-y col-span-6 lg:col-span-6 text-right">
            <div class="p-5">    
<!--                <x-base.button
                    class="mb-2 mr-1"
                    variant="primary"
                    id="btn_nuevo_tbl_movimientos"
                    data-tw-toggle="modal" data-tw-target="#modal_tbl_tbl_movimientos"
                ><i data-lucide="Plus" class="w-4 h-4 mr-1"></i>
                        Registrar Nuevo Movimientos - cobros
                </x-base.button>                                               -->
                <x-base.button
                    class="mb-2 mr-1"
                    variant="primary"
                    id="btn_cobro_tbl_movimientos"                   
                ><i data-lucide="Plus" class="w-4 h-4 mr-1"></i>
                        Registrar cobro
                </x-base.button>                                               
                <x-base.button
                    class="mb-2 mr-1"
                    variant="primary"
                    id="btn_pago_tbl_movimientos"
                    data-tw-toggle="modal" data-tw-target="#modal_pago_tbl_movimientos"
                ><i data-lucide="Plus" class="w-4 h-4 mr-1"></i>
                        Registrar Pago
                </x-base.button>                                               
            </div>
        </div>
    </div>
    <div class="scrollbar-hidden overflow-x-auto">
<table class="jambo_table table table-hover" id="tbl_tbl_movimientos" border=1>
	<thead>
		<tr style="color: black; background-color: buttonhighlight; font-size: large    ">
			<th scope="col">Id</th>
			<th scope="col">Fecha</th>
			<th scope="col">Servicio</th>
			<th scope="col">Debe</th>
			<th scope="col">Haber</th>
			<th scope="col">Movimiento</th>
			<th scope="col">Opciones</th>
		</tr>
	</thead>
<tbody>
@foreach ($tbl_movimientos_list as $row)
<tr style="font-size: medium">
<td scope="row">{{$row->id}}</td>
<td scope="row">{{$row->fecha_hora}}</td>
<td scope="row">{{$row->concepto}}</td>
<td scope="row">{{$row->debe}}</td>
<td scope="row">{{$row->haber}}</td>
<td scope="row">{{$row->tipo_movimiento}}</td>
<td>
    
@if( $row->id_tipo_movimiento == 2)
<x-base.button class="btn btn-primary" data-tw-toggle="modal" data-tw-target="#modal_tbl_tbl_movimientos"
data-id="{{$row->id}}"
data-fecha_hora="{{$row->fecha_hora}}"
data-concepto="{{$row->concepto}}"
data-debe="{{$row->debe}}"
data-haber="{{$row->haber}}"
data-id_tipo_movimiento="{{$row->id_tipo_movimiento}}"
data-tipo_movimiento="{{$row->tipo_movimiento}}"
title="Editar" class="mb-2 mr-1" variant="primary" size="sm" id="btn_editar_tbl_movimientos"><x-base.lucide class="h-4 w-4" icon="Edit"/></x-base.button>
@endif
&nbsp&nbsp&nbsp<x-base.button class="btn btn-danger" data-tw-toggle="modal" data-tw-target="#modal_eliminar_tbl_movimientos"
data-id="{{$row->id}}"
data-fecha_hora="{{$row->fecha_hora}}"
data-concepto="{{$row->concepto}}"
data-debe="{{$row->debe}}"
data-haber="{{$row->haber}}"
data-id_tipo_movimiento="{{$row->id_tipo_movimiento}}"
data-tipo_movimiento="{{$row->tipo_movimiento}}"
title="Eliminar" class="mb-2 mr-1" variant="danger" size="sm" id="btn_eliminar_tbl_movimientos"><x-base.lucide class="h-4 w-4" icon="Trash"/></x-base.button>
&nbsp&nbsp&nbsp
@if( $row->id_tipo_movimiento == 2)
<a href="{{url('/movimientos/'.$row->id.'/pago/factura')}}" class="bg-warning hover:bg-yellow-700 text-white font-bold h-10 w-10 rounded flex items-center justify-center">
    <x-base.lucide
        class="h-4 w-4"
        icon="FileText"
    />
</a>
@endif
</td>
</tr>
@endforeach
</tbody>
</table>

    </div>
</div>
<!-- BEGIN: Profile body --> 

	
<!-- BEGIN: Modal Content -->
<x-base.dialog id="modal_tbl_tbl_movimientos" size="xl">
    <x-base.dialog.panel>
        <x-base.dialog.title class="bg-primary">
            <h2 class="mr-auto text-white font-medium">
                <div class="flex items-center">
                <i data-lucide="Plus" class="w-4 h-4 mr-1"></i>
                    <span class="text-white-700"> Registrar Nuevo Movimientos - cobros
                </div>
            </h2>
        </x-base.dialog.title>
        <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
<div class="col-span-12 md:col-span-12 lg:col-span-6">
                <x-base.form-label class="font-extrabold" for="modal_input_primer_nombre">Fecha</x-base.form-label><x-base.form-input placeholder="Escriba un dato para fecha_hora" type="text" class="timestamp" id="fecha_hora" name="fecha_hora"/></div>
<div class="col-span-12 md:col-span-12 lg:col-span-6">
                <x-base.form-label class="font-extrabold" for="modal_input_primer_nombre">Concepto</x-base.form-label><x-base.form-input placeholder="Escriba un dato para concepto" type="text" id="concepto" name="concepto"/></div>
<div class="col-span-12 md:col-span-12 lg:col-span-6">
                <x-base.form-label class="font-extrabold" for="modal_input_primer_nombre">Debe</x-base.form-label><x-base.form-input placeholder="Escriba un dato para debe" type="text" id="debe" name="debe"/></div>
<div class="col-span-12 md:col-span-12 lg:col-span-6">
                <x-base.form-label class="font-extrabold" for="modal_input_primer_nombre">Haber</x-base.form-label><x-base.form-input placeholder="Escriba un dato para haber" type="text" id="haber" name="haber"/></div>
<div class="col-span-12 md:col-span-12 lg:col-span-6">
    <x-base.form-label class="font-extrabold" for="modal_input_primer_nombre">Movimiento</x-base.form-label>
    <select id="id_tipo_movimiento" name="id_tipo_movimiento" data-tw-merge aria-label=".form-select-lg example" class="w-full disabled:bg-slate-100 disabled:cursor-not-allowed disabled:dark:bg-darkmode-800/50 [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md py-2 px-3 pr-8 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 mt-2 sm:mr-2 mt-2 sm:mr-2">
        <option></option>
        @foreach ($tipo_movimiento_list as $tipo_movimiento)
            <option value="{{$tipo_movimiento->id}}">{{$tipo_movimiento->movimiento}}</option>
        @endforeach
    </select>
</div>
            
        </x-base.dialog.description>
        <x-base.dialog.footer class="bg-dark modal-footer">
            <x-base.button size="sm" class="mr-1 w-20" data-tw-dismiss="modal" type="button" variant="danger">Cancelar</x-base.button>
            <x-base.button size="sm" class="w-20" type="button" variant="primary" id="modal_btn_guardar_tbl_movimientos">Guardar</x-base.button>
        </x-base.dialog.footer>
    </x-base.dialog.panel>
</x-base.dialog>
<!-- END: Modal Content -->


<!-- BEGIN: Modal Content -->
<x-base.dialog id="modal_pago_tbl_movimientos" size="xl">
    <x-base.dialog.panel>
        <x-base.dialog.title class="bg-primary">
            <h2 class="mr-auto text-white font-medium">
                <div class="flex items-center">
                <i data-lucide="Plus" class="w-4 h-4 mr-1"></i>
                    <span class="text-white-700"> Registrar Pago Movimientos - cobros
                </div>
            </h2>
        </x-base.dialog.title>
        <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">

          
                
                <div class="col-span-12 md:col-span-12 lg:col-span-6">
                <x-base.form-label class="font-extrabold" for="modal_input_primer_nombre">Monto pago</x-base.form-label><x-base.form-input placeholder="Escriba un dato para haber" type="text" id="haber_pago" name="haber_pago"/></div>

        </x-base.dialog.description>
        <x-base.dialog.footer class="bg-dark modal-footer">
            <x-base.button size="sm" class="mr-1 w-20" data-tw-dismiss="modal" type="button" variant="danger">Cancelar</x-base.button>
            <x-base.button size="sm" class="w-20" type="button" variant="primary" id="modal_btn_guardar_pago_tbl_movimientos">Guardar</x-base.button>
        </x-base.dialog.footer>
    </x-base.dialog.panel>
</x-base.dialog>
<!-- END: Modal Content -->	

	
	<!-- BEGIN: Modal Content -->
	<x-base.dialog id="modal_eliminar_tbl_movimientos">
		<x-base.dialog.panel>
			<div class="p-5 text-center">
				<x-base.lucide class="mx-auto mt-3 h-16 w-16 text-danger" icon="XCircle" />
				<div class="mt-5 text-3xl">¡Advertencia!</div>
				<div class="mt-2 text-slate-500">
					¿Realmente desea eliminar este Movimientos - cobros?<br />
					<div id="id_registro"></div>
				</div>
			</div>
			<div class="px-5 pb-8 text-center">
				<x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button" variant="outline-secondary">Cancelar</x-base.button>
				<x-base.button class="w-24" type="button" variant="danger" id="btn_eliminar_tbl_movimientos">Eliminar</x-base.button>
			</div>
		</x-base.dialog.panel>
	</x-base.dialog>
	<!-- END: Modal Content -->


	<div class="text-center">
		<!-- BEGIN: Notification Content -->
		<div id="success-notification-content" class="py-5 pl-5 pr-14 bg-white border border-slate-200/60 rounded-lg shadow-xl dark:bg-darkmode-600 dark:text-slate-300 dark:border-darkmode-600 hidden flex flex flex">
			<i data-lucide="check-circle" width="24" height="24" class="stroke-1.5 text-success text-success"></i>
			<div id="success-notification" class="ml-4 mr-4">
				
			</div>
		</div>
		<div id="danger-notification-content" class="py-5 pl-5 pr-14 bg-white border border-slate-200/60 rounded-lg shadow-xl dark:bg-darkmode-600 dark:text-slate-300 dark:border-darkmode-600 hidden flex flex flex">
			<i data-lucide="x-circle" width="24" height="24" class="stroke-1.5 text-danger text-danger"></i>
			<div id="danger-notification" class="ml-4 mr-4">
				
			</div>
		</div>
		<!-- END: Notification Content -->
	</div>

@endsection
@once
	@push('scripts')
                        @vite(['resources/css/app.css', 'resources/js/app.js'])
		        @vite('resources/js/pages/modal/index.js')
		        @vite('resources/js/vendor/toastify/index.js')
		        @vite('resources/js/pages/notification/index.js')
  
<script type="module">
	var accion=null;
	var id=null;
	var fecha_hora=null;
	var concepto=null;
	var debe=null;
	var haber=null;
	var id_tipo_movimiento=null;
	var url_guardar_tbl_movimientos= "{{url('/movimientos')}}/guardar";
	var table=null;
	var rowNumber=null;
        var id_contrato = {{$id_contrato}};
	
			var titleMsg = null;
            var textMsg = null;
            var typeMsg = null;
			var languageOptionsDatatables={

			"decimal":        "",
			"emptyTable":     "Datos no disponibles",
			"info":           "Mostrando desde _START_ a _END_ de _TOTAL_ registros",
			"infoEmpty":      "Mostrando desde 0 a 0 de 0 registros",
			"infoFiltered":   "(Filrado de _MAX_ registros totales)",
			"infoPostFix":    "",
			"thousands":      ",",
			"lengthMenu":     "Mostrar _MENU_ registros",
			"loadingRecords": "Cargando...",
			"processing":     "Procesando...",
			"search":         "Buscar:",
			"zeroRecords":    "Sin resultados",
			"paginate": {
				"first":      "Primero",
				"last":       "Ultimo",
				"next":       "Siguiente",
				"previous":   "Anterior"
			},
			"aria": {
				"sortAscending":  ": activar ordenamiento por columna ascendente",
				"sortDescending": ": activar ordenamiento por columna descendente"
			}
			}
	
	$(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });	
 	$("#btn_nuevo_tbl_movimientos").on("click", function (event) {                        
            accion = 1;
            $("#modal_tbl_tbl_movimientos").show();
        }); 
 	$("#btn_eliminar_tbl_movimientos").on("click", function (event) {                        
            accion = 3;
            $("#modal_eliminar_tbl_movimientos").show();
        }); 
 	
        $("#btn_pago_tbl_movimientos").on("click", function (event) {                        
            accion = 4;
            $("#modal_pago_tbl_movimientos").show();
        }); 

//	$('.timestamp').daterangepicker({
//                    singleDatePicker: true,
//                    showDropdowns: true,
//                    timePicker: true,
//                    timePicker24Hour: true,
//                    minYear: 1901,                    
//                    "locale": {
//                        "monthNames": monthNames,
//                        "daysOfWeek": daysOfWeek,
//                        "applyLabel": "Aplicar",
//                        "cancelLabel": "Cancelar",
//                        "fromLabel": "Desde",
//                        "toLabel": "Hasta",
//                        format: 'YYYY-MM-DD HH:mm'
//                    },
//                  });

table=$("#tbl_tbl_movimientos" ).DataTable({
	'language':languageOptionsDatatables,
	dom: "lfBtipr",
	buttons: [
	]
});
 

	
$("#tbl_tbl_movimientos").on("click", "#btn_editar_tbl_movimientos", function (e) {
    $("#modal_tbl_tbl_movimientos").show();
    id=$( this ).data("id");
    fecha_hora=$( this ).data("fecha_hora");
    concepto=$( this ).data("concepto");
    debe=$( this ).data("debe");
    haber=$( this ).data("haber");
    id_tipo_movimiento=$( this ).data("id_tipo_movimiento");
    $("#id").val(id);
    $("#fecha_hora").val(fecha_hora);
    $("#concepto").val(concepto);
    $("#debe").val(debe);
    $("#haber").val(haber);
    $("#id_tipo_movimiento").val(id_tipo_movimiento);
        
        //acceder al objeto hijo por medio del objeto padre $( "#id_tipo_movimiento-ts-control > input" ).val( "borderasdfasdfatrestset" );
});
  
$("#modal_eliminar_tbl_movimientos").on("click", "#btn_eliminar_tbl_movimientos", function (e) {
    $("#modal_eliminar_tbl_movimientos").show();
    id=$( this ).data("id");
    fecha_hora=$( this ).data("fecha_hora");
    concepto=$( this ).data("concepto");
    debe=$( this ).data("debe");
    haber=$( this ).data("haber");
    id_tipo_movimiento=$( this ).data("id_tipo_movimiento");
    $("#id").val(id);
    $("#fecha_hora").val(fecha_hora);
    $("#concepto").val(concepto);
    $("#debe").val(debe);
    $("#haber").val(haber);
    $("#id_tipo_movimiento").val(id_tipo_movimiento);
    accion=3;
});
  
$("#btn_cobro_tbl_movimientos").on( "click", function () {
    accion=5;
    preguardar_tbl_movimientos();
});

$("#tbl_tbl_movimientos tbody").on( "click", "tr", function () {
	rowNumber=parseInt(table.row( this ).index());
	accion=2;
	table.$('tr.selected').removeClass('selected');
	$(this).addClass('selected');
                
        $("#fecha_hora").prop("readonly", true);
        $("#concepto").prop("readonly", true);
        $("#debe").prop("readonly", true);
        //$("#id_tipo_movimiento").attr("readonly", true);
        $("#id_tipo_movimiento").attr("disabled", "disabled"); 
    
});
  
$(".modal-footer").on("click", "#modal_btn_guardar_tbl_movimientos", function () {
fecha_hora=$("#fecha_hora").val();
concepto=$("#concepto").val();
debe=$("#debe").val();
haber=$("#haber").val();
id_tipo_movimiento=$("#id_tipo_movimiento").val();
 
    if(accion == 1){
	if(fecha_hora== null || fecha_hora == ''){
		mensage({"msgError":'Ingrese un dato para fecha_hora!'});
		return false;
	}
	 
	if(concepto== null || concepto == ''){
		mensage({"msgError":'Ingrese un dato para concepto!'});
		return false;
	}
	 
	if(debe== null || debe == ''){
		mensage({"msgError":'Ingrese un dato para debe!'});
		return false;
	}
	 
	if(haber== null || haber == ''){
		mensage({"msgError":'Ingrese un dato para haber!'});
		return false;
	}	
 
	if(id_tipo_movimiento== null || id_tipo_movimiento == ''){
		mensage({"msgError":'Ingrese un dato para id_tipo_movimiento!'});
		return false;
	}
    }else if(accion == 2){
        if(haber== null || haber == ''){
		mensage({"msgError":'Ingrese un dato para haber!'});
		return false;
	}
    }
    
    preguardar_tbl_movimientos();
});

$(".modal-footer").on("click", "#modal_btn_guardar_pago_tbl_movimientos", function () {

    haber=$("#haber_pago").val();

    if(haber== null || haber == ''){
        mensage({"msgError":'Ingrese un dato para haber!'});
        return false;
    }

    preguardar_tbl_movimientos();
});



});
$(".modal-footer").on("click", "#btn_eliminar_tbl_movimientos", function () {
	guardar_tbl_movimientos();
});

	function preguardar_tbl_movimientos() {
              
		  var indexUploadCoincidence=0;
	  
$.when(

).done(function (){
		  guardar_tbl_movimientos();
		});
	  }
	
  
function guardar_tbl_movimientos(){
	$.ajax({
		type: "post",
		url:url_guardar_tbl_movimientos,
		data: {
 		"id": id,
 		"fecha_hora": fecha_hora,
 		"concepto": concepto,
 		"debe": debe,
 		"haber": haber,
 		"id_tipo_movimiento": id_tipo_movimiento,
 		"id_contrato": id_contrato,
		accion:accion
	},
        success: function (data) {
            //console.log(data)
	if(data.msgError!=null){
            if(accion==1 || accion==2){
                $("#modal_tbl_tbl_movimientos").show();
            }else if(accion==3){
                $("#modal_eliminar_tbl_movimientos").show();
            }else if(accion==4){
                $("#modal_pago_tbl_movimientos").show();
            }else if(accion==5){
            
            }
            mensage({"msgError":data.msgError});
	}else{
		$("#modal_tbl_tbl_movimientos").hide();
		for(var i = 0; i < data.tbl_movimientos_list.length; i++) {
		var row= data.tbl_movimientos_list[i];
		var nuevaFilaDT=[
                row.id,row.fecha_hora,row.concepto,row.debe,row.haber,row.tipo_movimiento
                 ,'<button data-tw-toggle="modal" data-tw-target="#modal_tbl_tbl_movimientos" class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&:hover:not(:disabled)]:bg-opacity-90 [&:hover:not(:disabled)]:border-opacity-90 [&:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed bg-primary border-primary text-white dark:border-primary mb-2 mr-1 mb-2 mr-1"'+ 
                 'data-id="'+row.id+'" '+ 
                 'data-fecha_hora="'+row.fecha_hora+'" '+ 
                 'data-concepto="'+row.concepto+'" '+ 
                 'data-debe="'+row.debe+'" '+ 
                 'data-haber="'+row.haber+'" '+ 
                 'data-id_tipo_movimiento="'+row.id_tipo_movimiento+'" '+ 
                 'data-tipo_movimiento="'+row.tipo_movimiento+'" '+ 
                 'title="Editar" variant="secondary" size="sm" id="btn_editar_tbl_movimientos" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="edit" data-lucide="edit" class="lucide lucide-edit stroke-1.5 h-4 w-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>'+ 
                 '&nbsp&nbsp&nbsp<button  data-tw-toggle="modal" data-tw-target="#modal_eliminar_tbl_movimientos" class="transition duration-200 border shadow-sm inline-flex items-center justify-center rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed text-xs py-1.5 px-2 bg-danger border-danger text-white dark:border-danger eliminar mb-2 mr-1 eliminar"'+ 
                 'data-id="'+row.id+'" '+ 
                 'data-fecha_hora="'+row.fecha_hora+'" '+ 
                 'data-concepto="'+row.concepto+'" '+ 
                 'data-debe="'+row.debe+'" '+ 
                 'data-haber="'+row.haber+'" '+ 
                 'data-id_tipo_movimiento="'+row.id_tipo_movimiento+'" '+ 
                 'data-tipo_movimiento="'+row.tipo_movimiento+'" '+ 
                 'title="Eliminar" variant="danger" size="sm" id="btn_eliminar_tbl_movimientos" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="trash" data-lucide="trash" class="lucide lucide-trash stroke-1.5 h-4 w-4"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg></button>'+ 
                ''
                ];
            if(accion==1) {
                $("#modal_tbl_tbl_movimientos").hide();
                table.row.add(nuevaFilaDT).draw();
            }else if (accion==2) {
                $("#modal_tbl_tbl_movimientos").hide();
                table.row(rowNumber).data(nuevaFilaDT);
            }else if (accion==4) {
                $("#modal_pago_tbl_movimientos").hide();
                table.row(rowNumber).data(nuevaFilaDT);
            }else if(accion==5){
                table.row(rowNumber).data(nuevaFilaDT);
            }
        }
        if (accion == 3){
            $("#modal_eliminar_tbl_movimientos").hide();
            table.row(rowNumber).data(nuevaFilaDT);
        } 
        
        mensage({"msgExito":data.msgSuccess});
    }


    
},
error: function (xhr, status, error) {
	alert(xhr.responseText);
}
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
