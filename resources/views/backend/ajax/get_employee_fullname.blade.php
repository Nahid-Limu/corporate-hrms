<option value="">-- Select Employee --</option>
@foreach($employee as $e)
    <option value="{{$e->id}}">{{$e->full_name}} (#{{$e->employeeId}}) </option>
@endforeach
