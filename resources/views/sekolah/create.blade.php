  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  <div class="text-center mb-4">
      <h3 class="mb-2 modal-title">Tambah Sekolah</h3>
  </div>

  <form class="row g-3" method="post" action="{{ route('sekolah.store') }}">
      @csrf
      <div class="col-12 col-md-6">
          <label class="form-label">Kode Sekolah</label>
          <input type="text" name="kode_sekolah" class="form-control" placeholder="Enter Text" required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Nama Sekolah</label>
          <input type="text" name="nama" class="form-control" placeholder="Enter Text" required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Telepon</label>
          <input type="text" name="telp" class="form-control" placeholder="Enter Text" required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" placeholder="example@domain.com" required />
      </div>
      <div class="col-12 col-md-12">
          <label class="form-label">Alamat</label>
          <textarea type="text" name="alamat" class="form-control" rows="5" placeholder="Enter Text"></textarea>
      </div>


      <div class="col-12 text-center">
          <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
          <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
              Cancel
          </button>
      </div>
  </form>
