@extends('frontEnd.'.$theme->path.'.layouts.master')
@section('title')
    How to order
@endsection

@section('content')
    <section id="dynamic-page">
        <div class="container">
            {!! $data->how_to_order !!}
        </div>
    </section>
@endsection
