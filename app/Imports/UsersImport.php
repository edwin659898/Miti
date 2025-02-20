<?php

namespace App\Imports;

use App\Mail\NotifyUserOfNewMagazine;
use App\Models\Country;
use App\Models\Shipping;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UsersImport implements ToModel, WithHeadingRow
{
    private $password, $random_string;

    public function __construct()
    {
        $this->random_string = Str::random(7);
        $this->password = Hash::make($this->random_string);
    }

    public function sendEmail($user)
    {
        $intro  = 'Dear Subscriber,';
        $content  = 'In this evolving world where almost everything is digitized, it became a challenge to send hard copies of Miti Magazine by postal means from Africa. We however value you as a subscriber and therefore found it a suitable opportunity to switch your magazine subscription to Digital. Moreover, as a gift, you have now access to ALL former issues in reading format or as a downloadable PDF. 
        To access the magazines’ press the link below.
        ';
        $credentials = 'Your credentials are:' . '<br>' .
            'Email: ' . $user->email . '<br>' .
            'Password: ' . $this->random_string;
        Mail::to($user)->send(new NotifyUserOfNewMagazine($intro, $content, $credentials));
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $user_exists = User::where('email', $row['email'])->first();
        $country = Country::where('country', $row['country'])->first();
        if ($country == '' && $row['country'] != '') {
            $country = Country::create(['country' => $row['country']]);
        }
        if ($user_exists == '' && $row['first_name'] != '') {
            $user = User::create([
                "name" => $row['first_name'] . " " . $row['last_name'],
                "email" => $row['email'],
                "country" => $country->id ?? '',
                "user_type" => true,
                "password" => $this->password
            ]);

            Shipping::create([
                'user_id' =>  $user->id,
                'address' =>  $row['address'] ?? '',
                'zip_code' =>  $row['zip_code'] ?? '',
                'city' =>  $row['city'] ?? '',
                'state' =>  $row['state'] ?? '',
            ]);


            $this->sendEmail($user);
        }
    }
}
