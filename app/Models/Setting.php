<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAttribute;
use Spatie\Translatable\HasTranslations;



class Setting extends Model
{
    use HasFactory, GetAttribute;
    use HasTranslations;

    public $translatable = ['terms'];

    protected $guarded = [];
}
