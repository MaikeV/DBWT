@extends('pages.master')

@section('content')
<div class="row">
    <div class="col-4"></div>
    <div class="col-4">
        @include('pages.loginChild')
    </div>
    <div class="col-4"></div>
</div>
@endsection
