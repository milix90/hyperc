@extends('layouts.app')
@section('title','Admin dashboard')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        <div class="d-flex justify-content-left">
                            @foreach($links as $link => $name)
                                <a class="btn btn-primary m-2"
                                   target="{{str_contains($link,'api') ? '_blank': '_self'}}"
                                   href="{{route($link)}}">{{$name}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
