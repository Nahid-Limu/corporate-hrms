<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;

class DailyAttendanceReport implements FromView, ShouldAutoSize
{
    use Exportable;
    private $all_data=[];
    private $request=[];
    private $company;

    public function __construct($all_data,$request,$company)
    {
        $this->all_data=$all_data;
        $this->request=$request;
        $this->company=$company;

    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('backend.report.attendance.excel.attendance_report_excel', [
            'all_data' => $this->all_data,
            'request' => $this->request,
            'company' => $this->company,
        ]);
    }
}
