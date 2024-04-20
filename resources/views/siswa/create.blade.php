  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  <div class="text-center mb-4">
      <h3 class="mb-2 modal-title">Tambah Siswa</h3>
  </div>

  <form class="row g-3" method="post" action="{{ route('siswa.store') }}">
      @csrf
      <div class="col-12 col-md-6">
          <label class="form-label">NIS</label>
          <input type="text" name="nis" class="form-control" placeholder="Enter Text" required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Nama</label>
          <input type="text" name="nama" class="form-control" placeholder="Enter Text" required />
      </div>
      {{-- <div class="col-12 col-md-6">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" placeholder="Enter Text" required />
      </div> --}}
      <div class="col-12 col-md-6">
          <label class="form-label">Sekolah</label>
          <select name="sekolah_id" class="form-control" placeholder="Enter Text" required>

              @foreach ($sekolah as $r)
                  <option value="{{ $r->id }}">{{ $r->nama }}</option>
              @endforeach
          </select>
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Kelas</label>
          <input type="text" name="kelas" class="form-control" placeholder="Enter Text" required />
      </div>
      {{-- <div class="col-12 col-md-6">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" placeholder="Enter Text" required />
      </div> --}}
      <div class="col-12 col-md-6">
          <label class="form-label">Status</label>
          <select name="status" class="form-control" required>
              <option value="">-- Pilih --</option>
              <option value="0">Pending</option>
              <option value="1">Active</option>
              <option value="2">Inactive</option>
          </select>
      </div>

      <div class="col-12 text-center">
          <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
          <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
              Cancel
          </button>
      </div>
  </form>
