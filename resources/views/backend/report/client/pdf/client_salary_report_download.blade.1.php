
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="fMlB0wRKfUGpCcLII5pcNpvL52VEcxIIDsiQ2cru">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="admin-themes-lab">
    <meta name="author" content="FEITS">

    <title>
         Salary Sheet </title>

    
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
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
    tr.heading_top_1 h4{
        margin-bottom: 5px;
    }
    tr.heading_top_1 p{
        font-weight: 500;
        padding-bottom: 13px;
    }
    .table_head{
        
        border-top: 0px;
        border-left:0px;
        border-right:0px;
       
    }
    .footer_part{
        opacity: 0;
        display: none;
    }
    tfoot{
        opacity: 1;
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
        tfoot{
            border-top:0px;
            border: none;
            padding-top: 30px;
            opacity: 0;
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
            height:80px;
        }
        .footer_part p{
            width: 25%;
            float: left;
            text-align: center;
        }
    }
</style> 
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
                                                <h4> <b> Fin Bangla Apparels Ltd.</b></h4>
                                                
                                                <p style="text-align:center">Pay Sheet For the month of : <span style="margin-left:6px;">April-2019</span> </p>
                                                
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                
                                <tr class="heading-top-middle">
                                    <th  rowspan="2">SI No</th>
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
                                    <th colspan="3">Deduction</th>
                                    <th rowspan="2">Gross <br>Pay</th>
                                    <th colspan="3">Overtime</th>
                                    <th rowspan="2">Att <br>Bonus</th>
                                    <th rowspan="2"> Special <br> Allow</th>
                                    <th rowspan="2">Net <br> Wages</th>
                                    <th rowspan="2">Signature</th>

                                </tr>
                                <tr class="heading-top-middle">
                                    <th>Adv</th>
                                    <th>Abs </th>
                                    <th>Stm</th>
                                    <th>Hrs </th>
                                    <th>Rate</th>
                                    <th>Amnt</th>
                                </tr>
                                
                            </thead>

                            <tbody class="table-content table_info_data" >
                                <tr >
                                    <td >1</td>
                                    <td >19</td>
                                    <td>Washim</td>
                                    <td >ELECTRICIAN</td>
                                    <td>G2</td>
                                    <td >11964</td>
                                    <td> 4686</td>
                                    <td>250</td>
                                    <td>200</td>
                                    <td>650</td>
                                    <td >17500</td>                                   
                                    <td>31 </td>
                                    <td >7</td>
                                    <td >24</td>
                                    <td >300</td>
                                    <td>17500</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >112.57</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >17851</td>
                                    <td style="width:100px;" ></td>
                                </tr>
                                <tr >
                                    <td >1</td>
                                    <td >19</td>
                                    <td>Washim</td>
                                    <td >ELECTRICIAN</td>
                                    <td>G2</td>
                                    <td >11964</td>
                                    <td> 4686</td>
                                    <td>250</td>
                                    <td>200</td>
                                    <td>650</td>
                                    <td >17500</td>                                   
                                    <td>31 </td>
                                    <td >7</td>
                                    <td >24</td>
                                    <td >300</td>
                                    <td>17500</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >112.57</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >17851</td>
                                    <td style="width:100px;" ></td>
                                </tr>
                                <tr >
                                    <td >1</td>
                                    <td >19</td>
                                    <td>Washim</td>
                                    <td >ELECTRICIAN</td>
                                    <td>G2</td>
                                    <td >11964</td>
                                    <td> 4686</td>
                                    <td>250</td>
                                    <td>200</td>
                                    <td>650</td>
                                    <td >17500</td>                                   
                                    <td>31 </td>
                                    <td >7</td>
                                    <td >24</td>
                                    <td >300</td>
                                    <td>17500</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >112.57</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >17851</td>
                                    <td style="width:100px;" ></td>
                                </tr>
                                <tr >
                                    <td >1</td>
                                    <td >19</td>
                                    <td>Washim</td>
                                    <td >ELECTRICIAN</td>
                                    <td>G2</td>
                                    <td >11964</td>
                                    <td> 4686</td>
                                    <td>250</td>
                                    <td>200</td>
                                    <td>650</td>
                                    <td >17500</td>                                   
                                    <td>31 </td>
                                    <td >7</td>
                                    <td >24</td>
                                    <td >300</td>
                                    <td>17500</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >112.57</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >17851</td>
                                    <td style="width:100px;" ></td>
                                </tr>
                                <tr >
                                    <td >1</td>
                                    <td >19</td>
                                    <td>Washim</td>
                                    <td >ELECTRICIAN</td>
                                    <td>G2</td>
                                    <td >11964</td>
                                    <td> 4686</td>
                                    <td>250</td>
                                    <td>200</td>
                                    <td>650</td>
                                    <td >17500</td>                                   
                                    <td>31 </td>
                                    <td >7</td>
                                    <td >24</td>
                                    <td >300</td>
                                    <td>17500</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >112.57</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >17851</td>
                                    <td style="width:100px;" ></td>
                                </tr>
                                <tr >
                                    <td >1</td>
                                    <td >19</td>
                                    <td>Washim</td>
                                    <td >ELECTRICIAN</td>
                                    <td>G2</td>
                                    <td >11964</td>
                                    <td> 4686</td>
                                    <td>250</td>
                                    <td>200</td>
                                    <td>650</td>
                                    <td >17500</td>                                   
                                    <td>31 </td>
                                    <td >7</td>
                                    <td >24</td>
                                    <td >300</td>
                                    <td>17500</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >112.57</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >17851</td>
                                    <td style="width:100px;" ></td>
                                </tr>
                                <tr >
                                    <td >1</td>
                                    <td >19</td>
                                    <td>Washim</td>
                                    <td >ELECTRICIAN</td>
                                    <td>G2</td>
                                    <td >11964</td>
                                    <td> 4686</td>
                                    <td>250</td>
                                    <td>200</td>
                                    <td>650</td>
                                    <td >17500</td>                                   
                                    <td>31 </td>
                                    <td >7</td>
                                    <td >24</td>
                                    <td >300</td>
                                    <td>17500</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >112.57</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >17851</td>
                                    <td style="width:100px;" ></td>
                                </tr>
                                <tr >
                                    <td >1</td>
                                    <td >19</td>
                                    <td>Washim</td>
                                    <td >ELECTRICIAN</td>
                                    <td>G2</td>
                                    <td >11964</td>
                                    <td> 4686</td>
                                    <td>250</td>
                                    <td>200</td>
                                    <td>650</td>
                                    <td >17500</td>                                   
                                    <td>31 </td>
                                    <td >7</td>
                                    <td >24</td>
                                    <td >300</td>
                                    <td>17500</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >112.57</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >17851</td>
                                    <td style="width:100px;" ></td>
                                </tr>
                                <tr >
                                    <td >1</td>
                                    <td >19</td>
                                    <td>Washim</td>
                                    <td >ELECTRICIAN</td>
                                    <td>G2</td>
                                    <td >11964</td>
                                    <td> 4686</td>
                                    <td>250</td>
                                    <td>200</td>
                                    <td>650</td>
                                    <td >17500</td>                                   
                                    <td>31 </td>
                                    <td >7</td>
                                    <td >24</td>
                                    <td >300</td>
                                    <td>17500</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >112.57</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >17851</td>
                                    <td style="width:100px;" ></td>
                                </tr>
                                <tr >
                                    <td >1</td>
                                    <td >19</td>
                                    <td>Washim</td>
                                    <td >ELECTRICIAN</td>
                                    <td>G2</td>
                                    <td >11964</td>
                                    <td> 4686</td>
                                    <td>250</td>
                                    <td>200</td>
                                    <td>650</td>
                                    <td >17500</td>                                   
                                    <td>31 </td>
                                    <td >7</td>
                                    <td >24</td>
                                    <td >300</td>
                                    <td>17500</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >112.57</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >17851</td>
                                    <td style="width:100px;" ></td>
                                </tr>
                                <tr >
                                    <td >1</td>
                                    <td >19</td>
                                    <td>Washim</td>
                                    <td >ELECTRICIAN</td>
                                    <td>G2</td>
                                    <td >11964</td>
                                    <td> 4686</td>
                                    <td>250</td>
                                    <td>200</td>
                                    <td>650</td>
                                    <td >17500</td>                                   
                                    <td>31 </td>
                                    <td >7</td>
                                    <td >24</td>
                                    <td >300</td>
                                    <td>17500</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >112.57</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >17851</td>
                                    <td style="width:100px;" ></td>
                                </tr>
                                <tr >
                                    <td >1</td>
                                    <td >19</td>
                                    <td>Washim</td>
                                    <td >ELECTRICIAN</td>
                                    <td>G2</td>
                                    <td >11964</td>
                                    <td> 4686</td>
                                    <td>250</td>
                                    <td>200</td>
                                    <td>650</td>
                                    <td >17500</td>                                   
                                    <td>31 </td>
                                    <td >7</td>
                                    <td >24</td>
                                    <td >300</td>
                                    <td>17500</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >112.57</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >17851</td>
                                    <td style="width:100px;" ></td>
                                </tr>
                                <tr >
                                    <td >1</td>
                                    <td >19</td>
                                    <td>Washim</td>
                                    <td >ELECTRICIAN</td>
                                    <td>G2</td>
                                    <td >11964</td>
                                    <td> 4686</td>
                                    <td>250</td>
                                    <td>200</td>
                                    <td>650</td>
                                    <td >17500</td>                                   
                                    <td>31 </td>
                                    <td >7</td>
                                    <td >24</td>
                                    <td >300</td>
                                    <td>17500</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >112.57</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >17851</td>
                                    <td style="width:100px;" ></td>
                                </tr>
                                <tr >
                                    <td >1</td>
                                    <td >19</td>
                                    <td>Washim</td>
                                    <td >ELECTRICIAN</td>
                                    <td>G2</td>
                                    <td >11964</td>
                                    <td> 4686</td>
                                    <td>250</td>
                                    <td>200</td>
                                    <td>650</td>
                                    <td >17500</td>                                   
                                    <td>31 </td>
                                    <td >7</td>
                                    <td >24</td>
                                    <td >300</td>
                                    <td>17500</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >112.57</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >17851</td>
                                    <td style="width:100px;" ></td>
                                </tr>
                                <tr >
                                    <td >1</td>
                                    <td >19</td>
                                    <td>Washim</td>
                                    <td >ELECTRICIAN</td>
                                    <td>G2</td>
                                    <td >11964</td>
                                    <td> 4686</td>
                                    <td>250</td>
                                    <td>200</td>
                                    <td>650</td>
                                    <td >17500</td>                                   
                                    <td>31 </td>
                                    <td >7</td>
                                    <td >24</td>
                                    <td >300</td>
                                    <td>17500</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >112.57</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >17851</td>
                                    <td style="width:100px;" ></td>
                                </tr>
                                <tr >
                                    <td >1</td>
                                    <td >19</td>
                                    <td>Washim</td>
                                    <td >ELECTRICIAN</td>
                                    <td>G2</td>
                                    <td >11964</td>
                                    <td> 4686</td>
                                    <td>250</td>
                                    <td>200</td>
                                    <td>650</td>
                                    <td >17500</td>                                   
                                    <td>31 </td>
                                    <td >7</td>
                                    <td >24</td>
                                    <td >300</td>
                                    <td>17500</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >112.57</td>
                                    <td >0</td>
                                    <td >0</td>
                                    <td >17851</td>
                                    <td style="width:100px;" ></td>
                                </tr>
 
                            </tbody>

                            <tfoot>
                                    <tr class="heading-bottom" style="border:0px; font-size:11px;padding-top: 30px;">
                                            <td>
                                                    <div class="footer-space">&nbsp;</div>
                                                  </td>
                                            <td colspan="5" style="text-align:center">Prepared By</td>
                                            <td colspan="5" style="text-align:center">Checked By</td>
                                            <td colspan="5" style="text-align:center">Manager Account</td>
                                            <td colspan="5" style="text-align:center">Managing Director</td>
                                    </tr>
                            </tfoot>

                            <div class="footer_part">
                                <p >Prepared By</p>
                                <p>Checked By</p>
                                <p>Manager Account</p>
                                <p>Managing Director</p>
                                
                            </div>
                            

                        </table>
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


