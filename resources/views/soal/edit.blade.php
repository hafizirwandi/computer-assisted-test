  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  <div class="text-center mb-4">
      <h3 class="mb-2 modal-title">Tambah Soal</h3>
  </div>

  <form class="row g-3" method="post" action="{{ route('soal.update', $data->id) }}">
      @csrf
      @method('put')
      <div class="col-12 col-md-12">
          <label class="form-label">Nama</label>
          <input type="text" name="nama" class="form-control" value="{{ $data->nama }}" placeholder="Enter Text"
              required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Matapelajaran</label>
          <select class="form-control" name="matapelajaran_id" placeholder="Enter Text" required>
              <option value="">-- Pilih --</option>
              @foreach ($matapelajaran as $r)
                  <option value="{{ $r->id }}" {{ $data->matapelajaran->id == $r->id ? 'selected' : '' }}>
                      {{ $r->nama }}</option>
              @endforeach
          </select>
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Kode Soal</label>
          <input type="text" name="kode_soal" class="form-control" value="{{ $data->kode_soal }}"
              placeholder="Enter Text" required />
          <small class="text-danger">Kode Soal bersifat unik</small>
      </div>



      <div class="col-12 text-center">
          <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
          <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
              Cancel
          </button>
      </div>
  </form>
