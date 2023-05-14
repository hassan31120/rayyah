<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    protected $table = 'attachments';
    protected $fillable = [
        'type', 'usage', 'path',
    ];
    public function attachable()
    {
        return $this->morphTo();
    }
    public $timestamps = true;

}