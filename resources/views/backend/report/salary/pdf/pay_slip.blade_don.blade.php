<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payslip</title>
    <style>
        *{
            margin:0;
            padding: 0;
        }
        
        .wrapper{
            width:96%;
            border:1px solid #ccc;
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
            width: 90%;
            padding: 15px 5%;
        }
        .header_info_left{
            width:50%;
            float:left;
        }
        .header_info_right{
            width:50%;
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
        .main_body_left{
            width:50%;
            float:left;
        }
        .main_body_right{
            width:50%;
            float:left;
        }
        .main_body_left table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        
        .main_body_left td{
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            border-right: 0px;
            border-left: 0px;
        }
        .main_body_left th {
            border: 1px solid #dddddd;
            border-right: 0px;
            text-align: left;
            padding: 8px;
            border-left: 0px;
        }
        
    
        .main_body_right th{
            border-left:0px;
        }
        .main_body_right table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        
        .main_body_right td, .main_body_right th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
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
            <div class="main_body_left">
                <table>
                    <tr>
                        <th>Earnings</th>
                        <th>YTD</th>
                        <th>Amount</th>
                    </tr>
                    <tr>
                        <td>Alfreds Futterkiste</td>
                        <td>Maria Anders</td>
                        <td>Germany</td>
                    </tr>
                    <tr>
                        <td>Centro comercial Moctezuma</td>
                        <td>Francisco Chang</td>
                        <td>Mexico</td>
                    </tr>
                    <tr>
                        <td>Ernst Handel</td>
                        <td>Roland Mendel</td>
                        <td>Austria</td>
                    </tr>
                    <tr>
                        <td>Island Trading</td>
                        <td>Helen Bennett</td>
                        <td>UK</td>
                    </tr>
                    <tr>
                        <td>Laughing Bacchus Winecellars</td>
                        <td>Yoshi Tannamuri</td>
                        <td>Canada</td>
                    </tr>
                    <tr>
                        <td>Magazzini Alimentari Riuniti</td>
                        <td>Giovanni Rovelli</td>
                        <td>Italy</td>
                    </tr>
                </table>
            </div>
            <div class="main_body_right">
                <table>
                    <tr>
                        <th>Company</th>
                        <th>Contact</th>
                        <th>Country</th>
                    </tr>
                    <tr>
                        <td>Alfreds Futterkiste</td>
                        <td>Maria Anders</td>
                        <td>Germany</td>
                    </tr>
                    <tr>
                        <td>Centro comercial Moctezuma</td>
                        <td>Francisco Chang</td>
                        <td>Mexico</td>
                    </tr>
                    <tr>
                        <td>Ernst Handel</td>
                        <td>Roland Mendel</td>
                        <td>Austria</td>
                    </tr>
                    <tr>
                        <td>Island Trading</td>
                        <td>Helen Bennett</td>
                        <td>UK</td>
                    </tr>
                    <tr>
                        <td>Laughing Bacchus Winecellars</td>
                        <td>Yoshi Tannamuri</td>
                        <td>Canada</td>
                    </tr>
                    <tr>
                        <td>Magazzini Alimentari Riuniti</td>
                        <td>Giovanni Rovelli</td>
                        <td>Italy</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="footer_signture">

        </div>
    </div>

</body>
</html>