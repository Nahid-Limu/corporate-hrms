<option value="all">All Designations</option>
@foreach($designation as $d)
    <option value="{{$d->id}}">{{$d->designation_name}}</option>
@endforeach
