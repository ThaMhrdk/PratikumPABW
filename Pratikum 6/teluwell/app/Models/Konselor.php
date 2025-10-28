<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konselor extends Model
{
    use HasFactory;

    // 1. Beri tahu Laravel nama tabel yang benar
    protected $table = 'konselor';

    // 2. Beri tahu Laravel nama Primary Key yang benar
    protected $primaryKey = 'Idkonselor';

    // 3. Beri tahu Laravel bahwa PK-nya BUKAN angka (tapi string/char)
    protected $keyType = 'string';

    // 4. Beri tahu Laravel bahwa PK-nya BUKAN auto-increment
    public $incrementing = false;

    // 5. Beri tahu Laravel bahwa tabel ini TIDAK punya kolom created_at/updated_at
    public $timestamps = false;
}