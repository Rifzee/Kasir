<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['nama', 'alamat', 'telepon','nama_perusahaan'];

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class);
    }
}
