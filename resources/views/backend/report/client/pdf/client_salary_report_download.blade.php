<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - #123</title>

    <style type="text/css">
        @page {
            margin: 0px;
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
            font-size: x-small;
        }
        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }
        .invoice table {
          
        }
        .invoice h3 {
            
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
            font-size: 16px;
            font-weight: 600;
            margin-top: 2px!important;
            margin-bottom: 2px!important;
            display: block;
        } 
        .tr_td_p td span{
          display: inline-block;
        }
    </style>

</head>
<body>

<div class="information">
    <table width="100%">
        <tr>
            <td align="center" style="width: 100%;">
                    <h2>Far-East IT Solutions.</h2>
                    <p>Uttora, Dhaka</p>
                    <p>4th-Floor </p>
                    <h4>Payslip For The Period o Feb-2019</h4>
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
                
                <p style="padding-left:30%;"> <span style="width:40%;">Employee Id 3</span> <span style="width:60%;">: 03</span></p> 
                <p style="padding-left:30%;"> <span style="width:40%;">Employee Id 3</span> <span style="width:60%;">: 03</span></p>  
                <p style="padding-left:30%;"> <span style="width:40%;">Employee Id 3</span> <span style="width:60%;">: 03</span></p>  
                
            </td>
            <td align="left" style="width: 40%">
                <p style="padding-left:30%;"> <span style="width:40%;">Employee Id 3</span> <span style="width:60%;">: 03</span></p>
                <p style="padding-left:30%;"> <span style="width:40%;">Employee Id 3</span> <span style="width:60%;">: 03</span></p> 
                <p style="padding-left:30%;"> <span style="width:40%;">Employee Id 3</span> <span style="width:60%;">: 03</span></p> 
                
            </td>
        </tr>
        
        </tbody>
    </table>
    {{-- <table width="50%">
       
        <tbody>
        <tr>
            <td align="left" style="width: 50%;">
                <p>Employee Id</p>  
            </td>
            <td align="left" style="width: 50%">: 01</td>
        </tr>
        <tr>
            <td align="left" style="width: 50%;">
                <p>Employee Id</p>  
            </td>
            <td align="left" style="width: 50%">: 01</td>
        </tr>
        
        </tbody>
    </table> --}}
</div>

    <div class="main_body">
        <table class="table2 table-bordered"  style="width:100%">
            <thead>
            <tr style="text-align:center;">
                <th>No.</th>
                <th>Name</th>
                <th>Employee ID</th>
                <th>Branch</th>
                <th>Department</th>
                <th>Status</th>
            </tr>
            </thead>

            <tbody>


                <tr>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>
                        <span style='font-weight: bold; color: red'>Absent</span>
                    </td>

                </tr> <tr>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>
                        <span style='font-weight: bold; color: red'>Absent</span>
                    </td>

                </tr> <tr>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>
                        <span style='font-weight: bold; color: red'>Absent</span>
                    </td>

                </tr> <tr>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>
                        <span style='font-weight: bold; color: red'>Absent</span>
                    </td>

                </tr> <tr>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>
                        <span style='font-weight: bold; color: red'>Absent</span>
                    </td>

                </tr>
            </tbody>

        </table>
    </div>

{{-- <div class="information" style="position: absolute; bottom: 0;">
    <table width="100%">
        <tr>
            <td align="left" style="width: 50%;">
                &copy; {{ date('Y') }} {{ config('app.url') }} - All rights reserved.
            </td>
            <td align="right" style="width: 50%;">
                Company Slogan
            </td>
        </tr>

    </table>
</div> --}}
</body>
</html>