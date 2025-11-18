<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruSekolah extends Model
{
    protected $table = 'guru_sekolahs';

    protected $fillable = [
        'guru_id',
        'sekolah_id',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}
