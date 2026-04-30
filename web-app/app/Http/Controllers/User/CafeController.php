<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\KafeModel;

class CafeController extends Controller
{
    public function show($id)
    {
        $cafe = KafeModel::with(['fasilitas', 'menus', 'gambar'])->findOrFail($id);

        $rekomendasi = KafeModel::with(['menus', 'gambar', 'fasilitas'])
            ->where('id_kafe', '!=', $id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('pages.user.cafe-detail', compact('cafe', 'rekomendasi'));
    }
}
