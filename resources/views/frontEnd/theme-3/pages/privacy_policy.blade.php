@extends('frontEnd.'.$theme->path.'.layouts.master')
@section('title')
    Privacy Policy
@endsection

@section('content')
    <section id="dynamic-page">
        <div class="container">
            {!! $data->privacy_policy !!}
        </div>
    </section>
@endsection
