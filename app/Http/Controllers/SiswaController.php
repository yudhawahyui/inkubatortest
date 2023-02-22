<?php

namespace App\Http\Controllers;

use App\Models\SiswaModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //show all data
        $siswa = SiswaModel::orderBy('id', 'desc')->paginate(10);
        return view('pages.show', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //create new data
        $siswa = SiswaModel::all();
        $siswa->toArray();
        return view('pages.create', ['siswa' => $siswa]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //stores new data
        Session::flash('name', $request->name);
        Session::flash('alamat', $request->alamat);
        Session::flash('agama', $request->agama);
        Session::flash('jenis_kelamin', $request->jenis_kelamin);
        Session::flash('seklah_asal', $request->seklah_asal);

        $request->validate([
            'name' => 'required',
            'alamat' => 'required',
            'agama' => 'required',
            'jenis_kelamin' => 'required',
            'sekolah_asal' => 'required',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'agama.required' => 'Agama tidak boleh kosong',
            'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong',
            'sekolah_asal.required' => 'Sekolah Asal tidak boleh kosong',
        ]);

        $siswa = new SiswaModel();
        $siswa->name = $request->name;
        $siswa->alamat = $request->alamat;
        $siswa->agama = $request->agama;
        $siswa->jenis_kelamin = $request->jenis_kelamin;
        $siswa->sekolah_asal = $request->sekolah_asal;
        $siswa->save();
        return redirect('pages')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $siswa = SiswaModel::where('id', $id,)->first();

        return view('pages.show', ['siswa' => $siswa]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $siswa = SiswaModel::where('id', $id,)->first();

        return view('pages.edit', ['siswa' => $siswa]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Session::flash('name', $request->name);
        Session::flash('alamat', $request->alamat);
        Session::flash('agama', $request->agama);
        Session::flash('jenis_kelamin', $request->jenis_kelamin);
        Session::flash('seklah_asal', $request->seklah_asal);

        $request->validate([
            'name' => 'required',
            'alamat' => 'required',
            'agama' => 'required',
            'jenis_kelamin' => 'required',
            'sekolah_asal' => 'required',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'agama.required' => 'Agama tidak boleh kosong',
            'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong',
            'sekolah_asal.required' => 'Sekolah Asal tidak boleh kosong',
        ]);

        $siswa = [
            'name' => $request->name,
            'alamat' => $request->alamat,
            'agama' => $request->agama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'sekolah_asal' => $request->sekolah_asal,
        ];
        SiswaModel::where('id', $id,)->update($siswa);

        return redirect('pages')->with('update', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        SiswaModel::where('id',$id)->delete();
        return redirect()->to('pages')->with('delete', 'Data berhasil dihapus!');
    }
}
