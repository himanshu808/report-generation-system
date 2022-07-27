<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MidtermExport implements FromCollection, WithHeadings, ShouldAutoSize
{
	use Exportable;
    
    public function __construct($data){
    	$this->data = $data;    	
    }

     /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	return collect($this->data);
    }

    public function headings(): array{
    	return [
    		'Course code',
    		'Name',
    		'Total hours in syllabus',
    		'Hours taken',
    		'Total practicals in syllabus',
    		'Practicals taken',
    		'Total tutorials in syllabus',
    		'Tutorials taken',
    		'Total assignments in syllabus',
    		'Assignments taken',
    		'% Syllabus covered',
    		'Leaves',
    		'TH+PR available till term end'
    	];
    }
}
