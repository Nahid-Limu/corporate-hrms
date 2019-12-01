<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Date Wise Leave Report</title>
    <style type="text/css">
        *{
            padding: 0;
            margin: 0;
        }
        @page { sheet-size: A4; }
        .table2{
            border-collapse: collapse;
            width: 100%;

        }
        .table1{
            margin-bottom: 30px;
        }
        table, td, th {

        }

        .table2,.table2 td,.table2 th{
            border: 1px solid #1b1d1d;
        }


        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            height:35px;
        }

        .table2 td{
            font-size: 12px;
            padding: 8px 5px;
        }
        .table2 th{
            font-size: 11px;
            padding: 3px 1px;
        }
        .table1{
            text-align: left;
            width: 100%;
            margin-top:20px;
            margin-bottom: 15px;
        }

        .wrapper{
            padding: 30px 45px;
        }
        .heading_style h4{
            font-size: 23px;
        }
        .heading_style h6{
            font-size: 20px;
        }
        .heading_style p{
            font-size: 14px;
        }
        .table1 tr td hr{
            border:1px solid #ccc;
            margin-top:15px;
        }
        @page{
            margin-top: 30px;
        }
    </style>

</head>
<body>
<div class="wrapper">
    <table class="table1">
        <tr style="padding-bottom:-5px;">
            <td width="25%" style="text-align:center;padding-right:5px;">

                <img height="80px" width="100px" src="https://fl-img-media.s3.amazonaws.com/uploads/2017/01/img_logo.png">
            </td>
            <td class="heading_style">
                <h4>{{ $company->company_name}}</h4>
                <p ><b>Factory Address:</b> {{ $company->company_address}}</p>
                <p ><b>Email</b>:{{ $company->company_email}}. <b>Tel:</b>{{ $company->company_phone}}</p>
            </td>
        </tr>
        <tr>
            <td colspan="2"><hr /></td>
        </tr>
    </table>
    <table class="table2 table-bordered"  style="width:100%">
        <thead>
        <tr style="text-align:center;">
            <th>No.</th>
            <th>Name</th>
            <th>Employee ID</th>
            <th>Leave Type</th>
            <th>Leave Taken</th>
            <th>Leave Start</th>
            <th>Leave End</th>
        </tr>
        </thead>
        <tbody>
        @foreach($leave as $key=>$leave_employee)
            <tr>
                <td>{{++$key}}</td>
                <td>{{$leave_employee->emp_first_name}} {{$leave_employee->emp_lastName}}</td>
                <td>{{$leave_employee->employeeId}}</td>
                <td>{{$leave_employee->leave_type}}</td>
                <td>{{$leave_employee->actual_days}}</td>
                <td>{{date('F-d-Y',strtotime($leave_employee->leave_starting_date))}}</td>
                <td>{{date('F-d-Y',strtotime($leave_employee->leave_ending_date))}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<script>
    window.print();
    window.close();
</script>
</body>
</html>
