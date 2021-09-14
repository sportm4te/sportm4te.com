<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatConvo extends Model
{
    use HasFactory;

    public function contact_details(){

        return User::where('id',$this->id)->first();
    }
}
