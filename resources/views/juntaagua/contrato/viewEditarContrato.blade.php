@extends('../layouts/' . $layout)
@section('subhead')
    <title>Contrato | Editar</title>
@endsection

@section('subcontent')

@endsection
@once
    @push('scripts')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite('resources/js/pages/modal/index.js')
    @vite('resources/js/vendor/toastify/index.js')
    @vite('resources/js/pages/notification/index.js')

    @endpush
@endonce
