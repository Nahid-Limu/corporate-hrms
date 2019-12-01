<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Branch Wise Client List</title>
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
   <p>Client List</p>
 <h1>{{ $company->company_name}}</h1>   
	<p>{{ $company->company_phone}}</p>
	<p>{{ $company->company_email}}</p>
	<p>{{ $company->company_address}}</p>
	</div>
<table style="width:100%" class="table-bordered">
     <tr>
                <th>Client</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
            </tr>
    @foreach($client as $clients)
                <tr>
                    <td>{{$clients->client_name}}</td>
                    <td>{{$clients->client_phone}}</td>
                    <td>{{$clients->client_email}}</td>
                    <td>{{$clients->client_address}}</td>
                </tr>
            @endforeach
</table>
</body>

</html>