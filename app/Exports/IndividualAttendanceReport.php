<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class IndividualAttendanceReport implements FromView, ShouldAutoSize
{
    use Exportable;
    private $employee;
    private $request=[];
    private $company;

    public function __construct($employee,$request,$company)
    {
        $this->employee=$employee;
        $this->request=$request;
        $this->company=$company;

    }

    public function view() : View
    {
        return view('backend.report.attendance.excel.individual_attendance_excel', [
            'employee' => $this->employee,
            'request' => $this->request,
            'company' => $this->company,
        ]);
    }
}
