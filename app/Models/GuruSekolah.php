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

    protected $casts = [
        'guru_id' => 'integer',
        'sekolah_id' => 'integer',
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
