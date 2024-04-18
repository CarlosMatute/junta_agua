@extends('../layouts/' . $layout)

@section('subhead')
    <title>Clientes</title>
@endsection

@section('subcontent')
<table id="sdatatable" class="display datatable" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Extn.</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>
        @for ($i = 1; $i <= 15; $i++)
            <tr>
                <td>{{ $i }}</td>
                <td>Nombre {{ $i }}</td>
                <td>Nombre {{ $i }}</td>
                <td>Nombre {{ $i }}</td>
                <td>Nombre {{ $i }}</td>
                <td>Nombre {{ $i }}</td>
                <!-- Aquí puedes agregar más columnas según tus necesidades -->
            </tr>
        @endfor
        </tbody>
    </table>
@endsection
@once
    @push('scripts')
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite('resources/js/pages/modal/index.js')
        @vite('resources/js/vendor/toastify/index.js')
        @vite('resources/js/pages/notification/index.js')
        <script type="module">
            

            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    
                });	  

                //$.fn.dataTable.isDataTable('#sdatatable')
                    // Inicializa el DataTable
                    $('#sdatatable').DataTable({
                        language: { 
                            "decimal": ",", 
                            "thousands": ".", 
                            "lengthMenu": "Mostrar _MENU_ registros", 
                            "zeroRecords": "No se encontraron resultados", 
                            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros", 
                            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros", 
                            "infoFiltered": "(filtrado de un total de _MAX_ registros)", 
                            "sSearch": "Buscar:", 
                            "oPaginate": { 
                                "sFirst": "Primero", 
                                "sLast":"Último", 
                                "sNext":"Siguiente", 
                                "sPrevious": "Anterior" 
                            }, 
            
                            "oAria": { 
                                "sSortAscending": ": Activar para ordenar la columna de manera ascendente", 
                                "sSortDescending": ": Activar para ordenar la columna de manera descendente" 
                            }, 
            
                            "sProcessing":"Cargando..." 
                        },
                        "processing": true,
                        serverSide: false,
                    });
            });

            

        </script>
    @endpush
@endonce