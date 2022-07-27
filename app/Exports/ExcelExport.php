<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExcelExport implements FromCollection, WithHeadings, ShouldAutoSize
{
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($data){
    	$this->data = $data;    	
    }

    public function collection()
    {
    	return collect($this->data);
    }

    public function headings(): array{
    	return [
    		'Month',
    		'Course code',
    		'Name',
    		'Lectures planned',
    		'Lectures taken',
    		'Practicals planned',
    		'Practicals taken',
    		'Tutorials planned',
    		'Tutorials taken',
    		'Assignments planned',
    		'Assignments taken',
    		'% Syllabus covered',
    		'Leaves',
    		'Adjusted lectures',
    		'Extra lectures'
    	];
    }
}
