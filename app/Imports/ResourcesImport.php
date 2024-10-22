<?php
namespace App\Imports;

use App\Models\Resource;
use App\Models\Country;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth; 

class ResourcesImport implements ToModel, WithHeadingRow
{
    use Importable;

    protected $createdBy;

    public function __construct($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    public function model(array $row)
    {
        return new Resource([
            'name'               => $row['name'],
            'contact_no'         => $row['contact_no'],
            'group_link'         => $row['group_link'],
            'email'              => $row['email'],
            'region'             => $row['region'],
            'whatsapp_link'      => $row['whatsapp_link'],
            'certification'      => $row['certification'],
            'worked_with_us'     => intval($row['worked_with_us']),
            'whatsapp'           => $row['whatsapp'],
            'linked_in'          => $row['linked_in'],
            'tools_catagory'     => $row['tools_catagory'],
            'country_id'         => $this->getValidCountryId($row['country_id']),
            'city_name'          => $row['city_name'],
            'language'           => $row['language'],
            'latitude'           => $row['latitude'],
            'longitude'          => $row['longitude'],
            'address'            => $row['address'],
            'work_status'        => $row['work_status'],
            'daily_rate'         => $row['daily_rate'],
            'hourly_rate'        => $row['hourly_rate'],
            'weekly_rates'       => $row['weekly_rates'],
            'monthly_rates'      => $row['monthly_rates'],
            'rate_currency'      => $row['rate_currency'],
            'half_day_rates'     => $row['half_day_rates'],
            'created_by'         => $this->createdBy, 
            'account_payment_details_id' => intval($row['account_payment_details_id']),
        ]);
    }

    private function getValidCountryId($countryId)
    {
        if (Country::find($countryId)) {
            return $countryId;
        } else {
            return null; 
        }
    }
}
