@extends('../layouts/' . $layout)
@section('subhead')
    <title>Reportes</title>
@endsection
@section('subcontent')
<!-- BEGIN: Profile Info -->
<div class="intro-y box mt-5 px-5 pt-5">
    <div class="-mx-5 flex flex-col border-b border-slate-200/60 pb-5 dark:border-darkmode-400 lg:flex-row">
        <div class="flex flex-1 items-center justify-center px-5 lg:justify-start">
            <x-base.lucide class="h-40 w-40" icon="file"/>
            <div class="ml-5">
                <div class="w-240 truncate text-lg font-medium sm:w-80 sm:whitespace-normal">                        
                    <h1 class="text-5xl font-medium leading-none"></h1>
                </div>
                <div class="text-slate-500">Pantalla de Reportes</div>
            </div>
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
                        <span class="text-white-700"> Reporte </span>
                    </div></h3>
            </div>
        </div>
        <div class="intro-y col-span-6 lg:col-span-6 text-right">
            <div class="p-5">                                                              
            </div>
        </div>
    </div>
    <div class="scrollbar-hidden overflow-x-auto">
        
        {{$reportName}}        
                
        <a download href="{{ asset($reportName) }}" class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&:hover:not(:disabled)]:bg-opacity-90 [&:hover:not(:disabled)]:border-opacity-90 [&:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed bg-primary border-primary text-white dark:border-primary mb-2 mr-2 w-32 mb-2 mr-2 w-32"><i class="fa fa-file-text">Descargar</i></a>

    </div>
</div>
<!-- BEGIN: Profile body --> 
@endsection
