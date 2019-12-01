<style>
    #pageloader
    {
        background: rgba( 255, 255, 255, 0.8 );
        display: none;
        height: 100%;
        position: fixed;
        width: 100%;
        z-index: 9999;
    }

    #pageloader img
    {
        left: 40%;
        margin-left: -32px;
        margin-top: -32px;
        position: absolute;
        top: 50%;
        transform: translate(-50%,-50%);
    }

    .content_body{
        padding: 15px;
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
    }
    .content_body p{
        margin-top:7px;
    }
    .first_r{
        background: #40516f;
        color: #fff;
        font-weight: 700;
    }
    .first_r h5{
        font-weight: 700;
    }
    .table-body-1 tr{
        font-size: 14px;
    }
    .isDisabled {
        color: currentColor;
        cursor: not-allowed;
        opacity: 0.5;
        text-decoration: none;
    }
</style>

<div class="panel-body">
    <div class="row">

        <div class="col-md-8 col-md-offset-2 ">
            <div class="content_body">
                <div class="form-group">
                    <div class="row first_r">
                        <div class="col-md-12 col-sm-12 col-xs-12"><label><h5>Employee Details</h5></label></div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6"><label><h5>Full Name:</h5></label></div>
                        <div class="col-md-6 col-sm-6 col-xs-6"><p>{{$employee->full_name}}</p></div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6"><label><h5>Employee ID:</h5></label></div>
                        <div class="col-md-6 col-sm-6 col-xs-6"><p>{{$employee->employeeId}}</p></div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6  col-xs-6"><label><h5>Department:</h5></label></div>
                        <div class="col-md-6 col-sm-6 col-xs-6"><p>{{$employee->department_name}}</p></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6"><label><h5>Designation:</h5></label></div>
                        <div class="col-md-6 col-sm-6 col-xs-6"><p>{{$employee->designation_name}} </p></div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6"><label><h5>Contact Number:</h5></label></div>
                        <div class="col-md-6 col-sm-6 col-xs-6"><p>{{$employee->emp_phone}}</p></div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6"><label><h5>Email:</h5></label></div>
                        <div class="col-md-6 col-sm-6 col-xs-6"><p>{{$employee->emp_email}}</p></div>

                    </div>
                </div>
            </div>

        </div>

    </div>

</div>