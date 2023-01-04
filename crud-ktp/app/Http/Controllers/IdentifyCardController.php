<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use App\Models\IdentifyCard;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Province;
use App\Exports\IdentifyCardExport;
use App\Imports\IdentifyCardImport;
use App\Models\Profession;
use Maatwebsite\Excel\Facades\Excel;

class IdentifyCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = IdentifyCard::with('province')->with('city')->with('district')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        $btn = $btn.'<a href="'.route('identify-card.edit', $row->id).'" class="edit btn btn-primary btn-sm mr-2">Edit</a>';
                        $btn = $btn.'<a href="'.route('identify-card.destroy', $row->id).'" class="edit btn btn-danger btn-sm" onclick="event.preventDefault(); document.getElementById(\'identify-card-'.$row->id.'\').submit();">Delete</a>';
                        $btn = $btn.'<form id="identify-card-'.$row->id.'" action="'.route('identify-card.destroy', $row->id).'" method="POST" class="d-none">
                                '.csrf_field().'
                                '.method_field("DELETE").'</form>';
                        return $btn;
                    })
                    ->addColumn('foto', function($data){
                        if ($data->foto != '') {
                            return url('storage/images/'.$data->foto);
                        }
                        return url('template/images/image-not-found.png');
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('identify-card.index', [
            'title' => 'Kartu Tanda Penduduk',
            'active' => 'identify-card'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('identify-card.create', [
            'title' => 'Buat Kartu Tanda Penduduk',
            'active' => 'identify-card',
            'provinces' => Province::orderBy('code', 'ASC')->get(),
            'agama' => array('islam', 'kristen', 'katolik', 'hindu', 'budha', 'konghucu'),
            'status_perkawinan' => ['kawin', 'belum kawin'],
            'kewarganegaraan' => ['wni', 'wna'],
            'pekerjaan' => Profession::all()
        ]);
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
            return redirect('/identify-card')->with('success', 'KTP baru telah berhasil ditambahkan');
        }
        return redirect('/identify-card')->with('error', 'KTP baru telah gagal ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IdentifyCard  $identifyCard
     * @return \Illuminate\Http\Response
     */
    public function show(IdentifyCard $identifyCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IdentifyCard  $identifyCard
     * @return \Illuminate\Http\Response
     */
    public function edit(IdentifyCard $identifyCard)
    {
        return view('identify-card.edit', [
            'title' => 'Buat Kartu Tanda Penduduk',
            'active' => 'identify-card',
            'identify_card' => $identifyCard,
            'provinces' => Province::orderBy('code', 'ASC')->get(),
            'cities' => City::where('provinces_id', Province::find($identifyCard->provinsi)->code)->get(),
            'districts' => District::where('cities_id', City::find($identifyCard->kabupaten)->code)->get(),
            'agama' => array('islam', 'kristen', 'katolik', 'hindu', 'budha', 'konghucu'),
            'status_perkawinan' => ['kawin', 'belum kawin'],
            'kewarganegaraan' => ['wni', 'wna'],
            'pekerjaan' => Profession::all()
        ]);
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
            return redirect('/identify-card')->with('success', 'KTP telah berhasil diedit');
        }
        return redirect('/identify-card')->with('error', 'KTP telah gagal diedit');
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
            return redirect('/identify-card')->with('success', 'KTP telah berhasil dihapus');
        }
        return redirect('/identify-card')->with('error', 'KTP telah gagal dihapus');
    }

    public function importExportView()
    {
       return view('identify-card.import');
    }
     
    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new IdentifyCardExport, 'users.csv');
    }
     
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request) 
    {
        $fileName = time().'_'.$request->file('file')->getClientOriginalName();
        $request->file('file')->storeAs('reports', $fileName, 'public');
        if(Excel::import(new IdentifyCardImport, $request->file('file'))){
            return redirect('/identify-card')->with('success', 'KTP telah berhasil di import');
        }
        return redirect('/identify-card')->with('error', 'KTP telah gagal di import');
    }
}
