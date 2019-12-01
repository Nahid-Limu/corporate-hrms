@if(count($recent_files)!=0)
    @foreach($recent_files as $f)
        <tr>
            <td>{{$f->title}}</td>
            <td><a href="{{asset('/../attendance_file')."/".$f->attendance_file}}">{{$f->attendance_file}} &nbsp; <i class="fa fa-download"></i> </a></td>
            <td>{{$f->description}}</td>
            {{--                                                                <td>{{$f->description}}</td>--}}
            <td>{{\Carbon\Carbon::parse($f->upload_date)->format('j-M-Y h:i')}}</td>
            <td>
                @if($f->process_status==0)
                    <span style="color:black;" class="label label-sm label-warning">Pending</span>
                @elseif($f->process_status==1)
                    <span class="label label-sm label-success">Processed</span>

                @endif
            </td>
            <td>
                @if($f->process_date!=null)
                    {{\Carbon\Carbon::parse($f->process_date)->format('j-M-Y h:i')}}
                @endif
            </td>

            <td>
                @if($f->process_status==1)

                @else
                    <a target="_blank" href="{{route('attendance_file.process',base64_encode($f->id))}}"><button type="button" class="btn btn-green btn-xs"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;
                            Process
                        </button></a>
                @endif
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td align="center" colspan="7"><span style="font-weight: bold" class="text-danger">No Data Found</span></td>
    </tr>
@endif