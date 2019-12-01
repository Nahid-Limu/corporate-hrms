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

    <style type="text/css">
        @page {
            margin-bottom: 30px;
            margin-top: 30px;
        }
        body {
            margin: 0px;
        }
        * {
            font-family: Verdana, Arial, sans-serif;
            margin:0;
            padding: 0;
        }
        a {
            color: #fff;
            text-decoration: none;
        }
        table {

        }
        tfoot tr td {
            font-weight: bold;

        }
        .invoice table {
          
        }
        .invoice h3 {
            
        }
        .information p b{
            font-weight: 500;

        }
        .information {
          
        }
        .information .logo {
            margin: 5px;
        }
        .information table {
            padding: 10px;
        }
        .tr_td_p td p{
            font-size: 14px;
            font-weight: 400;
            margin-top: 2px!important;
            margin-bottom: 2px!important;
            display: block;
        } 
        .tr_td_p td span{
          display: inline-block;

        }
        .main_body{
          margin-top:20px;
          width:90%;
          margin-left:5%;
          margin-right:5%; 
        }
        .table2{
          border-collapse: collapse;
          width: 100%;

        }
        .table2,.table2 td,.table2 th{
          border: 1px solid #1b1d1d;
        }
        .table2 td{
          font-size: 12px;
          padding: 8px 5px;
        }
        .table2 th{
            font-size: 11px;
            padding: 3px 1px;
        }

        @media print{
            .tr_td_p td span{
               float:left;

            }

        }

    </style>

</head>
<body>

<div class="information">
    <table width="100%">
        <tr>
            <td align="center" style="width: 100%;">
                <h3>{{ $company->company_name}}</h3>
                <p >{{ $company->company_address}}</p>
                <p ><b>Email</b>:{{ $company->company_email}}. <b>Tel:</b>{{ $company->company_phone}}</p>
            </td> 
        </tr>

    </table>
</div>


<br/>

<div class="invoice">
    <table width="100%">
       
        <tbody>
        
        <tr  style="width: 80%; margin-left:10%;" class="tr_td_p">
            <td align="left" style="width: 40%; margin-left:10%;">
                
                <p style="padding-left:30%;"> <span style="width:40%;">Name</span> <span style="width:60%;">: {{$employee->full_name}}</span></p>
                <p style="padding-left:30%;"> <span style="width:40%;">Employee ID</span> <span style="width:60%;">: {{$employee->employeeId}}</span></p>
{{--                <p style="padding-left:30%;"> <span style="width:40%;">Employee Id 3</span> <span style="width:60%;">: 03</span></p>  --}}
                
            </td>
            <td align="left" style="width: 40%">
                <p style="padding-left:30%;"> <span style="width:40%;">Branch</span> <span style="width:60%;">: {{$employee->branch_name}}</span></p>
                <p style="padding-left:30%;"> <span style="width:40%;">Designation</span> <span style="width:60%;">: {{$employee->designation_name}}</span></p>
{{--                <p style="padding-left:30%;"> <span style="width:40%;">Employee Id 3</span> <span style="width:60%;">: 03</span></p> --}}
                
            </td>
        </tr>
        
        </tbody>
    </table>
  
</div>

    <div class="main_body">
        <table class="table2 table-bordered"  style="width:100%">
            <thead>
            <tr style="text-align:center;">
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

        <div class="invoice">
            <table width="100%">

                <tbody>

                <tr  style="width: 80%; margin-left:10%;" class="tr_td_p">
                    <td align="left" style="width: 40%; margin-left:10%;">

                        <p style="padding-left:30%;"> <span style="width:40%;">Total Present</span> <span style="width:60%;">: {{$total_present+$total_late}}</span></p>
                        <p style="padding-left:30%;"> <span style="width:40%;">Total Late</span> <span style="width:60%;">: {{$total_late}}</span></p>
                        {{--                <p style="padding-left:30%;"> <span style="width:40%;">Employee Id 3</span> <span style="width:60%;">: 03</span></p>  --}}

                    </td>
                    <td align="left" style="width: 40%">
                        <p style="padding-left:30%;"> <span style="width:40%;">Total Leave</span> <span style="width:60%;">: {{$total_leave}}</span></p>
                        <p style="padding-left:30%;"> <span style="width:40%;">Total Absent</span> <span style="width:60%;">: {{$total_absent}}</span></p>
                        {{--                <p style="padding-left:30%;"> <span style="width:40%;">Employee Id 3</span> <span style="width:60%;">: 03</span></p> --}}

                    </td>
                </tr>

                </tbody>
            </table>

        </div>
        <br><br>
    </div>
<script>

    window.print();
    window.close();
</script>

</body>
</html>