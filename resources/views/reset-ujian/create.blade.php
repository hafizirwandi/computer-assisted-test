  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  <div class="text-center mb-4">
      <h3 class="mb-2 modal-title">Reset Ujian</h3>
  </div>

  <form class="row g-3" method="post" action="{{ route('reset-ujian.store') }}">
      @csrf
      <div class="col-12 col-md-6">
          <label class="form-label">Ujian</label>
          <select type="text" name="kode_ujian" class="form-control" placeholder="Enter Text" required>
              <option value="">-- Pilih --</option>
              @foreach ($pu as $r)
                  <option value="{{ $r->kode_ujian }}">{{ $r->kode_ujian }} - {{ $r->soal->nama }}</option>
              @endforeach
          </select>


      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Sekolah</label>
          <select name="sekolah_id" class="form-control" placeholder="Enter Text" required id="sekolah">
              <option value="">-- Pilih --</option>
              @foreach ($sekolah as $r)
                  <option value="{{ $r->id }}">{{ $r->nama }}</option>
              @endforeach
          </select>
      </div>
      <div class="col-12 col-md-12">
          <label class="form-label">Siswa</label>
          <select name="nis" class="form-control" placeholder="Enter Text" required id="siswa">
              <option value="">-- Pilih --</option>
          </select>
      </div>
      <div class="col-12 col-md-12">
          <label class="form-label">Keterangan</label>
          <textarea type="text" name="keterangan" class="form-control" rows="5" placeholder="Enter Text"></textarea>
      </div>


      <div class="col-12 text-center">
          <button onclick="return confirm('Apakah anda yakin ? jika ya! maka semua data ujian siswa akan dihapus')"
              type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
          <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
              Cancel
          </button>
      </div>
  </form>
