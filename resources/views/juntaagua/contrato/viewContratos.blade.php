@extends('../layouts/' . $layout)
@section('subhead')
    <title>Contratos</title>
@endsection

@section('subcontent')
{{-- Mostrar Mensajes Flash --}}
        @if(session('msgSuccess'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('msgSuccess') }}
            </div>
        @endif

        @if(session('msgError'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('msgError') }}
            </div>
        @endif

        @if(session('msgWarning'))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                {{ session('msgWarning') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
{{--Encabezado--}}
<div class="intro-y box mt-5 px-5 pt-5">    
        <div class="flex flex-1 items-center justify-center px-5 lg:justify-start">            
        <lord-icon
            src="https://cdn.lordicon.com/vhyuhmbl.json"
            trigger="loop"
            delay="3500"
            state="morph-group"
            style="width:150px;height:150px">
        </lord-icon>
            <div class="ml-5">
                <div class="text-lg font-medium truncate w-240 sm:w-80 sm:whitespace-normal">

                    <h1 class="text-5xl font-medium leading-none">CONTRATOS</h1>
                </div>
                <div class="text-slate-500">Pantalla de administración de contratos.</div>
            </div>        
        </div>              
</div>
{{--Data Table--}}
<div class="p-5 mt-5 intro-y box">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-6 intro-y lg:col-span-6">
            <div class="p-5">
                <h3 class="text-2xl font-medium leading-none"><div class="flex items-center">
                    <i data-lucide="List" class="w-6 h-6 mr-1"></i>
                        <span class="text-white-700"> Lista de Contratos</span>
                    </div></h3>
            </div>
        </div>
        <div class="col-span-6 text-right intro-y lg:col-span-6">
            <div class="p-5">
                <a class="bg-primary  text-white font-bold py-2 px-4 rounded" 
                href="{{ Route('crear_contrato') }}">
                    Agregar Nuevo Contrato
                </a>

            </div>
        </div>
    </div>
    <div class="overflow-x-auto scrollbar-hidden">
        <table id="tablaContrato" class="display datatable" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Servicio</th>
                    <th>Monto</th>
                    <th>Nombre Cliente</th>
                    <th>Descripcion Casa</th>
                    <th>Fecha inicio</th>
                    <th>Fecha fin</th>
                    <th>Creado</th>
                    <th>Actualizado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
           {{--   <tbody>
                @foreach ($listarContratos as $item)
                <tr>    
                    <td>{{$item->id}}</td>
                    <td>{{$item->servicio}}</td>
                    <td>{{$item->monto}}</td>
                    <td>{{$item->nombre_cliente}}</td>
                    <td>{{$item->descripcion_casa}}</td>
                    <td>{{$item->fecha_inicio}}</td>
                    <td>{{$item->fecha_fin}}</td>
                    <td>{{$item->created_at}}</td>
                    <td>{{$item->updated_at}}</td>
                    <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                        <!-- Botón Editar -->
                        <a href="{{ route('editar_contrato', $item->id) }}" class="bg-warning hover:bg-yellow-700 text-white font-bold h-10 w-10 rounded flex items-center justify-center">
                            <x-base.lucide
                                class="h-4 w-4"
                                icon="Edit"
                            />
                        </a>

                        <!-- Botón Eliminar -->
                        <button type="button" class="bg-danger hover:bg-red-700 text-white font-bold h-10 w-10 rounded flex items-center justify-center btn-eliminar" data-id="{{ $item->id }}">
                            <x-base.lucide
                                class="h-4 w-4"
                                icon="Trash"
                            />
                        </button>
                        
                        <a href="{{url('/movimientos/'.$item->id)}}" class="bg-warning hover:bg-green-700 text-white font-bold h-10 w-10 rounded flex items-center justify-center">
                            <x-base.lucide
                                class="h-4 w-4"
                                icon="DollarSign"
                            />
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>--}}
        </table>
    </div>
</div>

<!-- Modal para confirmar eliminación -->
<x-base.dialog id="modal_eliminar">
    <x-base.dialog.panel>
        <div class="p-5 text-center">
            <x-base.lucide class="mx-auto mt-3 h-16 w-16 text-danger" icon="XCircle" />
            <div class="mt-5 text-3xl">¡Advertencia!</div>
            <div class="mt-2 text-slate-500">
                ¿Realmente desea eliminar este registro?<br />
                <div id="id_registro"></div>
            </div>
        </div>
        <div class="px-5 pb-8 text-center">
            <x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button" variant="outline-secondary">
                Cancelar
            </x-base.button>
            <x-base.button class="w-24" type="button" variant="danger" id="btn_eliminar_confirmar">
                Eliminar
            </x-base.button>
        </div>
    </x-base.dialog.panel>
</x-base.dialog>

@endsection

@once
    @push('scripts')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite('resources/js/pages/modal/index.js')
    @vite('resources/js/vendor/toastify/index.js')
    @vite('resources/js/pages/notification/index.js')
    <script src="https://cdn.lordicon.com/lordicon.js"></script>

    <script type="module">
        var table = null;
        var urlListarContratos = "{{ route('dataListarContratos') }}";

        var lenguaje = {
            "decimal": "",
            "emptyTable": "Datos no disponibles",
            "info": "Mostrando desde _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando desde 0 a 0 de 0 registros",
            "infoFiltered": "(Filtrado de _MAX_ registros totales)",
            "lengthMenu": "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": activar ordenamiento ascendente",
                "sortDescending": ": activar ordenamiento descendente"
            }
        };

        $(document).ready(function () {
            table = $('#tablaContrato').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: urlListarContratos,
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'id' },
                    { data: 'servicio' },
                    { data: 'monto' },
                    { data: 'nombre_cliente' },
                    { data: 'descripcion_casa' },
                    { data: 'fecha_inicio' },
                    { data: 'fecha_fin' },
                    { data: 'created_at' },
                    { data: 'updated_at' },
                    { data: null, orderable: false, searchable: false }
                ],
                columnDefs: [{
                    targets: 9,
                    createdCell: function (td, cellData, rowData) {
                        var urlEditar = "{{ route('editar_contrato', ':id') }}".replace(':id', rowData.id);
                        var urlPago = "{{ route('pago_contrato', ':id') }}".replace(':id', rowData.id);

                        var iconEdit = `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M15.232 5.232l3.536 3.536M4 13.5V19h5.5l9.79-9.79a1 1 0 000-1.42l-3.08-3.08a1 1 0 00-1.42 0L4 13.5z"/></svg>`;
                        var iconEliminar = `
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2m3 0v14a2 2 0 01-2 2H8a2 2 0 01-2-2V6h14z" />
                                            </svg>`;
                        var iconPagar = `
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M12 1v22M17 5H9.5a3.5 3.5 0 100 7H14a3.5 3.5 0 110 7H6" />
                                            </svg>`;

                        var btnEditar = `<a href="${urlEditar}" class="bg-warning hover:bg-yellow-700 text-white font-bold h-10 w-10 rounded flex items-center justify-center" title="Editar">${iconEdit}</a>`;
                        var btnEliminar = `<button type="button" class="bg-danger hover:bg-red-700 text-white font-bold h-10 w-10 rounded flex items-center justify-center btn-eliminar" data-id="${rowData.id}">${iconEliminar}</button>`;
                        var btnPago = `<a href="${urlPago}" class="bg-success hover:bg-success-700 text-white font-bold h-10 w-10 rounded flex items-center justify-center">${iconPagar}</a>`;

                        $(td).html(`
                            <div class="flex gap-2 justify-center">
                                ${btnEditar}
                                ${btnEliminar}
                                ${btnPago}
                            </div>
                        `);
                        
                    }
                }],
                deferRender: true,
                language: lenguaje
            });

            // Delegación del evento para botones de eliminación
            $('#tablaContrato').on('click', '.btn-eliminar', function () {
                const id = $(this).data('id');
                const modalElement = document.querySelector("#modal_eliminar");
                const modal = tailwind.Modal.getOrCreateInstance(modalElement);
                $('#btn_eliminar_confirmar').data('id', id);
                $('#id_registro').html(`ID: <strong>${id}</strong>`);
                modal.show();
            });

            // Confirmar eliminación
            $('#btn_eliminar_confirmar').on('click', function () {
                const id = $(this).data('id');
                const form = $('<form>', {
                    method: 'GET',
                    action: `{{ url('/') }}/contrato/eliminar/${id}`
                });
                $('body').append(form);
                form.submit();
            });

            // Ocultar modal al hacer clic en "Cancelar"
            $('[data-tw-dismiss="modal"]').on('click', function () {
                const modalElement = document.querySelector("#modal_eliminar");
                const modal = tailwind.Modal.getOrCreateInstance(modalElement);
                modal.hide();
            });
        });
    </script>
    @endpush
@endonce

