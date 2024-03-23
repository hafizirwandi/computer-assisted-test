  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  <div class="text-center mb-4">
      <h3 class="mb-2 modal-title">Tambah Pengaturan Ujian</h3>
  </div>

  <form class="row g-3" method="post" action="{{ route('pengaturan-ujian.update', $data->id) }}">
      @csrf
      @method('put')
      <div class="col-12 col-md-6">
          <label class="form-label">Kode Ujian</label>
          <input type="text" name="kode_ujian" class="form-control" value="{{ $data->kode_ujian }}"
              placeholder="Enter Text" required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Tanggal Ujian</label>
          <input type="date" name="tanggal_ujian" class="form-control" value="{{ $data->tanggal_ujian }}"
              placeholder="Enter Text" required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Waktu (menit)</label>
          <div class="input-group input-group-merge">
              <input type="number" name="waktu" value="{{ $data->waktu }}" class="form-control" required>
              <span class="input-group-text">menit</span>
          </div>
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Soal</label>
          <select name="soal_id" class="form-control" required>
              <option value="">-- Pilih --</option>
              @foreach ($soal as $r)
                  <option value="{{ $r->id }}" {{ $data->soal_id == $r->id ? 'selected' : '' }}>
                      {{ $r->kode_soal . ' - ' . $r->nama }}</option>
              @endforeach

          </select>
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Jlh Soal</label>
          <input type="number" name="jlh_soal" class="form-control" value="{{ $data->jlh_soal }}"
              placeholder="Enter Text" required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Soal Random</label>
          <select name="is_random" class="form-control" required>
              <option value="">-- Pilih --</option>
              <option value="1" {{ $data->is_random == '1' ? 'selected' : '' }}>Ya</option>
              <option value="0" {{ $data->is_random == '0' ? 'selected' : '' }}>Tidak</option>

          </select>
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Status</label>
          <select name="status" class="form-control" required>
              <option value="">-- Pilih --</option>
              <option value="0" {{ $data->status == '0' ? 'selected' : '' }}>Inactive</option>
              <option value="1" {{ $data->status == '1' ? 'selected' : '' }}>Active</option>
          </select>
      </div>




      <div class="col-12 text-center">
          <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
          <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
              Cancel
          </button>
      </div>
  </form>
