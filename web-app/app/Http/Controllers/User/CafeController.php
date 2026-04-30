<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\KafeModel;
use Illuminate\Http\Request;

class CafeController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');


        if ($category) {
            $query = KafeModel::with(['menus', 'gambar', 'fasilitas'])
                ->withCount(['fasilitas', 'menus']);

            switch ($category) {
                case 'terdekat':
                    $query->orderBy('jarak', 'asc');
                    $title = "Kafe Terdekat dari Kampus";
                    break;
                case 'fasilitas':
                    $query->orderBy('fasilitas_count', 'desc');
                    $title = "Fasilitas Paling Sultan";
                    break;
                case 'menu':
                    $query->orderBy('menus_count', 'desc');
                    $title = "Variasi Menu Terbanyak";
                    break;
                case '24jam':
                    $query->where('jam_buka', '00:00')
                          ->where('jam_tutup', '23:59');
                    $title = "Buka 24 Jam";
                    break;
                default:
                    $query->orderBy('nama_kafe', 'asc');
                    $title = "Semua Kafe";
            }

            $cafes = $query->paginate(12);
            $allFasilitas = \App\Models\FasilitasModel::all();
            $allMenus = \App\Models\MenuModel::all();
            return view('pages.user.list-cafe', compact('cafes', 'title', 'allFasilitas', 'allMenus'));
        }

        
        $terdekat = KafeModel::with(['menus', 'gambar', 'fasilitas'])->orderBy('jarak', 'asc')->take(3)->get();
        $sultan = KafeModel::with(['menus', 'gambar', 'fasilitas'])->withCount('fasilitas')->orderBy('fasilitas_count', 'desc')->take(3)->get();
        $menuLengkap = KafeModel::with(['menus', 'gambar', 'fasilitas'])->withCount('menus')->orderBy('menus_count', 'desc')->take(3)->get();
        $buka24jam = KafeModel::with(['menus', 'gambar', 'fasilitas'])
            ->where('jam_buka', '00:00')
            ->where('jam_tutup', '23:59')
            ->take(3)
            ->get();

        return view('pages.user.index-cafe', compact('terdekat', 'sultan', 'menuLengkap', 'buka24jam'));
    }

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

    public function searchApi(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $cafes = KafeModel::where('nama_kafe', 'like', '%' . $query . '%')
            ->take(5)
            ->get(['id_kafe', 'nama_kafe', 'jarak']);

        return response()->json($cafes);
    }
}
