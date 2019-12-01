<option value="">-- Select Employee --</option>
@foreach($employee as $e)
    <option value="{{$e->id}}">{{$e->name}} ({{$e->employeeId}})</option>
@endforeach