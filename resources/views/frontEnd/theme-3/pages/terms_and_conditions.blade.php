@php
    $activePath = '';
    if ($currentTheme->type == 'active') {
        $activePath = 'active';
    } elseif ($currentTheme->type == 'preview') {
        $activePath = 'preview';
    }
@endphp
@extends('frontEnd.'.$currentTheme->path.'.layouts.master')
@section('title')
    Terms & Conditions
@endsection

@section('content')
    <section id="dynamic-page">
        <div class="container">
            {!! $data->terms_condition !!}
        </div>
    </section>
@endsection
