<?php

namespace App\Models;

use Database\Factories\DonneeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['titre', 'description', 'utilisateur_id'])]
class Donnee extends Model
{
    /** @use HasFactory<DonneeFactory> */
    use HasFactory;

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }
}
