  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  <div class="text-center mb-4">
      <h3 class="mb-2 modal-title">Edit Nilai Cloud</h3>
  </div>

  <form class="row g-3" method="post" action="{{ route('rekap-nilai-global.update', $data->id) }}">
      @csrf
      @method('put')
      <div class="col-12 col-md-6">
          <label class="form-label">Kode Sekolah</label>
          <input type="text" name="kode_sekolah" class="form-control" placeholder="Enter Text"
              value="{{ $data->kode_sekolah }}" required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Nama Sekolah</label>
          <input type="text" name="nama_sekolah" class="form-control" placeholder="Enter Text"
              value="{{ $data->nama_sekolah }}" required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Kode Ujian</label>
          <input type="text" name="kode_ujian" class="form-control" placeholder="Enter Text"
              value="{{ $data->kode_ujian }}" required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Matapelajaran</label>
          <input type="text" name="matapelajaran" class="form-control" placeholder="Enter Text"
              value="{{ $data->matapelajaran }}" required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">NIS</label>
          <input type="text" name="nis" class="form-control" placeholder="Enter Text" value="{{ $data->nis }}"
              required />
      </div>

      <div class="col-12 col-md-6">
          <label class="form-label">Nama Siswa</label>
          <input type="text" name="nama_siswa" class="form-control" placeholder="Enter Text"
              value="{{ $data->nama_siswa }}" required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Kelas</label>
          <input type="text" name="kelas" class="form-control" placeholder="Enter Text" value="{{ $data->kelas }}"
              required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Jlh Soal</label>
          <input type="text" name="jlh_soal" class="form-control" placeholder="Enter Text"
              value="{{ $data->jlh_soal }}" required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Jlh Jawab Benar</label>
          <input type="number" name="jlh_jawab_benar" class="form-control" placeholder="Enter Text"
              value="{{ $data->jlh_jawab_benar }}" required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Jlh Jawab Salah</label>
          <input type="number" name="jlh_jawab_salah" class="form-control" placeholder="Enter Text"
              value="{{ $data->jlh_jawab_salah }}" required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Jlh Tidak Jawab</label>
          <input type="number" name="jlh_tidak_jawab" class="form-control" placeholder="Enter Text"
              value="{{ $data->jlh_tidak_jawab }}" required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Nilai</label>
          <input type="number" name="nilai" class="form-control" placeholder="Enter Text"
              value="{{ $data->nilai }}" required />
      </div>
      <div class="col-12 text-center">
          <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
          <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
              Cancel
          </button>
      </div>
  </form>
