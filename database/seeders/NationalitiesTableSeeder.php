<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class NationalitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nationalities = [
            ['nationality' => 'Algerian'],
            ['nationality' => 'Angolan'],
            ['nationality' => 'Argentine'],
            ['nationality' => 'Armenian'],
            ['nationality' => 'Australian'],
            ['nationality' => 'Austrian'],
            ['nationality' => 'Azerbaijani'],
            ['nationality' => 'Bahamian'],
            ['nationality' => 'Bahraini'],
            ['nationality' => 'Bangladeshi'],
            ['nationality' => 'Barbadian'],
            ['nationality' => 'Belarusian'],
            ['nationality' => 'Belgian'],
            ['nationality' => 'Belizean'],
            ['nationality' => 'Bhutanese'],
            ['nationality' => 'Bolivian'],
            ['nationality' => 'Bosnian'],
            ['nationality' => 'Brazilian'],
            ['nationality' => 'British'],
            ['nationality' => 'Bruneian'],
            ['nationality' => 'Bulgarian'],
            ['nationality' => 'Burkinabe'],
            ['nationality' => 'Burmese'],
            ['nationality' => 'Burundian'],
            ['nationality' => 'Cambodian'],
            ['nationality' => 'Cameroonian'],
            ['nationality' => 'Canadian'],
            ['nationality' => 'Chadian'],
            ['nationality' => 'Chilean'],
            ['nationality' => 'Chinese'],
            ['nationality' => 'Colombian'],
            ['nationality' => 'Comoran'],
            ['nationality' => 'Congolese'],
            ['nationality' => 'Costa Rican'],
            ['nationality' => 'Croatian'],
            ['nationality' => 'Cuban'],
            ['nationality' => 'Cypriot'],
            ['nationality' => 'Czech'],
            ['nationality' => 'Danish'],
            ['nationality' => 'Djiboutian'],
            ['nationality' => 'Dominican'],
            ['nationality' => 'Dutch'],
            ['nationality' => 'Ecuadorian'],
            ['nationality' => 'Egyptian'],
            ['nationality' => 'Emirati'],
            ['nationality' => 'Eritrean'],
            ['nationality' => 'Estonian'],
            ['nationality' => 'Ethiopian'],
            ['nationality' => 'Fijian'],
            ['nationality' => 'Filipino'],
            ['nationality' => 'Finnish'],
            ['nationality' => 'French'],
            ['nationality' => 'Gabonese'],
            ['nationality' => 'Gambian'],
            ['nationality' => 'Georgian'],
            ['nationality' => 'German'],
            ['nationality' => 'Ghanaian'],
            ['nationality' => 'Greek'],
            ['nationality' => 'Grenadian'],
            ['nationality' => 'Guatemalan'],
            ['nationality' => 'Guinea-Bissauan'],
            ['nationality' => 'Guinean'],
            ['nationality' => 'Guyanese'],
            ['nationality' => 'Haitian'],
            ['nationality' => 'Honduran'],
            ['nationality' => 'Hungarian'],
            ['nationality' => 'Icelandic'],
            ['nationality' => 'Indian'],
            ['nationality' => 'Indonesian'],
            ['nationality' => 'Iranian'],
            ['nationality' => 'Iraqi'],
            ['nationality' => 'Irish'],
            ['nationality' => 'Israeli'],
            ['nationality' => 'Italian'],
            ['nationality' => 'Jamaican'],
            ['nationality' => 'Japanese'],
            ['nationality' => 'Jordanian'],
            ['nationality' => 'Kazakhstani'],
            ['nationality' => 'Kenyan'],
            ['nationality' => 'Kuwaiti'],
            ['nationality' => 'Kyrgyz'],
            ['nationality' => 'Laotian'],
            ['nationality' => 'Latvian'],
            ['nationality' => 'Lebanese'],
            ['nationality' => 'Liberian'],
            ['nationality' => 'Libyan'],
            ['nationality' => 'Liechtensteiner'],
            ['nationality' => 'Lithuanian'],
            ['nationality' => 'Luxembourger'],
            ['nationality' => 'Macedonian'],
            ['nationality' => 'Malagasy'],
            ['nationality' => 'Malawian'],
            ['nationality' => 'Malaysian'],
            ['nationality' => 'Maldivian'],
            ['nationality' => 'Malian'],
            ['nationality' => 'Maltese'],
            ['nationality' => 'Mauritanian'],
            ['nationality' => 'Mauritian'],
            ['nationality' => 'Mexican'],
            ['nationality' => 'Moldovan'],
            ['nationality' => 'Monacan'],
            ['nationality' => 'Mongolian'],
            ['nationality' => 'Montenegrin'],
            ['nationality' => 'Moroccan'],
            ['nationality' => 'Mozambican'],
            ['nationality' => 'Namibian'],
            ['nationality' => 'Nepalese'],
            ['nationality' => 'New Zealander'],
            ['nationality' => 'Nicaraguan'],
            ['nationality' => 'Nigerian'],
            ['nationality' => 'Nigerien'],
            ['nationality' => 'North Korean'],
            ['nationality' => 'Norwegian'],
            ['nationality' => 'Omani'],
            ['nationality' => 'Pakistani'],
            ['nationality' => 'Palestinian'],
            ['nationality' => 'Panamanian'],
            ['nationality' => 'Papua New Guinean'],
            ['nationality' => 'Paraguayan'],
            ['nationality' => 'Peruvian'],
            ['nationality' => 'Polish'],
            ['nationality' => 'Portuguese'],
            ['nationality' => 'Qatari'],
            ['nationality' => 'Romanian'],
            ['nationality' => 'Russian'],
            ['nationality' => 'Rwandan'],
            ['nationality' => 'Saint Lucian'],
            ['nationality' => 'Salvadoran'],
            ['nationality' => 'Samoan'],
            ['nationality' => 'Saudi'],
            ['nationality' => 'Senegalese'],
            ['nationality' => 'Serbian'],
            ['nationality' => 'Seychellois'],
            ['nationality' => 'Sierra Leonean'],
            ['nationality' => 'Singaporean'],
            ['nationality' => 'Slovak'],
            ['nationality' => 'Slovenian'],
            ['nationality' => 'Somali'],
            ['nationality' => 'South African'],
            ['nationality' => 'South Korean'],
            ['nationality' => 'South Sudanese'],
            ['nationality' => 'Spanish'],
            ['nationality' => 'Sri Lankan'],
            ['nationality' => 'Sudanese'],
            ['nationality' => 'Surinamese'],
            ['nationality' => 'Swazi'],
            ['nationality' => 'Swedish'],
            ['nationality' => 'Swiss'],
            ['nationality' => 'Syrian'],
            ['nationality' => 'Taiwanese'],
            ['nationality' => 'Tajik'],
            ['nationality' => 'Tanzanian'],
            ['nationality' => 'Thai'],
            ['nationality' => 'Togolese'],
            ['nationality' => 'Tongan'],
            ['nationality' => 'Trinidadian or Tobagonian'],
            ['nationality' => 'Tunisian'],
            ['nationality' => 'Turkish'],
            ['nationality' => 'Turkmen'],
            ['nationality' => 'Tuvaluan'],
            ['nationality' => 'Ugandan'],
            ['nationality' => 'Ukrainian'],
            ['nationality' => 'Uruguayan'],
            ['nationality' => 'Uzbekistani'],
            ['nationality' => 'Venezuelan'],
            ['nationality' => 'Vietnamese'],
            ['nationality' => 'Yemenite'],
            ['nationality' => 'Zambian'],
            ['nationality' => 'Zimbabwean'],
            ['nationality' => 'Afghan'],
            ['nationality' => 'Andorran'],
            ['nationality' => 'Beninese'],
            ['nationality' => 'Botswanan'],
            ['nationality' => 'Cabo Verdean'],
            ['nationality' => 'Central African'],
            ['nationality' => 'Congo-Brazzaville'],
            ['nationality' => 'Congo-Kinshasa'],
            ['nationality' => 'East Timorese'],
            ['nationality' => 'Equatorial Guinean'],
            ['nationality' => 'Eswatini'],
            ['nationality' => 'Icelander'],
            ['nationality' => 'Kittitian'],
            ['nationality' => 'Kosovar'],
            ['nationality' => 'Lao'],
            ['nationality' => 'Luxembourgish'],
            ['nationality' => 'Marshallese'],
            ['nationality' => 'Micronesian'],
            ['nationality' => 'Nauruan'],
            ['nationality' => 'Palauan'],
            ['nationality' => 'Saint Kitts Nevis'],
            ['nationality' => 'Saint Vincentian'],
            ['nationality' => 'Sao Tomean'],
            ['nationality' => 'Solomon Islander'],
            ['nationality' => 'Vanuatuan']
        ];
        foreach ($nationalities as $nationality) {
            $nationality['created_at'] = now();
            $nationality['updated_at'] = now();
            DB::table('nationalities')->insert($nationality);
        }
    }
}
