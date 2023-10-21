<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    public function format()
    {
        return [
            'store' => [
                'id' => $this->id,
                'name' => $this->name,
                'email_contract' => $this->email_contract,
                'phone_number' => $this->phone_number,
                'address' => $this->address,
                'logo' => $this->logo,
            ],
            'user' =>  $this->store_user
        ];
    }
    public function store_user()
    {
return $this->hasMany(StoreUser::Class);
    }
}
