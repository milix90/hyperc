@extends('layouts.app')
@section('title','Categories')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Categories
                        <span class="float-right">
                        <a class="btn btn-sm btn-secondary" href="{{route('admin.dashboard')}}">Back to Dashboard</a>
                    </span>
                    </div>

                    <div class="card-body">
                        <div class="float-left">
                            @foreach($results['links'] as $link => $name)
                                <a class="btn btn-primary" href="{{route($link)}}">{{$name}}</a>
                            @endforeach
                        </div>
                        @if(count($results['categories']) > 0)
                        <div class="float-right">
                            <small class="badge badge-warning">
                                (by deleting parent category,sub categories will be deleted.)
                            </small>
                        </div>
                        @endif
                    </div>

                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Type</th>
                                <th scope="col">Priority</th>
                                <th scope="col">Location</th>
                                <th scope="col">Name</th>
                                <th scope="col">Product count</th>
                                <th scope="col">UI options</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($results['categories'] as $category)
                                @include('category.sections.list',['category' => $category])
                                {{--child categories--}}
                                @foreach($category['children'] as $child)
                                    @include('category.sections.list',['category' => $child])
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
