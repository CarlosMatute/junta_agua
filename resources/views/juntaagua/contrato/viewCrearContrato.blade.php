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
</div>
@endsection
@once
    @push('scripts')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite('resources/js/pages/modal/index.js')
    @vite('resources/js/vendor/toastify/index.js')
    @vite('resources/js/pages/notification/index.js')

    @endpush
@endonce
