@extends('frontEnd.'.$theme->path.'.layouts.master')
@section('title')
    Why Us
@endsection

@section('content')
    <section id="dynamic-page">
        <div class="container">
            {!! $data->why_us !!}
        </div>
    </section>
@endsection
