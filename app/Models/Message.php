<?php

namespace Models;

use Core\Model;

class Message extends Model
{

    protected string $table = 'messages';

    protected array $fillable = [
        'message'
    ];


}