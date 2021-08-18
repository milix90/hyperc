@extends('layouts.app')
@section('title',$title)
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">{{$title}}
                        <span class="float-right">
                        <a class="btn btn-sm btn-secondary"
                           href="{{route('admin.category.index')}}">Back to Categories</a>
                    </span>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-left">
                            @include('category.sections.'.$type)
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
