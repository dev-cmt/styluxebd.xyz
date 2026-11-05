@extends('frontEnd.' . $theme->path . '.layouts.master')
@section('title')
    About Us
@endsection

@section('content')
    <section id="dynamic-page">
        <div class="container">
            {!! $data->about_us ?? ' ' !!}
        </div>
    </section>
@endsection
