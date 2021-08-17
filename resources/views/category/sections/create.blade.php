<form action="{{route('admin.category.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div>
        @include('layouts.errors')
        <div class="form-group">
            <div class="row">
                <label>Location</label>
                <select class="form-control m-1" name="location">
                    <option value="" selected hidden>No Location Available</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label>Category</label>
                <input type="text" name="name" class="form-control m-1"
                       placeholder="Category Name" value="{{old('name')}}">
                <input type="text" name="product" class="form-control m-1"
                       placeholder="Product Count" value="{{old('product')}}">
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label>Category options
                    <small>(if do not select, this will be as a parent category)</small>
                </label>
                <select class="form-control m-1" name="parent">
                    <option value="0" selected hidden>Select Parent Category</option>
                    @foreach($parents as $parent)
                        <option value="{{$parent['id']}}">{{$parent['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label>UI options</label>
                <input type="text" name="icon" class="form-control m-1" value="{{old('icon')}}"
                       placeholder="Icon Name(Example: Font Awesome fa-pen)">
                <input type="text" name="color" class="form-control m-1" value="{{old('color')}}"
                       placeholder="Color code(Example: #121212 or 121212)">
                <input type="file" name="file" class="form-control m-1"
                       placeholder="Select background image">
            </div>
        </div>
    </div>
    <button class="mt-4 btn btn-primary float-right">Create</button>
</form>
