<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class ContactsExport implements FromCollection, WithHeadings
{
    protected $contacts;

    public function __construct(Collection $contacts)
    {
        $this->contacts = $contacts;
    }

    public function collection()
    {
        return $this->contacts;
    }

    public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Gender',
            'Email',
            'Phone',
            'Address',
            'Building',
            'Category ID',
            'Detail',
            'Updated At',
        ];
    }
}
