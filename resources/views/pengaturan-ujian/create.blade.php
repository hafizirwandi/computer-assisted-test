  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  <div class="text-center mb-4">
      <h3 class="mb-2 modal-title">Tambah Pengaturan Ujian</h3>
  </div>

  <form class="row g-3" method="post" action="{{ route('pengaturan-ujian.store') }}">
      @csrf
      <div class="col-12 col-md-6">
          <label class="form-label">Kode Ujian</label>
          <input type="text" name="kode_ujian" class="form-control" placeholder="Enter Text" required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Tanggal Ujian</label>
          <input type="date" name="tanggal_ujian" class="form-control" placeholder="Enter Text" required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Soal</label>
          <select name="soal_id" class="form-control" required>
              <option value="">-- Pilih --</option>
              @foreach ($soal as $r)
                  <option value="{{ $r->id }}">
                      {{ $r->kode_soal . ' - ' . $r->nama }}</option>
              @endforeach

          </select>
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Soal Random</label>
          <select name="is_random" class="form-control" required>
              <option value="">-- Pilih --</option>
              <option value="1">Ya</option>
              <option value="0">Tidak</option>

          </select>
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Status</label>
          <select name="status" class="form-control" required>
              <option value="">-- Pilih --</option>
              <option value="0">Inactive</option>
              <option value="1">Active</option>
          </select>
      </div>



      <div class="col-12 text-center">
          <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
          <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
              Cancel
          </button>
      </div>
  </form>
