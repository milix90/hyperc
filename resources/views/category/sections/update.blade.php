<form action="{{route('admin.category.update',[$category['id']])}}" method="post" enctype="multipart/form-data">
    @csrf
    @method("PATCH")
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
                       placeholder="Category Name" value="{{$category['name']}}">
                <input type="text" name="product" class="form-control m-1"
                       placeholder="Product Count" value="{{$category['product']}}">
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label>Category options</label>
                <select class="form-control m-1" name="web_priority">
                    <option value="{{$category['web_priority']}}" selected hidden>Change web priority with:</option>
                    @foreach($priorities as $priority)
                        <option value="{{$priority['web_priority']}}">
                            {{$priority['name']}} ({{$priority['web_priority']}})
                        </option>
                    @endforeach
                </select>
                <select class="form-control m-1" name="app_priority">
                    <option value="{{$category['app_priority']}}" selected hidden>Change app priority with:</option>
                    @foreach($priorities as $priority)
                        <option value="{{$priority['app_priority']}}">
                            {{$priority['name']}} ({{$priority['app_priority']}})
                        </option>
                    @endforeach
                </select>
                @if($category['parent'] !== 0)
                    <select class="form-control m-1" name="parent">
                        <option value="{{$category['parent']}}" selected hidden>Change parent category</option>
                        @foreach($parents as $parent)
                            <option value="{{$parent['id']}}">{{$parent['name']}}</option>
                        @endforeach
                    </select>
                @else
                    <input type="hidden" name="parent" value="{{$category['parent']}}">
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label>UI options</label>
                <input type="text" name="icon" class="form-control m-1" value="{{$category['ui']['icon']}}"
                       placeholder="Icon Name(Example: Font Awesome fa-pen)">
                <input type="text" name="color" class="form-control m-1" value="{{$category['ui']['color']}}"
                       placeholder="Color code(Example: #121212 or 121212)">
                <input type="file" name="file" class="form-control m-1"
                       placeholder="Select background image">
            </div>
        </div>
    </div>
    <button class="mt-4 btn btn-primary float-right">Update</button>
</form>
