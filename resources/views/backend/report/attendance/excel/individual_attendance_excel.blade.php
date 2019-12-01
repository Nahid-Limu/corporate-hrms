<?php
$total_leave=0;
$total_present=0;
$total_absent=0;
$total_late=0;
?>

        <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Individual Attendance Report</title>
</head>
<body>

<div class="information">
    <table>
        <tbody>
        <tr><td></td><td colspan="5"><h2><b>{{$company->company_name}}</b></h2></td></tr>
        <tr><td></td><td colspan="5"><b>{{$company->company_address}}</b></td></tr>
        <tr><td></td><td colspan="5"><b>{{$company->company_email}}</b></td></tr>
        <tr><td></td><td colspan="5"><b>{{$company->company_phone}}</b></td></tr>
        <tr><td></td><td colspan="5">Absent Report For<b>{{\Carbon\Carbon::parse($request->date)->format('d M Y')}} </b></td></tr>

        </tbody>
    </table>
</div>


<br/>

<div class="invoice">
    <table>

        <tbody>

        <tr>
            <td>Name:</td>
            <td colspan="2">{{$employee->full_name}}</td>

            <td>Employee ID</td>
            <td>{{$employee->employeeId}}</td>

        </tr>
        <tr>
            <td>Branch:</td>
            <td colspan="2">{{$employee->branch_name}}</td>

            <td>Designation:</td>
            <td>{{$employee->designation_name}}</td>

        </tr>

        </tbody>
    </table>

</div>

<div class="main_body">
    <table>
        <thead>
        <tr>
            <th>Date</th>
            <th>Day</th>
            <th>Entry Time</th>
            <th>Exit Time</th>
            <th>Status</th>
        </tr>
        </thead>

        <tbody>

        @for($i=$request->date;$i<=$request->end_date;$i=\Carbon\Carbon::parse($i)->addDay())
            <?php
            $check_leave=0;
            $check_weekend=0;
            $check_holiday=0;
            $check_present=0;
            $day=\Carbon\Carbon::parse($i)->format('l');
            $leave=\Illuminate\Support\Facades\DB::table('tb_employee')
                ->join('tb_leave_application', 'tb_employee.id', '=', 'tb_leave_application.emp_id')
                ->where('tb_employee.emp_account_status','=',1)
                ->where('tb_leave_application.status','=',1)
                ->where("tb_leave_application.leave_starting_date",'<=',$i)
                ->where("tb_leave_application.leave_ending_date",'>=',$i)
                ->where('tb_employee.id','=',$request->emp_id)->first();

            if(isset($leave->id)){
                $check_leave=1;
            }
            if($check_leave!=1){
                $week_leave=\Illuminate\Support\Facades\DB::table('tb_week_leave')->where('day','=',\Illuminate\Support\Facades\DB::raw("'$day'"))->where('status','=',1)->first();
                if(isset($week_leave->id)){
                    $check_weekend=1;
                }

            }

            if($check_leave!=1 && $check_weekend!=1){
                $holiday=\Illuminate\Support\Facades\DB::table('tb_festival_leave')->where('start_date','>=',$i)
                    ->where('end_date','<=',$i)->first();
                if(isset($holiday->id)){
                    $check_holiday=1;

                }
            }


            $att=\Illuminate\Support\Facades\DB::table('tb_employee')
                ->leftJoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
                ->join('tb_attendance','tb_employee.id','=','tb_attendance.emp_id')
                ->where('emp_id','=',$request->emp_id)
                ->where('attendance_date','=',$i)
                ->select('tb_attendance.id','tb_attendance.in_time','tb_attendance.out_time',
                    'tb_shift.entry_time','tb_shift.exit_time')
                ->first();
            if(isset($att->id)){
                $check_present=1;
            }



            ?>
            <tr>
                <td>{{\Carbon\Carbon::parse($i)->format('d M Y')}}</td>
                <td>{{$day}}</td>
                <td>
                    @if(isset($att->in_time))
                        {{$att->in_time}}
                    @endif
                </td>
                <td>
                    @if(isset($att->out_time))
                        {{$att->out_time}}
                    @endif
                </td>
                <td>
                    @if($check_leave==1)
                        <span style="color: blue">On Leave</span>
                        <?php $total_leave++; ?>
                    @elseif($check_holiday==1)
                        <span style="color: #0b97c4">Holiday</span>

                    @elseif($check_present==1)
                        @if($att->in_time>$att->entry_time)
                            <span style="color: ">Late</span>
                            <?php $total_late++; ?>
                        @else
                            <span style="color: green">Present</span>
                            <?php $total_present++; ?>
                        @endif
                    @elseif($check_weekend==1)
                        <span style="color: #0c5460">Weekend</span>
                    @else
                        <span style="color: red">Absent</span>
                        <?php $total_absent++; ?>
                    @endif
                </td>

            </tr>
        @endfor
        </tbody>

    </table>
    <br><br>

    <table>

        <tbody>

        <tr>
            <td>Total Present:</td>
            <td colspan="2">{{$total_present+$total_late}}</td>

            <td>Total Late</td>
            <td>{{$total_late}}</td>

        </tr>
        <tr>
            <td>Total Leave:</td>
            <td colspan="2">{{$total_leave}}</td>

            <td>Total Absent:</td>
            <td>{{$total_absent}}</td>

        </tr>

        </tbody>
    </table>


    <br><br>
</div>
</body>
</html>