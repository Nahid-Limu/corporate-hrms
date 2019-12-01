{!! Form::open(['method'=>'POST','action'=>'AttendanceController@manual_attendance_data_store']) !!}
{!! Form::hidden('emp_id',$employee->id) !!}
<div class="col-xs-12">
    <hr>
    <div>
        <table class="table table-bordered table-hover table-striped report-table">
            <thead>
            <tr>
                <th>Date</th>
                <th>Day</th>
                <th>In Time</th>
                <th>Out Time</th>
            </tr>
            </thead>
            <tbody>
            @for($i=$start_date;$i<=$end_date;$i=\Carbon\Carbon::parse($i)->addDay())
                <?php
                $attendance_data=\Illuminate\Support\Facades\DB::table('tb_attendance')
                    ->where('emp_id','=',$employee->id)
                    ->where('attendance_date','=',\Carbon\Carbon::parse($i)->toDateTimeString())
                    ->first();

                ?>

                <tr @if(isset($attendance_data->in_time)) {{ "class=info" }} @endif>
                <tr>
                    <td>{{\Carbon\Carbon::parse($i)->format('j M Y')}}

                    </td>
                    <td>{{\Carbon\Carbon::parse($i)->format('l')}}</td>
                    <td>
                        @if(isset($attendance_data->in_time))
                            {!! Form::time('in_time[]',\Carbon\Carbon::parse($attendance_data->in_time)->format('H:i'),['class'=>'form-control']) !!}
                            {!! Form::hidden('date[]',$i) !!}
                            {!! Form::hidden('update[]',1) !!}
                        @else
                            {!! Form::hidden('date[]',$i) !!}
                            {!! Form::hidden('update[]',0) !!}
                            {!! Form::time('in_time[]',null,['class'=>'form-control']) !!}
                        @endif


                    </td>
                    <td>
                        @if(isset($attendance_data->in_time))
                            {!! Form::time('out_time[]',\Carbon\Carbon::parse($attendance_data->out_time)->format('H:i'),['class'=>'form-control']) !!}
                        @else
                            {!! Form::time('out_time[]',null,['class'=>'form-control']) !!}
                        @endif

                    </td>
                </tr>
            @endfor

            </tbody>
        </table>
    </div>
    <div class="form-group">
        <div class="col-md-9 col-md-offset-3">
            <hr>
            <button style="float: right;" type="submit" class="btn btn-success"><i class="fa fa-list"></i> &nbsp;Add</button>
            {{--<button type="submit" value="Generate PDF" name="viewType" class="btn btn-primary"><i class="fa fa-download"></i> &nbsp;Download as PDF</button>--}}
        </div>
    </div>
</div>
{!! Form::close() !!}