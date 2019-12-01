<option value="">-- Select Department --</option>
@foreach($department as $dept)
    <option value="{{$dept->id}}"> {{$dept->department_name}}</option>
@endforeach
