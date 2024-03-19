  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  <div class="text-center mb-4">
      <h3 class="mb-2 modal-title">Import Siswa</h3>
      <p>Download contoh file import siswa <a href="{{ url('download/template_siswa.xlsx') }}">Download</a> </p>
  </div>

  <form class="row g-3" method="post" action="{{ route('siswa.uploadImportFile') }}" enctype="multipart/form-data">
      @csrf



      <div class="col-12 col-md-6">
          <label class="form-label">Sekolah</label>
          <select name="sekolah_id" class="form-control" placeholder="Enter Text" required>
              <option value="">-- Pilih --</option>
              @foreach ($sekolah as $r)
                  <option value="{{ $r->id }}">{{ $r->nama }}</option>
              @endforeach
          </select>
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">File</label>
          <input type="file" name="excel_file" class="form-control" required>
      </div>

      <div class="col-12 text-center">
          <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
          <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
              Cancel
          </button>
      </div>
  </form>

  {{-- <hr>
  <small class="text-danger">
      <span>Kondisi Import</span>
      <ul>
          <li>Replace => Mengganti data lama dengan data yang baru diimport ke sistem berdasarkan NIS</li>
          <li>Ignore => Mengabaikan data jika terdapat duplikat NIS pada data lama dan baru</li>
      </ul>
  </small> --}}
