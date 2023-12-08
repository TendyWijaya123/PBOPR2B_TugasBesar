<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detail_pesanan';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idDetail';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idPesanan',
        'idMakanan',
        'hargasatuan',
        'jumlah',
        'total',
    ];

    /**
     * Get the order that owns the order detail.
     */
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'idPesanan', 'idPesanan');
    }

    /**
     * Get the menu associated with the order detail.
     */
    public function makanan()
    {
        return $this->belongsTo(Menu::class, 'idMakanan', 'idMakanan');
    }
}
