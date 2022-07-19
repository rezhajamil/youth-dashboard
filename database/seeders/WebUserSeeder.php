<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class WebUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            [
                "id" => 1,
                "username" => "Deddy",
                "password" => \bcrypt("jambi2021"),
                "id_branch" => "8111116030",
                "name" => "Deddy",
                "privilege" => "superadmin",
                "branch" => "JAMBI",
                "regional" => "SUMBAGSEL"
            ],
            [
                "id" => 31,
                "username" => "Yuda",
                "password" => \bcrypt("sumbagteng2021"),
                "id_branch" => "1234",
                "name" => "YUDA",
                "privilege" => "superadmin",
                "branch" => "SUMBAGTENG",
                "regional" => "SUMBAGTENG"
            ],
            [
                "id" => 32,
                "username" => "RIRIS",
                "password" => \bcrypt("sumbagut2021"),
                "id_branch" => "1234",
                "name" => "RIRIS",
                "privilege" => "superadmin",
                "branch" => "SUMBAGUT",
                "regional" => "SUMBAGUT"
            ],
            [
                "id" => 33,
                "username" => "NOVI",
                "password" => \bcrypt("sumbagsel2021"),
                "id_branch" => "1234",
                "name" => "NOVI",
                "privilege" => "superadmin",
                "branch" => "SUMBAGSEL",
                "regional" => "SUMBAGSEL"
            ],
            [
                "id" => 34,
                "username" => "Bambang",
                "password" => \bcrypt("jambi2021"),
                "id_branch" => "811727200",
                "name" => "Bammbang Purnomo",
                "privilege" => "branch",
                "branch" => "JAMBI",
                "regional" => "SUMBAGSEL"
            ],
            [
                "id" => 35,
                "username" => "Petra",
                "password" => \bcrypt("pkp2021"),
                "id_branch" => "8111992083",
                "name" => "Petra Radite",
                "privilege" => "branch",
                "branch" => "PANGKAL PINANG",
                "regional" => "SUMBAGSEL"
            ],
            [
                "id" => 36,
                "username" => "Makruf",
                "password" => \bcrypt("bengkulu2022"),
                "id_branch" => "811671009",
                "name" => "Makruf Nur Hidayat",
                "privilege" => "branch",
                "branch" => "BENGKULU",
                "regional" => "SUMBAGSEL"
            ],
            [
                "id" => 37,
                "username" => "Deni",
                "password" => \bcrypt("lampung2022"),
                "id_branch" => "811625400",
                "name" => "Deni Hardiansyah",
                "privilege" => "branch",
                "branch" => "LAMPUNG",
                "regional" => "SUMBAGSEL"
            ],
            [
                "id" => 38,
                "username" => "Rofik",
                "password" => \bcrypt("plb2021"),
                "id_branch" => "8117300188",
                "name" => "Rofik Satria",
                "privilege" => "branch",
                "branch" => "PALEMBANG",
                "regional" => "SUMBAGSEL"
            ],
            [
                "id" => 39,
                "username" => "Ahmad",
                "password" => \bcrypt("mdn2021"),
                "id_branch" => "811650600",
                "name" => "Ahmad FF Lubis",
                "privilege" => "branch",
                "branch" => "CENTRAL MEDAN",
                "regional" => "SUMBAGUT"
            ],
            [
                "id" => 40,
                "username" => "Gusria",
                "password" => \bcrypt("pkb2021"),
                "id_branch" => "811660366",
                "name" => "Gusria Setiani",
                "privilege" => "branch",
                "branch" => "PEKANBARU",
                "regional" => "SUMBAGTENG"
            ],
            [
                "id" => 41,
                "username" => "Hadi",
                "password" => \bcrypt("dumai2021"),
                "id_branch" => "811769989",
                "name" => "Hadi Rosyiddin",
                "privilege" => "branch",
                "branch" => "DUMAI",
                "regional" => "SUMBAGTENG"
            ],
            [
                "id" => 42,
                "username" => "Yopi Sujadmiko",
                "password" => \bcrypt("pds2021"),
                "id_branch" => "811604605",
                "name" => "Yopi Sujadmiko",
                "privilege" => "branch",
                "branch" => "PADANG SIDEMPUAN",
                "regional" => "SUMBAGUT"
            ],
            [
                "id" => 43,
                "username" => "Arie Satria",
                "password" => \bcrypt("pdg2021"),
                "id_branch" => "811621400",
                "name" => "Arie Satria",
                "privilege" => "branch",
                "branch" => "PADANG",
                "regional" => "SUMBAGUT"
            ],
            [
                "id" => 44,
                "username" => "Satria",
                "password" => \bcrypt("pms2021"),
                "id_branch" => "8117300987",
                "name" => "Satria",
                "privilege" => "branch",
                "branch" => "PEMATANG SIANTAR",
                "regional" => "SUMBAGUT"
            ],
            [
                "id" => 45,
                "username" => "Chairuddin",
                "password" => \bcrypt("aceh2021"),
                "id_branch" => "811750550",
                "name" => "Chairuddin",
                "privilege" => "branch",
                "branch" => "BANDA ACEH",
                "regional" => "SUMBAGUT"
            ],
            [
                "id" => 46,
                "username" => "Margaretha",
                "password" => \bcrypt("binjai2021"),
                "id_branch" => "811638672",
                "name" => "Margaretha S L",
                "privilege" => "branch",
                "branch" => "WESTERN MEDAN",
                "regional" => "SUMBAGUT"
            ],
            [
                "id" => 47,
                "username" => "Bani",
                "password" => \bcrypt("batam2021"),
                "id_branch" => "i",
                "name" => "BATAM",
                "privilege" => "branch",
                "branch" => "BATAM",
                "regional" => "SUMBAGTENG"
            ],
            [
                "id" => 48,
                "username" => "Doni",
                "password" => \bcrypt("jambar2021"),
                "id_branch" => "i",
                "name" => "Jambi Barat",
                "privilege" => "cluster",
                "branch" => "JAMBI BARAT",
                "regional" => "SUMBAGSEL"
            ],
            [
                "id" => 49,
                "username" => "Bakhtiar",
                "password" => \bcrypt("dlsbatam2021"),
                "id_branch" => "i",
                "name" => "BATAM",
                "privilege" => "branch",
                "branch" => "BATAM",
                "regional" => "SUMBAGTENG"
            ],
            [
                "id" => 50,
                "username" => "Ade",
                "password" => \bcrypt("dlssumbagut21"),
                "id_branch" => "1234",
                "name" => "ADE",
                "privilege" => "superadmin",
                "branch" => "SUMBAGUT",
                "regional" => "SUMBAGUT"
            ],
            [
                "id" => 51,
                "username" => "SUGIANTO",
                "password" => \bcrypt("campain2021"),
                "id_branch" => "0",
                "name" => "SUGIANTO",
                "privilege" => "superadmin",
                "branch" => "MEDAN",
                "regional" => "SUMBAGUT"
            ],
            [
                "id" => 52,
                "username" => "Syafriadi",
                "password" => \bcrypt("jambi2021"),
                "id_branch" => "8117461746",
                "name" => "Syafriadi",
                "privilege" => "branch",
                "branch" => "JAMBI",
                "regional" => "SUMBAGSEL"
            ],
            [
                "id" => 53,
                "username" => "LIA",
                "password" => \bcrypt("sumbagsel21"),
                "id_branch" => "1234",
                "name" => "Lia P Mulyati",
                "privilege" => "superadmin",
                "branch" => "SUMBAGSEL",
                "regional" => "SUMBAGSEL"
            ]
        ];

        foreach ($data as $data) {
            User::create($data);
        }
    }
}
