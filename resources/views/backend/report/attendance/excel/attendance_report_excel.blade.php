<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daily Attendance Report</title>
</head>
<body>

<div>
    <table>
        <tbody>
        <tr><td></td><td colspan="5" style="text-align: center"><h2><b>{{$company->company_name}}</b></h2></td></tr>
        <tr><td></td><td colspan="5" style="text-align: center"><b>{{$company->company_address}}</b></td></tr>
        <tr><td></td><td colspan="5" style="text-align: center"><b>{{$company->company_email}}</b></td></tr>
        <tr><td></td><td colspan="5" style="text-align: center"><b>{{$company->company_phone}}</b></td></tr>
        <tr><td></td><td colspan="5" style="text-align: center" >Daily Attendance Report For<b>{{\Carbon\Carbon::parse($request->date)->format('d M Y')}} </b></td></tr>

        </tbody>
    </table>

    <table style="width:100%">
        <thead>
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Employee ID</th>
            <th>Branch</th>
            <th>Department</th>
            <th>Entry Time</th>
            <th>Out Time</th>
            <th>Status</th>
        </tr>
        </thead>

        <tbody>

        @foreach($all_data as $key=>$ad)

            <tr>
                <td>{{++$key}}</td>
                <td>{{$ad->full_name}}</td>
                <td>{{$ad->employeeId}}</td>
                <td>{{$ad->branch_name}}</td>
                <td>{{$ad->department_name}}</td>
                <td>{{$ad->in_time}}</td>
                <td>{{$ad->out_time}}</td>
                <td>
                    @if($ad->in_time==null)
                        <span style='font-weight: bold; color: red'>Absent</span>


                    @elseif($ad->in_time==='leave')
                        <span style='font-weight: bold; color:royalblue'>On Leave</span>


                    @else
                        @if($ad->in_time>$ad->shift_entry_time)
                            <span style='font-weight: bold; color: blue'>Late</span>
                        @else
                            <span style='font-weight: bold; color: green'>Present</span>
                        @endif

                    @endif
                </td>

            </tr>
        @endforeach
        </tbody>

    </table>
</div>
</body>

</html>