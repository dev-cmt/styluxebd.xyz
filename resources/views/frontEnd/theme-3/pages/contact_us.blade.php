@extends('frontEnd.'.$theme->path.'.layouts.master')
@section('title')
    Contact Us
@endsection

@section('content')
    <section id="dynamic-page">
        <div class="container">
            {!! $data->contact_us !!}
        </div>
    </section>
@endsection
