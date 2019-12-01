<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LateReport implements FromView, ShouldAutoSize
{
    use Exportable;
    private $attendance_data=[];
    private $request=[];
    private $company;

    public function __construct($attendance_data,$request,$company)
    {
        $this->attendance_data=$attendance_data;
        $this->request=$request;
        $this->company=$company;

    }

    public function view() : View
    {
        return view('backend.report.attendance.excel.late_report_excel', [
            'attendance_data' => $this->attendance_data,
            'request' => $this->request,
            'company' => $this->company,
        ]);
    }
}
