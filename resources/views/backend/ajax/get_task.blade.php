<option value="">-- Select Task --</option>
    @foreach($task as $t)
        <option value="{{$t->id}}">{{$t->title}}</option>
    @endforeach