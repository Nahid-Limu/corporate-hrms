<option value="">-- Select Project --</option>
    @foreach($project as $p)
        <option value="{{$p->id}}">{{$p->project_name}}</option>
    @endforeach