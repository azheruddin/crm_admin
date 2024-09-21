<?php

namespace App\Imports;

use App\Models\Leads;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LeadsImport implements ToModel, WithHeadingRow
{
    // protected $employeeId;

    // // Constructor to receive the employee ID
    // public function __construct($employeeId)
    // {
    //     $this->employeeId = $employeeId;
    // }
    // public function model(array $row)
    // {
    //     return new Leads([
    //         'customer_name'    => $row['customer_name'],
    //         'customer_email'   => $row['customer_email'],
    //         'phone'            => $row['phone'],
    //         // 'lead_stage'       => $row['lead_stage'],
    //         // 'lead_date'        => $row['lead_date'],
    //         // 'expected_revenue' => $row['expected_revenue'],
    //         // 'next_follow_up'   => $row['next_follow_up'],
    //         // 'notes'            => $row['notes'],
    //         'employee_id'      => $row['employee_id']
    //     ]);
    // }


    protected $employeeId;

    // Constructor to receive the employee ID
      // Constructor to receive the employee ID
      public function __construct($employeeId)
      {
          $this->employeeId = $employeeId;
      }
  

    public function model(array $row)
    {
        return new Leads([
            'customer_name'    => $row['customer_name'],
            'customer_email'   => $row['customer_email'],
            'phone'            => $row['phone'],
            'city'            => $row['city'],
            'state'            => $row['state'],
            // 'lead_stage'       => $row['lead_stage'],
            // 'lead_date'        => $row['lead_date'],
            // 'expected_revenue' => $row['expected_revenue'],
            // 'next_follow_up'   => $row['next_follow_up'],
            // 'notes'            => $row['notes']
            'employee_id'      => $this->employeeId // Use the passed employee ID
        ]);
    }
}
