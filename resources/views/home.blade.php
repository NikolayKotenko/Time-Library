@extends('layouts.app')

@section('content')

@if (session('status'))
    You are logged in!

@endif
<div id="app" class="container">
    <router-view></router-view>
</div>
@endsection
