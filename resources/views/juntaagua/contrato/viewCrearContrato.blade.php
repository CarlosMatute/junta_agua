@extends('../layouts/' . $layout)
@section('subhead')
    <title>Contrato | Crear</title>
@endsection

@section('subcontent')
{{--Encabezado--}}
<div class="px-5 pt-5 mt-5 intro-y box">
    <div class="flex flex-col pb-5 -mx-5 border-b border-slate-200/60 dark:border-darkmode-400 lg:flex-row">
        <div class="flex items-center justify-center flex-1 px-5 lg:justify-start">
                <x-base.lucide
                    class="w-40 h-40"
                    icon="FileText"
                />
            <div class="ml-5">
                <div class="text-lg font-medium truncate w-240 sm:w-80 sm:whitespace-normal">

                    <h1 class="text-5xl font-medium leading-none">CREAR CONTRATO</h1>
                </div>
                <div class="text-slate-500">Pantalla de cración de contratos.</div>
            </div>
        </div>
    </div>
</div>
{{-- Formulario --}}
<div class="p-5 mt-5 intro-y box">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-6 intro-y lg:col-span-6">
            <div class="p-5">
                <h3 class="text-2xl font-medium leading-none">
                    <div class="flex items-center">
                        <x-base.lucide
                            class="w-6 h-6 mr-1"
                            icon="FilePlus"/>
                        <span class="text-white-700"> Formulario</span>
                    </div>
                </h3>
            </div>
        </div>
        <div class="col-span-6 text-right intro-y lg:col-span-6">
            <div class="p-5">
                <a class="bg-danger  text-white font-bold py-2 px-4 rounded" 
                href="{{ Route('ver_contrato') }}">
                    Cancelar
                </a>

            </div>
        </div>
    </div>           
    @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
    @endif
    <form action="{{ route('guardar_contrato') }}" method="POST">
        @csrf
        <div class="grid grid-cols-2 gap-x-4">
            <div class="mb-4">
                <label for="id_cliente" class="block text-gray-700">Cliente</label>
                <x-base.tom-select id="id_cliente" name="id_cliente" class="w-full" >
				<option></option>
				@foreach ($clientes as $cliente)
					<option value="{{$cliente->id}}">{{$cliente->cliente}}</option>
				@endforeach
			</x-base.tom-select>
                @error('id_cliente')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="monto" class="block text-gray-700">Monto</label>
                <input type="number" id="monto" name="monto" class="w-full p-2 border {{ $errors->has('monto') ? 'border-red-500' : 'border-gray-300' }} rounded mt-1" value="{{ old('monto') }}">
                @error('monto')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="id_ubicacion" class="block text-gray-700">Ubicación</label>
                <select id="id_ubicacion" name="id_ubicacion" class="w-full p-2 border {{ $errors->has('id_ubicacion') ? 'border-red-500' : 'border-gray-300' }} rounded mt-1">
                    <option value="">Seleccione una ubicación</option>
                </select>
                @error('id_ubicacion')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="id_servicio" class="block text-gray-700">Servicio</label>
                <select id="id_servicio" name="id_servicio" class="w-full p-2 border {{ $errors->has('id_servicio') ? 'border-red-500' : 'border-gray-300' }} rounded mt-1">
                    <option value="" selected>Seleccione un servicio</option>
                    @foreach($servicios as $servicio)
                        <option value="{{ $servicio->id }}" {{ old('id_servicio') == $servicio->id ? 'selected' : '' }}>
                            {{ $servicio->tipo }} - {{ $servicio->servicio }}
                        </option>
                    @endforeach
                </select>
                @error('id_servicio')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="fecha_inicio" class="block text-gray-700">Fecha de Inicio</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio') }}" class="w-full p-2 border {{ $errors->has('fecha_inicio') ? 'border-red-500' : 'border-gray-300' }} rounded mt-1">
                @error('fecha_inicio')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="fecha_fin" class="block text-gray-700">Fecha de Fin</label>
                <input type="date" id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin') }}" class="w-full p-2 border {{ $errors->has('fecha_fin') ? 'border-red-500' : 'border-gray-300' }} rounded mt-1">
                @error('fecha_fin')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            
        </div>
        <button type="submit" class="w-full bg-primary text-white p-2 rounded mt-4">Enviar</button>
    </form>
    

        


</div>
@endsection
@once
    @push('scripts')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite('resources/js/pages/modal/index.js')
    @vite('resources/js/vendor/toastify/index.js')
    @vite('resources/js/pages/notification/index.js')

    <script type="module">
        $(document).ready(function() {
            $('#id_cliente').on('change', function() {
                var clienteID = $(this).val();
                if (clienteID) {
                    $.ajax({
                        url: '{{ url("/") }}/ubicaciones/' + clienteID,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            console.log(data)
                            $('#id_ubicacion').empty();
                            $('#id_ubicacion').append('<option value="">Seleccione una ubicación</option>');
                            $.each(data, function(key, value) {
                                $('#id_ubicacion').append('<option value="' + value.id + '">' + value.descripcion_casa + '</option>');
                            });
                        }
                    });
                } else {
                    $('#id_ubicacion').empty();
                    $('#id_ubicacion').append('<option value="">Seleccione una ubicación</option>');
                }
            });
        });
    </script>

    @endpush
@endonce
