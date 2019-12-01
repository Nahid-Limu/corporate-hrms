<option value="">-- Select Grade --</option>
    @foreach($grade as $g)
        <option value="{{$g->id}}">{{$g->grade_name}}</option>
    @endforeach