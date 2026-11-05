@extends('frontEnd.' . $theme->path . '.layouts.master')
@section('title')
    Return & Refund Policy
@endsection

@section('content')
    <section id="dynamic-page">
        <div class="container">
            {!! $data->return_policy ?? ' ' !!}
        </div>
    </section>
@endsection
