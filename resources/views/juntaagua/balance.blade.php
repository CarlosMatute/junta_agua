@extends("../layouts/" . $layout)
@section("subhead")
	<title>Balance General</title>
@endsection
@section("subcontent")

<!-- BEGIN: Profile Info -->
<div class="px-5 pt-5 mt-5 intro-y box">
    
        <div class="flex flex-1 items-center justify-center px-5 lg:justify-start">
            
        <lord-icon
                src="https://cdn.lordicon.com/qnwzeeae.json"
                trigger="loop"
                delay="2000"
                style="width:150px;height:150px">
            </lord-icon>
            <div class="ml-5">
                <div class="text-lg font-medium truncate w-240 sm:w-80 sm:whitespace-normal">

                    <h1 class="text-5xl font-medium leading-none">BALANCE GENERAL</h1>
                </div>
                <div class="text-slate-500">Pantalla de administración de Saldos de Clientes.</div>
            </div>
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
                        <span class="text-white-700">Movimientos - Saldos</span>
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
            </div>
        </div>
    </div>
    <div class="scrollbar-hidden overflow-x-auto">
<table id="tbl_tbl_movimientos"  class="display datatable" style="width:100%">
	<thead>
		<tr>
			<th scope="col">Cliente</th>
			<th scope="col">Debe</th>
			<th scope="col">Haber</th>			
			<th scope="col">Estado</th>			
		</tr>
	</thead>
<tbody>
@foreach ($sql_balance_general as $row)
<tr style="font-size: medium">
<td scope="row">{{$row->nombre_cliente}}</td>
<td scope="row">{{$row->debe}}</td>
<td scope="row">{{$row->haber}}</td>
<td scope="row">{{$row->estado_cuenta}}</td>
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
					¿Realmente desea eliminar este Movimiento?<br />
					<div id="id_registro"></div>
				</div>
			</div>
			<div class="px-5 pb-8 text-center modal-footer">
				<x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button" variant="outline-secondary">Cancelar</x-base.button>
				<x-base.button class="w-24" type="button" variant="danger" id="modal_btn_eliminar_tbl_movimientos">Eliminar</x-base.button>
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
<script src="https://cdn.lordicon.com/lordicon.js"></script>
<script type="module">
	var accion=null;
	var id=null;
	var fecha_hora=null;
	var concepto=null;
	var debe=null;
	var haber=null;
	var id_tipo_movimiento=null;
	var url_guardar_tbl_movimientos= "{{url('/movimientos')}}/guardar";
	var url_generar_factura= "{{url('/movimientos/factura')}}";
	var uri= "{{url('')}}";
	var table=null;
	var rowNumber=null;        
        var id_movimiento = null;
	
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



            table=$("#tbl_tbl_movimientos" ).DataTable({
                    'language':languageOptionsDatatables,
            });

        });
        
</script>
@endpush
@endonce
