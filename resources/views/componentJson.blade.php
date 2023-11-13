<ul data-dynamic="true">
    @foreach ($data as $key => $value)
    <li class="list-group-item">
        <div>
            <button type="button" class="fa fa-plus">Add</button>
            <button type="button" class="fa fa-remove">Delete</button>
            <input type="text" name="{{ 'keys' . $name . '[' . $key . ']' }}" value="{{ $key }}"
                placeholder="index_name">

            @if (is_array($value))
            @component('componentJson', ['data' => $value, 'name' => $name . '[' . $key . ']','level_key'=>$level_key])
            @endcomponent
            @else
            <input type="text" id="test" class="test" name="{{ 'values' . $name . '[' . $key . ']' }}"
                value="{{ $value }}" placeholder="index_value">

            @endif

        </div>
    </li>
    @endforeach
</ul>