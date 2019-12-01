<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DailyAbsentReport implements FromView, ShouldAutoSize
{
    use Exportable;
    private $absent=[];
    private $request=[];
    private $company;

    public function __construct($absent,$request,$company)
    {
        $this->absent=$absent;
        $this->request=$request;
        $this->company=$company;

    }

    public function view() : View
    {
        return view('backend.report.attendance.excel.daily_absent_report_excel', [
            'absent' => $this->absent,
            'request' => $this->request,
            'company' => $this->company,
        ]);
    }
}
