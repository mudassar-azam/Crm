<?php

namespace Database\Seeders;

use App\Models\AccountPaymentDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccoundPaymentDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentDetails = [
            [
                'bank_name' => 'Bkra Bank',
                'account_number' => 'asdf',
                'bank_branch_name' => 'Sample Branch',
                'IBAN' => 'GB15BARC12345678901234',
                'bank_branch_code' => '123456',
                'BIC_or_Swift_code' => 'BARCGB22',
                'bank_city_name' => 'Sample City',
                'sort_code' => '12-34-56', // UK only
                'bank_address' => '123 Sample St, Sample City, Country',
                'country' => 'Sample Country',
                'account_holder_name' => 'John Doe',
                'transferwise_id' => 'TRANS123456',
            ],
            [
                'bank_name' => 'Dkra',
                'account_number' => '1234567890',
                'bank_branch_name' => 'Sample Branch',
                'IBAN' => 'GB15BARC12345678901234',
                'bank_branch_code' => '123456',
                'BIC_or_Swift_code' => 'BARCGB22',
                'bank_city_name' => 'Sample City',
                'sort_code' => '12-34-56', // UK only
                'bank_address' => '123 Sample St, Sample City, Country',
                'country' => 'Sample Country',
                'account_holder_name' => 'John Doe',
                'transferwise_id' => 'TRANS223456',
            ],
            // Add more sample data as needed
        ];

        // Insert sample data into the account_payment_details table
        foreach ($paymentDetails as $detail) {
            AccountPaymentDetail::create($detail);
        }
    }
}
