<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Meeting Details</title>
<style>
table, td, th {
  border: 1px solid black;
}
table {
  border-collapse: collapse;
  width: 100%;
}
th {
  height: 50px;
}
</style>
</head>
<body>
<div style="text-align:center">
   <p>Meeting Details</p>
 <h1>{{ $company->company_name}}</h1>   
	<p>{{ $company->company_phone}}</p>
	<p>{{ $company->company_email}}</p>
	<p>{{ $company->company_address}}</p>
	</div>
	
<table style="width:100%" class="table-bordered">
                <tr>
                 <th>Subject</th>
                 <th>Start Time</th>
                 <th>End Time</th>
                 <th>Venue</th>
                 <th>Description</th>
                 <th>Date</th>
                 </tr>
                 <tr>
                   <td>{{$meeting->meeting_subject}}</td>
                   <td>{{date('H:i:a',strtotime($meeting->start_time))}}</td>
                   <td>{{date('H:i:a',strtotime($meeting->end_time))}}</td>
                   <td>{{$meeting->venue}}</td>
                  <td>{{$meeting->description}}</td>
                  <td>{{date('F-d-Y',strtotime($meeting->meeting_date))}}</td>
                </tr>
        </table>
		
		
	<p>Assign Member</p>
	<table style="width:100%" class="table-bordered">
                <tr>
                 <th>Employee Id</th>
                 <th>Name</th>
                 </tr>
			    @foreach( $assign_member as  $assign_members)
                 <tr>
                   <td>{{$assign_members->employeeId}}</td>
                   <td>{{$assign_members->emp_first_name}} {{$assign_members->emp_lastName}}</td>
                </tr>
				@endforeach
        </table>	
		
		
</body>
</html>