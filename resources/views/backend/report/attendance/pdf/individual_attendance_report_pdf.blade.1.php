<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Individual Attendance Report</title>
    <style>
        *{
            margin:0;
            padding: 0;
        }

        .wrapper{
            width:95%;
            margin:0 auto;
            padding: 20px 0px;
            margin-top:20px;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .header_title{
            width:100%;
            text-align: center;
        }
        .header_info{
            width: 96%;
            padding: 15px 2%;
            margin:0 auto;
            content: "";
            display: table;
        }
        .header_info_left{
            width:55%;
            float:left;
        }
        .header_info_right{
            width:45%;
            float:left;
        }
        .left_col_1{
            width:40%;
            float: left;
        }
        .left_col_2{
            width:60%;
            float: left;
        }
        .main_body{
            width:100%;
            margin-top:30px;
        }
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
    <div class="header_title">
        <h2>Far-East IT Solutions.</h2>
        <p>Uttora, Dhaka</p>
        <p>4th-Floor </p>
        <h4>Payslip For The Period o Feb-2019</h4>

    </div>
    <div class="clearfix"></div>
    <div class="header_info">
        <div class="header_info_left">
            <p> <span class="left_col_1">Employee Id</span> <span class="left_col_2"> : 01</span> </p>
            <p> <span class="left_col_1">Joining Date:</span> <span class="left_col_2"> : 01</span> </p>

        </div>
        <div class="header_info_right">
            <p> <span class="left_col_1">Employee Id</span> <span class="left_col_2"> : 01</span> </p>
            <p> <span class="left_col_1">Employee Id</span> <span class="left_col_2"> : 01</span> </p>
        
        </div>
    </div>
    <div class="clearfix"></div>
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
    <div class="clearfix"></div>
    <div class="footer_signture">

    </div>
</div>

</body>
</html>