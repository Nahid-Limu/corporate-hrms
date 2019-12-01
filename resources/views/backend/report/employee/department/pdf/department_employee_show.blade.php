<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Department Wise Employee List</title>
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
    <p>Employee List of Department</p>
    <p>{{$department->department_name}}</p>
    <h1>{{ $company->company_name}}</h1>
	<p>{{ $company->company_phone}}</p>
	<p>{{ $company->company_email}}</p>
	<p>{{ $company->company_address}}</p>
	</div>
<table style="width:100%">
      <tr>
                <th>Employee Id</th>
			    <th>First Name</th>
                <th>Last Name</th>
                <th>Department</th>
                <th>Designation</th>
            </tr>
            @foreach($employee as $employees)
                <tr>
                    <td>{{$employees->employeeId}}</td>
                    <td>{{$employees->emp_first_name}}</td>
                    <td>{{$employees->emp_lastName}}</td>
                    <td>{{$employees->department_name}}</td>
                    <td>{{$employees->designation_name}}</td>
                </tr>
            @endforeach
</table>
</body>
</html>
