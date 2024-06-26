<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    use HasFactory;
    protected $tables = 'password_reset_tokens';
    protected $primaryKey = 'email';
    public $timestamps = false;
    public $fillable = ['email','token','created_at'];
}
