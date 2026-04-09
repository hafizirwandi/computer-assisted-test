<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\ButirSoal;
use App\Models\ButirSoal2;
use App\Models\ButirSoal3;
use App\Models\ButirSoal4;
use App\Models\RefButirSoal;
use App\Models\PemetaanSoal;
use App\Models\PengaturanUjian;
use Illuminate\Http\Request;
use App\Models\Matapelajaran;

class SoalController extends Controller
{
    public function index()
    {
        $data['data'] = Soal::all();

        return view('soal.index', $data);
    }

    public function create()
    {
        $data['matapelajaran'] = Matapelajaran::all();
        return view('soal.create', $data);
    }
    public function edit($id)
    {
        $data['data'] = Soal::findOrFail($id);
        $data['matapelajaran'] = Matapelajaran::all();
        return view('soal.edit', $data);
    }
    public function detail($id)
    {
        $data['soal'] = Soal::findOrFail($id);
        $data['data'] = RefButirSoal::with(['butirSoal', 'butirSoal2', 'butirSoal3', 'butirSoal4', 'soal'])
            ->where('soal_id', $id)
            ->get();
        return view('soal.detail', $data);
    }
    public function saveOrUpdate(Request $request, $id = null)
    {
        try {
            if ($id != null) {
                $soal = Soal::findOrFail($id);
                $data = $request->except(['_token', '_method']);
                $soal->where('id', $id)->update($data);

                $msg = 'Soal berhasil diperbaharui';
            } else {
                $data = $request->all();
                Soal::create($data);
                $msg = 'Soal berhasil dibuat';
            }
            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->input('id');

            // Cek apakah soal ini sedang dipakai diujian aktif
            if (\App\Models\PengaturanUjian::where('soal_id', $id)->exists()) {
                return back()->with('error', 'Gagal: Bank Soal tidak bisa dihapus karena sedang tertaut di Pengaturan Ujian.');
            }
            if (\App\Models\PemetaanSoal::where('soal_id', $id)->exists()) {
                return back()->with('error', 'Gagal: Bank Soal tidak bisa dihapus karena sedang tertaut di Pemetaan Ujian.');
            }

            // Hapus manual secara berurutan beserta file gambarnya
            $bs1 = \App\Models\ButirSoal::where('soal_id', $id)->get();
            foreach ($bs1 as $bs) {
                $this->deleteImagesFromText($bs->soal . $bs->jawaban_a . $bs->jawaban_b . $bs->jawaban_c . $bs->jawaban_d . $bs->jawaban_e);
                $bs->delete();
            }

            $bs2 = \App\Models\ButirSoal2::where('soal_id', $id)->get();
            foreach ($bs2 as $bs) {
                $this->deleteImagesFromText($bs->soal . $bs->jawaban_a . $bs->jawaban_b . $bs->jawaban_c . $bs->jawaban_d . $bs->jawaban_e);
                $bs->delete();
            }

            $bs3 = \App\Models\ButirSoal3::where('soal_id', $id)->get();
            foreach ($bs3 as $bs) {
                $this->deleteImagesFromText($bs->soal);
                $bs->delete();
            }

            $bs4 = \App\Models\ButirSoal4::where('soal_id', $id)->get();
            foreach ($bs4 as $bs) {
                $this->deleteImagesFromText($bs->soal);
                $bs->delete();
            }

            \App\Models\RefButirSoal::where('soal_id', $id)->delete();

            // Baru hapus parent row (Soal)
            Soal::destroy($id);

            return back()->with('success', 'Soal beserta anak soal berhasil dihapus');
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), '1451') !== false) {
                return back()->with('error', 'Gagal menghapus: Data soal ini masih digunakan oleh data nilai atau yang lainnya.');
            }
            return back()->with('error', $e->getMessage());
        }
    }

    public function createButirSoal($id)
    {
        $data['soal'] = Soal::findOrFail($id);

        return view('soal.butirsoal.create', $data);
    }
    public function editButirSoal($id)
    {
        $data['data'] = RefButirSoal::with(['butirSoal', 'butirSoal2', 'butirSoal3', 'butirSoal4', 'soal'])->findOrFail($id);
        return view('soal.butirsoal.edit', $data);
    }

    public function saveOrUpdateButirSoal(Request $request, $id = null)
    {
        try {
            $rules = [
                'tipe_optional_jawaban' => 'required',
                'soal' => 'required',
                'soal_id' => 'required',
                'jawaban_a' => 'nullable',
                'jawaban_b' => 'nullable',
                'jawaban_c' => 'nullable',
                'jawaban_d' => 'nullable',
                'jawaban_e' => 'nullable',
                'jawaban_benar' => 'nullable',
                'poin_benar' => 'nullable',
            ];
            if ($id != null) {
                $data = $request->validate($rules);
                $bs = ButirSoal::findOrFail($id);
                $bs->where('id', $id)->update($data);

                $msg = 'Butir Soal berhasil diperbaharui';
            } else {
                $data = $request->validate($rules);
                $bs = ButirSoal::create($data);
                $msg = 'Butir Soal berhasil dibuat';
                $id = $bs->id;
                $ref = [
                    'soal_id' => $data['soal_id'],
                    'ref_butir_soal' => '1',
                    'butir_soal_id' => $id,
                ];
                RefButirSoal::create($ref);
            }
            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function saveOrUpdateButirSoal2(Request $request, $id = null)
    {
        try {
            $rules = [
                'tipe_optional_jawaban' => 'required',
                'soal' => 'required',
                'soal_id' => 'required',
                'jawaban_a' => 'nullable',
                'jawaban_b' => 'nullable',
                'jawaban_c' => 'nullable',
                'jawaban_d' => 'nullable',
                'jawaban_e' => 'nullable',
                'poin_benar_a' => 'nullable',
                'poin_benar_b' => 'nullable',
                'poin_benar_c' => 'nullable',
                'poin_benar_d' => 'nullable',
                'poin_benar_e' => 'nullable',
            ];
            if ($id != null) {
                $data = $request->validate($rules);
                $bs = ButirSoal2::findOrFail($id);
                $bs->where('id', $id)->update($data);

                $msg = 'Butir Soal berhasil diperbaharui';
            } else {
                $data = $request->validate($rules);
                $bs = ButirSoal2::create($data);
                $msg = 'Butir Soal berhasil dibuat';
                $id = $bs->id;
                $ref = [
                    'soal_id' => $data['soal_id'],
                    'ref_butir_soal' => '2',
                    'butir_soal_id' => $id,
                ];
                RefButirSoal::create($ref);
            }
            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function saveOrUpdateButirSoal3(Request $request, $id = null)
    {
        try {
            // dd($request->input());

            $rules = [
                'optional_jawaban' => 'required',
                'soal' => 'required',
                'soal_id' => 'required',
            ];
            if ($id != null) {
                $data = $request->validate($rules);
                $data['optional_jawaban'] = json_encode(explode(',', $request->input('optional_jawaban')));
                $data['pernyataan_soal'] = json_encode($request->input('pernyataan_soal'));
                $temp = [];
                for ($i = 0; $i < count($request->input('pernyataan_soal')); $i++) {
                    $array = [];
                    for ($j = 0; $j < count(explode(',', $request->input('optional_jawaban'))); $j++) {
                        array_push($array, $request->input('poin_benar_' . $j)[$i]);
                    }
                    $temp[] = $array;
                }
                $data['poin_benar'] = json_encode($temp);

                $bs = ButirSoal3::findOrFail($id);
                $bs->where('id', $id)->update($data);

                $msg = 'Butir Soal berhasil diperbaharui';
            } else {
                $data = $request->validate($rules);
                $data['optional_jawaban'] = json_encode(explode(',', $request->input('optional_jawaban')));
                $data['pernyataan_soal'] = json_encode($request->input('pernyataan_soal'));
                $temp = [];
                for ($i = 0; $i < count($request->input('pernyataan_soal')); $i++) {
                    $array = [];
                    for ($j = 0; $j < count(explode(',', $request->input('optional_jawaban'))); $j++) {
                        array_push($array, $request->input('poin_benar_' . $j)[$i]);
                    }
                    $temp[] = $array;
                }
                $data['poin_benar'] = json_encode($temp);

                $bs = ButirSoal3::create($data);
                $msg = 'Butir Soal berhasil dibuat';
                $id = $bs->id;
                $ref = [
                    'soal_id' => $data['soal_id'],
                    'ref_butir_soal' => '3',
                    'butir_soal_id' => $id,
                ];
                RefButirSoal::create($ref);
            }
            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function saveOrUpdateButirSoal4(Request $request, $id = null)
    {
        try {
            $rules = [
                'kunci_kata' => 'required',
                'soal' => 'required',
                'soal_id' => 'required',
                'jawaban' => 'required',
                'poin_minimal' => 'required',
                'poin_maksimal' => 'required',
            ];
            if ($id != null) {
                $data = $request->validate($rules);
                $bs = ButirSoal4::findOrFail($id);
                $bs->where('id', $id)->update($data);

                $msg = 'Butir Soal berhasil diperbaharui';
            } else {
                $data = $request->validate($rules);
                $bs = ButirSoal4::create($data);
                $msg = 'Butir Soal berhasil dibuat';
                $id = $bs->id;
                $ref = [
                    'soal_id' => $data['soal_id'],
                    'ref_butir_soal' => '4',
                    'butir_soal_id' => $id,
                ];
                RefButirSoal::create($ref);
            }
            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function destroyButirSoal(Request $request)
    {
        try {
            $q = RefButirSoal::findOrFail($request->input('id'));
            $delete = false;
            if ($q->ref_butir_soal == '1') {
                $bs = ButirSoal::find($q->butir_soal_id);
                if ($bs) {
                    $this->deleteImagesFromText($bs->soal . $bs->jawaban_a . $bs->jawaban_b . $bs->jawaban_c . $bs->jawaban_d . $bs->jawaban_e);
                    $delete = $bs->delete();
                }
            } elseif ($q->ref_butir_soal == '2') {
                $bs = ButirSoal2::find($q->butir_soal_id);
                if ($bs) {
                    $this->deleteImagesFromText($bs->soal . $bs->jawaban_a . $bs->jawaban_b . $bs->jawaban_c . $bs->jawaban_d . $bs->jawaban_e);
                    $delete = $bs->delete();
                }
            } elseif ($q->ref_butir_soal == '3') {
                $bs = ButirSoal3::find($q->butir_soal_id);
                if ($bs) {
                    $this->deleteImagesFromText($bs->soal);
                    $delete = $bs->delete();
                }
            } elseif ($q->ref_butir_soal == '4') {
                $bs = ButirSoal4::find($q->butir_soal_id);
                if ($bs) {
                    $this->deleteImagesFromText($bs->soal);
                    $delete = $bs->delete();
                }
            }
            if ($delete) {
                $q->delete();
            }

            return back()->with('success', 'Soal berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function uploadImage(Request $request)
    {
        try {
            $request->validate(['image' => 'required|image|max:5120']); // max 5MB
            $path = $request->file('image')->store('soal-images', 'public');

            // Best practice: kembalikan URL RELATIF agar portable di semua hosting
            // Hasilnya: /storage/soal-images/namafile.jpg
            $relativeUrl = '/storage/' . $path;
            return response()->json(['url' => $relativeUrl]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function deleteImagesFromText($text)
    {
        if (!$text) {
            return;
        }
        preg_match_all('/<img[^>]+src="([^">]+)"/', $text, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $src) {
                // Handle URL relatif maupun absolut yang mengandung path storage/soal-images
                if (strpos($src, 'soal-images') !== false) {
                    // Ambil bagian path setelah 'storage/' saja
                    if (preg_match('/storage\/(.+)$/', $src, $pathMatch)) {
                        $storagePath = $pathMatch[1];
                        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($storagePath)) {
                            \Illuminate\Support\Facades\Storage::disk('public')->delete($storagePath);
                        }
                    }
                }
            }
        }
    }
}
