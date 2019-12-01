<option value="">-- Select Branch --</option>
    @foreach($branch as $b)
        <option value="{{$b->id}}">{{$b->branch_name}}</option>
    @endforeach