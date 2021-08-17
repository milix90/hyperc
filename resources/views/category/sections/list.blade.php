<tr>
    <th>{{$category->parent == 0 ? '-' : '---'}}</th>
    <td>{{$category->parent == 0 ? 'parent' : 'child'}}</td>
    <td>
        web: {{$category->web_priority}}<br>
        app: {{$category->app_priority}}
    </td>
    <td>{{$category->latitude === null ? '--' : $category->latitude}}</td>
    <td>{{$category->name}}</td>
    <td>{{$category->product}}</td>
    <td>
        @foreach($category->ui as $ui => $item)
            <strong>{{$ui}}:</strong> {{$item}}<br>
        @endforeach
    </td>
    <td>
        <a class="btn btn-sm btn-primary pl-3 pr-3"
           href="{{route('admin.category.edit',[$category->id])}}">Edit</a>
        <form action="{{route('admin.category.destroy',$category->id)}}" method="post">
            @csrf
            @method("DELETE")
            <button class="btn btn-sm btn-danger pl-3 pr-3">Delete</button>
        </form>
    </td>
</tr>
