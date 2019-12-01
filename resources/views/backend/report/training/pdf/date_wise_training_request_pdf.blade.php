<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Report</title>
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
			padding: 10px 5px;
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
	</style>
</head>
<body>
  <div class="wrapper">
      <table class="table1">
        <tr style="padding-bottom:-5px;">
          <td width="25%" style="text-align:center;padding-right:5px;:">
          
            <img height="80px" width="100px" src="https://fl-img-media.s3.amazonaws.com/uploads/2017/01/img_logo.png">
          </td>
          <td class="heading_style">
            <h4>{{ $company->company_name}}</h4>
            <h6>{{$branch->branch_name}}</h6>
            <p ><b>Factory Address:</b> {{ $company->company_address}}</p>
            <p ><b>Email</b>:{{ $company->company_email}}. <b>Tel:</b>{{ $company->company_phone}}</p>
          </td>
        </tr>
        <tr style="text-align:center;">
            <td style="text-align:center;" colspan="2">
                <h6 style="margin-top:10px;font-size:16px;">Training List of Branch</h6>
            </td>
        </tr>
        <tr>
          <td colspan="2"><hr /></td>
        </tr>
      </table>
      <table class="table2 table-bordered"  style="width:100%" >
          <tr style="text-align:center;">
                   <th>Employee Id</th>
                 <th>Employee</th>
                 <th>Training</th>
                 <th>Branch</th>
                 <th>Duration</th>
                 <th>Start Date</th>
                 <th>End Date</th>
                 <th>Institution</th>
                 <th>Month</th>
                 <th>Status</th>
          </tr>
           @foreach($training as $trainings)
                <tr>
                    <td>{{$trainings->employeeId}}</td>
                    <td>{{$trainings->emp_first_name}} {{$trainings->emp_lastName}}</td>
                    <td>{{$trainings->training_name}}</td>
                    <td>{{$trainings->branch_name}}</td>
                    <td>{{$trainings->duration}} days</td>
                    <td>{{date('F-d-Y',strtotime($trainings->training_start))}}</td>
                    <td>{{date('F-d-Y',strtotime($trainings->training_end))}}</td>
                    <td>{{$trainings->training_institution}}</td>
                    <td>{{date('F-d-Y',strtotime($trainings->training_month))}}</td>
                    <td>
                        @if($trainings->request_status==1) Approved
                         @else Calcel
                         @endif
                        </td>
                   </tr>
            @endforeach
      </table>
  </div>
</body>
</html>