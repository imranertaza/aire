<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'audiences',
        'total_recipients',
        'sent_count',
        'failed_count',
        'status',
    ];
}
