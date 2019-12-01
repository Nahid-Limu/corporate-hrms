<style>

    
        thead,
        tr,
        td,
        th {
            border: 1px solid #757575;
        }
    
        .heading-top {
            padding-top: 5px;
            padding-bottom: 5px;
        }
    
        .heading-top th {
            font-size: 13px;
            padding-top: 5px;
            padding-bottom: 5px;
        }
    
        .heading-top-middle {
            padding-top: 5px;
            padding-bottom: 5px;
        }
    
        .heading-top-middle th {
            font-size: 11px;
            text-align: center;
            padding-top: 5px;
            padding-bottom: 5px;
        }
    
        .table-content td {
            font-size: 11px;
        }
        tr.heading-top th {
            font-size: 11px;
        }
        .heading-bottom {
            border: 0px;
            font-size: 11px;
            border:none;
        }
        .heading-bottom td{
            border: 0px;
            border-color: #fff;
            padding-top: 6px;
            padding-bottom: 10px;
        }
    
        .table_info_data tr td{
            height: 65px;
        }
        .table_info_data tr{
            height:45px;
        }
        tr.heading_top_1{
            border:0px;
        }
        tr.heading_top_1 th{
            border:0px;
        }
        .table_head{
            
            border-top: 0px;
            border-left:0px;
            border-right: 0px;
           
        }
        .footer_part{
            
            opacity: 0;
            display: none;
        }
        tfoot{
            opacity: 1;
        }
        .heading-bottom-1{
            top:-50px;
        }
        .ex-footer{
            margin-top: -28px;
        }
        .ex-footer tr, .ex-footer td{
            border-top:0px;
        }
        .ex-footer table{
            width:100%;
        }
        .table_info_data tr.heading-bottom-2 td{
            height:30px;
        }

        .table_info_data tr.heading-bottom-2 {
            height:30px;
        }
        .footer_part p{
            display: inline-block;
            width: 33%;
            text-align: center
            
        }
        .footer_part p span{
            padding: 5px 15px;
            border-top: 1px solid #000;
        }
        .company_month{
            font-size: 12px;
            margin-bottom: 15px;
            display: block;
        }
       
    
        @page  {
                size: landscape;
                
            }
    
        @media print{
            table { page-break-inside:auto; }
            tr    { page-break-inside:avoid; page-break-after:auto;}
            thead {display: table-header-group;}
            tbody { page-break-after:always;
                display: table-row-group;}
            tfoot {
                display: table-footer-group;
               
            }
            .table_head{
                
                border-right:0px;
            }
            tbody{
                border-bottom: 0px;
            }
            

            tfoot .heading-bottom{
                border-top:0px;
                border: none;
                padding-top: 30px;
                opacity: 0;
            }

            tfoot .heading-bottom-1{
                
                opacity: 1;
            }

            .table_info_data tr:last-child td{
                border-bottom:none;
            }
            .footer_part{
                position: fixed;
                bottom: 0;
                left:0;
                width: 100%;
                opacity: 1;
                /* height:50px; */
                display: block;
                   padding-top: 30px;
            }
            .footer-space{
                //height:80px;
            }
            .footer_part p{
                width: 25%;
                float: left;
                text-align: center;
            }
            .footer_part p{
                display: inline-block;
                width: 33%;
                text-align: center
                
            }
            .footer_part p span{
                padding: 5px 15px;
                border-top: 1px solid #000;
            }
            
        }
    </style>
    <!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="fMlB0wRKfUGpCcLII5pcNpvL52VEcxIIDsiQ2cru">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="admin-themes-lab">
        <meta name="author" content="FEITS">
    
        <title>Salary Report </title>
    
        
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        
    </head>
    <!-- BEGIN BODY -->
    
    <body class="fixed-topbar fixed-sidebar theme-sdtl color-default">
    
        <section>
            <!-- BEGIN SIDEBAR -->
    
            <div class="main-content">
                
                
                <div class="page-content ">
                    <div class="container-fluid">
                    <div class="" >
                        
                        <div>
                            <table class="thikana" style="width:100%;text-align:center;">
                                <thead class="table_head">
                                    <tr  class="heading_top_1" style="border:0px;">
                                        <th colspan="25"  style="border:0px;">
                                            <div class="col-xlg-12 col-lg-12  col-sm-12">
                                                <div class="text-center" style="margin-bottom: 10px;">
                                                    <p>Fin Bangla Apparels Ltd.</p> 
                                                    <span style="text-align:center" class="company_month">For the month of: <span style=" margin-left:6px;">@php echo date('F-Y',strtotime($year_month)) @endphp</span> </span>
                                                    
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                    
                                    <tr class="heading-top-middle">
                                        <th  rowspan="2">SI  No</th>
                                        <th  rowspan="2">Card/ID No</th>
                                        <th rowspan="2">Name of <br> Employee</th>
                                        <th rowspan="2">Designation</th>
                                        <th rowspan="2">Grade</th>                  
                                        <th rowspan="2">Gross </th>
                                        <th rowspan="2">Leave Day</th>
                                        <th rowspan="2">Work <br> Days</th>
                                        <th rowspan="2">Abs Days</th>
                                        <th rowspan="2">Week <br> end</th>
                                        <th rowspan="2">Holiday</th>
                                        <th rowspan="2">Total<br> payable<br> Days</th>
                                        <th colspan="5">Deduction</th>
                                        {{-- <th rowspan="2">Gross <br>Pay</th> --}}
                                        <th colspan="3">Overtime</th>
                                        {{-- <th rowspan="2">Att <br>Bonus</th> --}}
                                        {{-- <th rowspan="2"> Special <br> Allow</th> --}}
                                        <th rowspan="2">Net <br> Wages</th>
                                        <th rowspan="2" style="width:100px;"> &nbsp; &nbsp; Signature  </th>
                        
                                    </tr>
                                    <tr class="heading-top-middle">
                                        <th>Tax</th>
                                        <th>Abs </th>
                                        <th>Stm</th>
                                        <th>late</th>
                                        <th>PFA</th>
                                        <th>Hrs </th>
                                        <th>Rate</th>
                                        <th>Amnt</th>
                                    </tr>
                                    
                                </thead>
    
                                @php
                                    $totalGross_salary = 0;
                                    $totalDeduction = 0;
                                    $totalNet_salary = 0;
                                    
                                @endphp
                                <tbody class="table-content table_info_data">
                                        @foreach ($emp_salary_details as $emp_salary)
                                         @php
                                               $total_Gross_salary =  $emp_salary->basic_salary+$emp_salary->food+$emp_salary->house_rant+$emp_salary->medical+$emp_salary->transport+$emp_salary->other
                                            @endphp
                                            
                                            @php 
                                                $totalGross_salary+=$total_Gross_salary;
                                            @endphp 
                                            @php 
                                                $totalDeduction+=$emp_salary->absent_deduction_amount;
                                            @endphp 
                                            @php 
                                                $totalNet_salary+=$emp_salary->net_salary;
                                            @endphp 


                                        <tr>
                                            <td >1</td>
                                            <td >{{$emp_salary->emp_card_number}}</td>
                                            <td>{{$emp_salary->emp_first_name}} {{$emp_salary->emp_lastName}}</td>
                                            <td >{{$emp_salary->designation_name}}</td>
                                            <td>{{$emp_salary->grade_name}}</td>
                                           
                                            <td >{{$total_Gross_salary}}</td>
                                            <td> {{$emp_salary->leave}}</td>
                                            <td>{{$emp_salary->working_day}}</td>
                                            <td>{{$emp_salary->absent}}</td>
                                            <td>{{$emp_salary->weekend}}</td>
                                            <td >{{$emp_salary->festivalleave}}</td>                                   
                                            <td>{{$emp_salary->present}}</td>
                                            <td >{{ $emp_salary->bdtax }}</td>
                                            <td >{{$emp_salary->absent}}</td>
                                            <td >{{$emp_salary->absent_deduction_amount}}</td>
                                            <td >{{$emp_salary->late}}</td>
                                            <td >{{$emp_salary->provident_fund_amount}}</td>
                                            {{-- <td>{{$emp_salary->Gross_salary}}</td> --}}
                                            <td >{{$emp_salary->overtime}}</td>
                                            {{-- <td >0</td> --}}
                                            <td >{{$emp_salary->hour_amount}}</td>
                                             <td >{{$emp_salary->overtime*$emp_salary->hour_amount}}</td>
                                            {{-- <td >20</td> --}}
                                            <td >{{$emp_salary->net_salary}}</td>
                                            <td style="width:100px; height:50px;" ></td>
                                        </tr>

                                        @endforeach
                                      
                                            
                                            
                                    <tr class="heading-bottom-1 heading-bottom-2" style="">
                                            <td colspan="5"></td>
                                            <td colspan="1">{{  $totalGross_salary }}</td>
                                            <td colspan="6"></td>
                                            <td colspan="5">{{ $totalDeduction}}</td>
                                            <td colspan="3"></td>
                                            {{-- <td colspan="1">0</td> --}}
                                            <td colspan="1">{{ $totalNet_salary}}</td>
                                            <td colspan="1"></td>
                                
                                    </tr>              
                            
                                </tbody>

    
                                <tfoot>

                                        <tr class="heading-bottom" style="border:0px; font-size:11px;">
                                                <td>
                                                        <div class="footer-space">&nbsp;</div>
                                                      </td>
                                                {{--  <td colspan="5" style="text-align:center">Prepared By</td>
                                                <td colspan="5" style="text-align:center">Checked By</td>
                                                <td colspan="5" style="text-align:center">Manager Account</td>
                                                <td colspan="5" style="text-align:center">Managing Director</td>  --}}
                                        </tr>
                                </tfoot>
    
                                <div class="footer_part">
                                    <p > <span>Prepared By</span> </p>
                                    <p > <span>Checked By</span> </p>
                                    <p > <span>Manager Account</span> </p>
                                    
                                    
                                </div>
                                
    
                            </table>


                            {{--  <div class="ex-footer">
                                    <table>
                                            <tr class="heading-bottom-1" style="">
                                                    <td colspan="5">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                    <td colspan="1">249434</td>
                                                    <td colspan="6">&nbsp;</td>
                                                    <td colspan="3">249434</td>
                                                    <td colspan="5">&nbsp;</td>
                                                    <td colspan="1">0</td>
                                                    <td colspan="1">570136</td>
                                                    <td colspan="1">&nbsp;</td>
                                      
                                            </tr>
                                    </table>
                            </div>  --}}
                            
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    
    
    
            <!-- END MAIN CONTENT -->
        </section>
       
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <!-- BEGIN PAGE SCRIPT -->
       
    </body>
    
    </html>
    