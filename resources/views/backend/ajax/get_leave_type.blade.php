<option value="">-- Select Branch --</option>
    @foreach($leave_type as $lt)
        <option value="{{$lt->id}}">{{$lt->leave_type}}</option>
    @endforeach