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
                <h6 style="margin-top:10px;font-size:16px;">Client Project List of Branch</h6>
            </td>
        </tr>

        <tr>
          <td colspan="2"><hr /></td>
        </tr>
      </table>
        
      <table class="table2 table-bordered"  style="width:100%" >
          <tr style="text-align:center;">
            <th>Project Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Deadline</th>
            <th>Client</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
          </tr>

          @foreach($client_project as $project)

            <tr>
              <td>{{$project->project_name}}</td>
              <td>{{date('F-d-Y',strtotime($project->start_date))}}</td>
              <td>{{date('F-d-Y',strtotime($project->end_date))}}</td>
              <td>
                @if(date('Y-m-d')>$project->end_date)
                  Deadline Over
                  @else
                  {{$project->days}} Days
                @endif
              </td>
              <td>{{$project->client_name}}</td>
              <td>{{$project->client_phone}}</td>
              <td>{{$project->client_email}}</td>
              <td>{{$project->client_address}}</td>
            </tr>
          @endforeach
        
      </table>
  </div>
  
</body>
</html>