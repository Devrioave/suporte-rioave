@extends('layouts.app')

@section('title', 'Controle de Chamados - Rio Ave')

@section('content')
<div class="max-w-7xl mx-auto">
    @include('admin.partials.page-header')

    @php
        $currentSort = request('sort', 'created_at');
        $currentDirection = request('direction', 'desc');
    @endphp

    @include('admin.partials.filters')
    @include('admin.partials.table')
</div>

@include('admin.partials.modal')
@include('admin.partials.scripts')
@endsection
