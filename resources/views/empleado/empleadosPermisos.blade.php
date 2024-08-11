@extends("../layouts/" . $layout)
@section("subhead")
	<title>Permisos</title>
@endsection
@section("subcontent")
<!-- BEGIN: Profile Info -->
<div class="intro-y box mt-5 px-5 pt-5">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
        <div class="flex flex-1 items-center justify-center px-5 lg:justify-start">
            
        <lord-icon
    src="https://cdn.lordicon.com/ebkiwugo.json"
    trigger="loop"
    delay="2000"
    state="hover-unfold"
    style="width:150px;height:150px">
</lord-icon>
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">Pantalla de Permisos</h1>
        </div>
        <div class="flex flex-col space-y-4 sm:flex-row  sm:space-y-0">
            <a href="{{url('/per-empleado')}}" class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed bg-primary border-primary text-white dark:border-primary mb-2 mr-1 mb-2 mr-1">
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
                        <span class="text-white-700">Permisos del empleado</span>
                    </div></h3>
            </div>
        </div>
        <div class="intro-y col-span-6 lg:col-span-6 text-right">
            <div class="p-5">    
                <x-base.button
                    class="mb-2 mr-1"
                    variant="primary"
                    id="btn_nuevo_seg_usuario_permisos"
                    data-tw-toggle="modal" data-tw-target="#modal_tbl_seg_usuario_permisos"
                ><i data-lucide="Plus" class="w-4 h-4 mr-1"></i>
                        Registrar Nuevo Permiso
                </x-base.button>                                               
            </div>
        </div>
    </div>
    <div class="scrollbar-hidden overflow-x-auto">
<table class="jambo_table table table-hover" id="tbl_seg_usuario_permisos" border=1>
	<thead>
		<tr style="color: black; background-color: buttonhighlight; font-size: large    ">
			<th scope="col">Id</th>
			<th scope="col">Permiso</th>
			<th scope="col">Opciones</th>
		</tr>
	</thead>
<tbody>
@foreach ($seg_usuario_permisos_list as $row)
<tr style="font-size: medium">
<td scope="row">{{$row->id}}</td>
<td scope="row">{{$row->permiso_otorgado}}</td>
<td>
<x-base.button class="btn btn-primary" data-tw-toggle="modal" data-tw-target="#modal_tbl_seg_usuario_permisos"
data-id="{{$row->id}}"
data-permiso="{{$row->permiso}}"
data-permisos="{{$row->permiso_otorgado}}"
title="Editar" class="mb-2 mr-1" variant="primary" size="sm" id="btn_editar_seg_usuario_permisos"><x-base.lucide class="h-4 w-4" icon="Edit"/></x-base.button>
&nbsp&nbsp&nbsp<x-base.button class="btn btn-danger" data-tw-toggle="modal" data-tw-target="#modal_eliminar_seg_usuario_permisos"
data-id="{{$row->id}}"
data-permiso="{{$row->permiso}}"
data-permisos="{{$row->permiso_otorgado}}"
title="Eliminar" class="mb-2 mr-1" variant="danger" size="sm" id="btn_eliminar_seg_usuario_permisos"><x-base.lucide class="h-4 w-4" icon="Trash"/></x-base.button>
</td>
</tr>
@endforeach
</tbody>
</table>

    </div>
</div>
<!-- BEGIN: Profile body --> 

	
<!-- BEGIN: Modal Content -->
<x-base.dialog id="modal_tbl_seg_usuario_permisos" size="xl">
    <x-base.dialog.panel>
        <x-base.dialog.title class="bg-primary">
            <h2 class="mr-auto text-white font-medium">
                <div class="flex items-center">
                <i data-lucide="Plus" class="w-4 h-4 mr-1"></i>
                    <span class="text-white-700"> Registrar Nuevo Permiso a Empleados
                </div>
            </h2>
        </x-base.dialog.title>
        <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
<div class="col-span-12 md:col-span-12 lg:col-span-6">
                <x-base.form-label class="font-extrabold" for="modal_input_primer_nombre">Permiso</x-base.form-label><x-base.tom-select id="permiso" name="permiso" class="w-full" >
				<option></option>
				@foreach ($permisos_list as $permisos)
					<option value="{{$permisos->id}}">{{$permisos->nombre}}</option>
				@endforeach
			</x-base.tom-select></div>
            
        </x-base.dialog.description>
        <x-base.dialog.footer class="bg-dark modal-footer">
            <x-base.button size="sm" class="mr-1 w-20" data-tw-dismiss="modal" type="button" variant="danger">Cancelar</x-base.button>
            <x-base.button size="sm" class="w-20" type="button" variant="primary" id="modal_btn_guardar_seg_usuario_permisos">Guardar</x-base.button>
        </x-base.dialog.footer>
    </x-base.dialog.panel>
</x-base.dialog>
<!-- END: Modal Content -->	

	
	<!-- BEGIN: Modal Content -->
	<x-base.dialog id="modal_eliminar_seg_usuario_permisos">
		<x-base.dialog.panel>
			<div class="p-5 text-center">
				<x-base.lucide class="mx-auto mt-3 h-16 w-16 text-danger" icon="XCircle" />
				<div class="mt-5 text-3xl">¡Advertencia!</div>
				<div class="mt-2 text-slate-500">
					¿Realmente desea eliminar este Permiso?<br />
					<div id="id_registro"></div>
				</div>
			</div>
			<div class="px-5 pb-8 text-center modal-footer">
				<x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button" variant="outline-secondary">Cancelar</x-base.button>
				<x-base.button class="w-24" type="button" variant="danger" id="btn_eliminar_seg_usuario_permisos">Eliminar</x-base.button>
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
	var permiso=null;
	var url_guardar_seg_usuario_permisos= "{{url('/empleado/permisos/guardar')}}";
	var table=null;
	var rowNumber=null;
        var uri= "{{url('')}}";
        var id_empleado = {{$id_empleado}};
	
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
 	$("#btn_nuevo_seg_usuario_permisos").on("click", function (event) {                        
				accion = 1;
				$("#modal_tbl_seg_usuario_permisos").show();
			}); 
 	$("#btn_eliminar_seg_usuario_permisos").on("click", function (event) {                        
				accion = 3;
				$("#modal_eliminar_seg_usuario_permisos").show();
			}); 
table=$("#tbl_seg_usuario_permisos" ).DataTable({
	'language':languageOptionsDatatables,
	dom: "lfBtipr",
	buttons: [
	]
});
 

	
$("#tbl_seg_usuario_permisos").on("click", "#btn_editar_seg_usuario_permisos", function (e) {
	$("#modal_tbl_seg_usuario_permisos").show();
        id=$( this ).data("id");
        permiso=$( this ).data("permiso");
	$("#id").val(id);
	$("#permiso").val(permiso);
});
  
$("#modal_eliminar_seg_usuario_permisos").on("click", "#btn_eliminar_seg_usuario_permisos", function (e) {
	$("#modal_eliminar_seg_usuario_permisos").show();
        id=$( this ).data("id");
        permiso=$( this ).data("permiso");
	$("#id").val(id);
	$("#permiso").val(permiso);
	accion=3;
});
  
$("#tbl_seg_usuario_permisos tbody").on( "click", "tr", function () {
	rowNumber=parseInt(table.row( this ).index());
	accion=2;
	table.$('tr.selected').removeClass('selected');
	$(this).addClass('selected');
});
  
$(".modal-footer").on("click", "#modal_btn_guardar_seg_usuario_permisos", function () {
permiso=$("#permiso").val();
 
	if(permiso== null || permiso == ''){
		mensage({"msgError":'Ingrese un dato para permiso!'});
		return false;
	}
	
	preguardar_seg_usuario_permisos();
});
});
$(".modal-footer").on("click", "#btn_eliminar_seg_usuario_permisos", function () {
	guardar_seg_usuario_permisos();
});

	function preguardar_seg_usuario_permisos() {
              
		  var indexUploadCoincidence=0;
	  
$.when(

).done(function (){
		  guardar_seg_usuario_permisos();
		});
	  }
	
  
function guardar_seg_usuario_permisos(){
	$.ajax({
		type: "post",
		url:url_guardar_seg_usuario_permisos,
		data: {
 		"id": id,
 		"permiso": permiso,
                "id_empleado":id_empleado,
		accion:accion
	},
success: function (data) {
	if(data.msgError!=null){
		if(accion==1 || accion==2){
					$("#modal_tbl_seg_usuario_permisos").show();
				}else if(accion==3){
					$("#modal_eliminar_seg_usuario_permisos").show();
				}
	mensage({"msgError":'Error, datos no guardados!'});
	}else{
		$("#modal_tbl_seg_usuario_permisos").hide();
		for(var i = 0; i < data.seg_usuario_permisos_list.length; i++) {
		var row= data.seg_usuario_permisos_list[i];
		var nuevaFilaDT=[
row.id,row.permiso_otorgado
 ,'<button data-tw-toggle="modal" data-tw-target="#modal_tbl_seg_usuario_permisos" class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&:hover:not(:disabled)]:bg-opacity-90 [&:hover:not(:disabled)]:border-opacity-90 [&:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed bg-primary border-primary text-white dark:border-primary mb-2 mr-1 mb-2 mr-1"'+ 
 'data-id="'+row.id+'" '+ 
 'data-permiso="'+row.permiso+'" '+ 
 'data-permisos="'+row.permiso_otorgado+'" '+ 
 'title="Editar" variant="secondary" size="sm" id="btn_editar_seg_usuario_permisos" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="edit" data-lucide="edit" class="lucide lucide-edit stroke-1.5 h-4 w-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>'+ 
 '&nbsp&nbsp&nbsp<button  data-tw-toggle="modal" data-tw-target="#modal_eliminar_seg_usuario_permisos" class="transition duration-200 border shadow-sm inline-flex items-center justify-center rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed text-xs py-1.5 px-2 bg-danger border-danger text-white dark:border-danger eliminar mb-2 mr-1 eliminar"'+ 
 'data-id="'+row.id+'" '+ 
 'data-permiso="'+row.permiso+'" '+ 
 'data-permisos="'+row.permiso_otorgado+'" '+ 
 'title="Eliminar" variant="danger" size="sm" id="btn_eliminar_seg_usuario_permisos" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="trash" data-lucide="trash" class="lucide lucide-trash stroke-1.5 h-4 w-4"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg></button>'+ 
''
];
if(accion==1) {
	$("#modal_tbl_seg_usuario_permisos").hide();
		table.row.add(nuevaFilaDT).draw();
	}else if (accion==2) {
		$("#modal_tbl_seg_usuario_permisos").hide();
		table.row(rowNumber).data(nuevaFilaDT);
	}else if (accion==4) {
		$("#modal_activar_seg_usuario_permisos").hide();
		table.row(rowNumber).data(nuevaFilaDT);
	}
}
 if (accion == 3){
     $("#modal_eliminar_seg_usuario_permisos").hide();
     table.row(rowNumber).data(nuevaFilaDT);
} 
}


	mensage({"msgExito":'Exito, datos guardados!'});
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
