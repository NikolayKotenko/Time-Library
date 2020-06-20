@extends('layouts.header_footer')

@section('title')
    To-do-diary
@endsection

@section('content')
    <h1>Домашняя страница</h1>

    <div class="panel-heading">Companies</div>

    <div class="panel-body table-responsive">
        <router-view name="MyThingsIndex"></router-view>
        <router-view></router-view>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Companies</div>

                    <div class="panel-body">
                        Coming soon...
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="app"></div>
    <script src="../js/app.js"></script>
{{-- CRUD'ы --}}
{{--    <style>
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
    <script src="../js/app.js"></script>--}}
@endsection




