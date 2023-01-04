<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\IdentifyCard;
use Illuminate\Http\Request;

class IdentifyCardApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(IdentifyCard::with('province')->with('city')->with('district')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'nik' => $request->input('nik'),
            'nama' => $request->input('nama'),
            'tempat_lahir' => $request->input('tempat_lahir'),
            'tgl_lahir' => $request->input('tgl_lahir'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'provinsi' => $request->input('provinsi'),
            'kabupaten' => $request->input('kabupaten'),
            'kecamatan' => $request->input('kecamatan'),
            'desa' => $request->input('desa'),
            'alamat' => $request->input('alamat'),
            'rt' => $request->input('rt'),
            'rw' => $request->input('rw'),
            'agama' => $request->input('agama'),
            'status_perkawinan' => $request->input('status_perkawinan'),
            'pekerjaan' => $request->input('pekerjaan'),
            'kewarganegaraan' => $request->input('kewarganegaraan'),
        ];
        $save = IdentifyCard::create($data);
        if($save){
            if ($request->file('foto')) {
                $filenameWithExt = $request->file('foto')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('foto')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('foto')->storeAs('public/images', $filenameSimpan);
                IdentifyCard::where('id', $save->id)->update(['foto' => $filenameSimpan]);
            }
            return response()->json(['KTP baru telah berhasil ditambahkan.', IdentifyCard::find($save->id)]);
        }
        return response()->json(['KTP baru telah gagal ditambahkan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IdentifyCard  $identifyCard
     * @return \Illuminate\Http\Response
     */
    public function show(IdentifyCard $identifyCard)
    {
        if (is_null($identifyCard)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([$identifyCard]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IdentifyCard  $identifyCard
     * @return \Illuminate\Http\Response
     */
    public function edit(IdentifyCard $identifyCard)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IdentifyCard  $identifyCard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IdentifyCard $identifyCard)
    {
        $data = [
            'nik' => $request->input('nik'),
            'nama' => $request->input('nama'),
            'tempat_lahir' => $request->input('tempat_lahir'),
            'tgl_lahir' => $request->input('tgl_lahir'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'provinsi' => $request->input('provinsi'),
            'kabupaten' => $request->input('kabupaten'),
            'kecamatan' => $request->input('kecamatan'),
            'desa' => $request->input('desa'),
            'alamat' => $request->input('alamat'),
            'rt' => $request->input('rt'),
            'rw' => $request->input('rw'),
            'agama' => $request->input('agama'),
            'status_perkawinan' => $request->input('status_perkawinan'),
            'pekerjaan' => $request->input('pekerjaan'),
            'kewarganegaraan' => $request->input('kewarganegaraan'),
        ];
        $save = $identifyCard->update($data);
        if($save){
            if ($request->file('foto')) {
                if($identifyCard->foto != ''){
                    unlink(storage_path('app/public/images/'.$identifyCard->foto));
                }
                $filenameWithExt = $request->file('foto')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('foto')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('foto')->storeAs('public/images', $filenameSimpan);
                IdentifyCard::where('id', $identifyCard->id)->update(['foto' => $filenameSimpan]);
            }
            return response()->json(['KTP baru telah berhasil diedit.', $identifyCard]);
        }
        return response()->json(['KTP baru telah gagal diedit']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IdentifyCard  $identifyCard
     * @return \Illuminate\Http\Response
     */
    public function destroy(IdentifyCard $identifyCard)
    {
        if($identifyCard->foto != ''){
            unlink(storage_path('app/public/images/'.$identifyCard->foto));
        }
        if($identifyCard->delete()){
            return response()->json(['KTP baru telah berhasil dihapus.']);
        }
        return response()->json(['KTP baru telah gagal dihapus']);
    }
}
