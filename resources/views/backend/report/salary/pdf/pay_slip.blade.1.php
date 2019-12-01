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
            position: relative;
        }
        .logo_part{
            position: absolute;
            top: 10px;
            right: 6%;
            width: 127px;
            height: 40px;
        }
        .logo_part img{
            width: 100%;
            height:100%;
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
            width: 100%;
            margin-top: 30px;
            margin-bottom: 60px;
            content: "";
            display: table;
            overflow: auto;
            border: 1px solid #ccc;
            border-left: 0px;
            border-right: 0px;
            border-bottom: 0px;
        }
        .main_body_left{
            width: 49%;
            float: left;
            border-right: 1px solid #ccc;
        }
        .main_body_right{
            width:50.5%;
            float: left;
        }
        .main_body_head{
            border-bottom: 1px solid #ccc;
            padding-top: 0x;
            padding-bottom: 5px;
        }
        h4 .col-1{
            width:50%;
            float: left;
            padding-bottom: 5px;
            
        }
        h4 .col-2{
            width:25%;
            text-align: right;
            float: left;
            padding-bottom: 5px;
            
        }
        h4 .col-3{
            width:25%;
            text-align: right;
            float: left;
            padding-bottom: 5px;
            
        }
        p .col-1{
            width:50%;
            float: left;
            margin-bottom: 5px;
            margin-top: 5px;
        }
        p .col-2{
            width:25%;
            text-align: right;
            float: left;
            margin-bottom: 5px;
            margin-top: 5px;
        }
        p .col-3{
            width:25%;
            text-align: right;
            float: left;
            margin-bottom: 5px;
            margin-top: 5px;
        }
        .main_body_footer{
            width:100%;
        }
        .main_body_footer_left{
            width: 49%;
            float: left;
            border-right: 1px solid #ccc;
        }
        .main_body_footer_left h4{
            padding: 4px 15px;
        }
        .main_body_footer_right{
            width:50.5%;
            float: left;
        }
        .main_body_footer_right h4{
            padding: 4px 10px;
        }

        .footer_signture{
            width:100%;
        }

        .footer_signture_left{
            width:50%;
            float:left;
            text-align: center;
        }
        .footer_signture_left p{
            display: inline-block;
            border-top:1px solid #000;
            margin-top:5px;
            padding: 4px 20px;
            
        }
        .footer_signture_right{
            width:50%;
            float:right;
            text-align: center;
        }
        .footer_signture_right p{
            display: inline-block;
            border-top:1px solid #000;
            margin-top:5px;
            padding: 4px 20px;
            
        }
        .main_body_right_bottom_border{
            border-bottom: 1px solid #ccc;
        }
        .main_body_content p{
            padding: 5px 15px;
        }
        .main_body_head h4{
            padding: 5px 15px;
        }
        .main_body_footer_1{
            width:100%;
        }
        .main_body_footer_1_left{
            width:60%;
            float: left;
            text-align: right;  
        }
        .main_body_footer_1_right{
            width:40%;
            float: left;
            text-align: right;        }
        }
        .main_body_footer_1_right h4{
            padding-right: 15px;
        }

    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header_title">
            <h2>Far-East IT Solutions.</h2>
            <p>Uttora, Dhaka</p>
            <p>4th-Floor </p>
            <h4>Payslip For The Period of Feb-2019</h4>
            <div class="logo_part">
                <img src="https://staticaltmetric.s3.amazonaws.com/uploads/2015/10/dark-logo-for-site.png" alt="">
            </div>

        </div>
        <div class="clearfix"></div>
        <div class="header_info">
            <div class="header_info_left">
                <p> <span class="left_col_1">Employee Id</span> <span class="left_col_2"> : 01</span> </p>
                <p> <span class="left_col_1">Department</span> <span class="left_col_2"> : IT</span> </p>
                <p> <span class="left_col_1">Date of Joining</span> <span class="left_col_2"> : 03-May-2019</span> </p>
                <p> <span class="left_col_1">ESI Account Number</span> <span class="left_col_2"> : 02</span> </p>
                
            </div>
            <div class="header_info_right">
                <p> <span class="left_col_1">Name</span> <span class="left_col_2"> : Karim</span> </p>
                <p> <span class="left_col_1">Designation </span> <span class="left_col_2"> : Junior Developer </span> </p>
                <p> <span class="left_col_1"> PF Account Number</span> <span class="left_col_2"> : 01823213</span> </p>
                <p> <span class="left_col_1">Fathers/Husbands Name </span> <span class="left_col_2"> : Kabir Khan</span> </p>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="main_body">
            
            <div class="main_body_left">
                <div class="main_body_head">
                    <h4> <span class="col-1">Earning</span> <span class="col-2">YTD</span> <span class="col-3">Amount</span></h4>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <div class="main_body_content">
                        <p><span class="col-1">Basic Pay</span> <span class="col-2">448899.00</span> <span class="col-3">2399.00</span></p>
                        <p><span class="col-1">Dearness Allowance</span> <span class="col-2">4488980.00</span> <span class="col-3">239977.00</span></p>
                        <p><span class="col-1">House Rent Allowance</span> <span class="col-2">4489.00</span> <span class="col-3">2399.00</span></p>
                        <p><span class="col-1">Medical Allowance</span> <span class="col-2">448899.00</span> <span class="col-3">2399.00</span></p>
                </div>
               
            </div>
           
            <div class="main_body_right">
                <div class="main_body_head">
                    <h4> <span class="col-1">Deduction</span> <span class="col-2">YTD</span> <span class="col-3">Amount</span></h4>
                    <div class="clearfix"></div>
                </div>
                <div class="main_body_content">
                        <p><span class="col-1">Basic Pay</span> <span class="col-2">448899.00</span> <span class="col-3">2399.00</span></p>
                </div>
                
            </div>


            <div class="clearfix main_body_right_bottom_border"></div>


            <div class="main_body_footer">
                <div class="main_body_footer_left">
                        <h4> <span class="col-1">Total Earning</span> <span class="col-2">7776565.00</span> <span class="col-3">2333.00</span></h4>
                </div>
                <div class="main_body_footer_right">
                        <h4> <span class="col-1">Total Deduction</span> <span class="col-2">344334.00</span> <span class="col-3">2339.00</span></h4>
                </div>
            </div>

            <div class="clearfix main_body_right_bottom_border"></div>


            <div class="main_body_footer_1">
                <div class="main_body_footer_1_left">
                    <h4 style="padding-top:5px;padding-bottom:5px;">Net pay (Rounded)</h4>
                </div>
                <div class="main_body_footer_1_right">
                    <h4 style="padding-right:15px;padding-top:5px;padding-bottom:5px;">343445.00</h4>
                </div>
            </div>
            <div class="clearfix main_body_right_bottom_border"></div>
        </div>
        <div class="clearfix"></div>
        <div class="footer_signture">
            <div class="footer_signture_left">
                <p>Employer Signature</p>
            </div>
            <div class="footer_signture_right">
                <p>Employee Signature</p>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

</body>
</html>