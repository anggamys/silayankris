<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'beritas';

    protected $fillable = [
        'user_id',
        'judul',
        'slug',
        'isi',
        'gambar_path',
        'status',
    ];

    protected $casts = [
        'user_id' => 'integer',
    ];

    /**
     * Boot method untuk generate slug otomatis.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            $berita->slug = static::generateUniqueSlug($berita->judul);
        });

        static::updating(function ($berita) {
            // Jika judul berubah, slug ikut berubah + tetap unique
            if ($berita->isDirty('judul')) {
                $berita->slug = static::generateUniqueSlug($berita->judul, $berita->id);
            }
        });
    }

    /**
     * Fungsi untuk membuat slug unik.
     */
    public static function generateUniqueSlug($judul, $ignoreId = null)
    {
        $slug = Str::slug($judul);
        $original = $slug;
        $counter = 1;

        // Cek apakah slug sudah ada
        while (
            static::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = "{$original}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    /**
     * Relasi: satu berita dimiliki satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
