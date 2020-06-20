@extends('layouts.header_footer')

@section('title')
    CRUD'ы
@endsection

@section('content')
    <h1>Домашняя страница</h1>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            background-color: #d1d1d1
        }
        #mute {
            position: absolute;
        }
        #mute.on {
            opacity: 0.7;
            z-index: 1000;
            background: white;
            height: 100%;
            width: 100%;
        }
    </style>
    <div id="mute"></div>
    <div id="app"></div>
    <script src="../../js/app.js"></script>
@endsection




