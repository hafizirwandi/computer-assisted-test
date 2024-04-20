  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  <div class="text-center mb-4">
      <h3 class="mb-2 modal-title">Reset Ujian</h3>
  </div>

  <form class="row g-3" method="post" action="{{ route('reset-ujian.update', $data->id) }}">
      @csrf
      @method('put')
      <div class="col-12 col-md-12">
          <label class="form-label">Keterangan</label>
          <textarea type="text" name="keterangan" class="form-control" rows="5" placeholder="Enter Text" required>{{ $data->keterangan }}</textarea>
      </div>


      <div class="col-12 text-center">
          <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
          <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
              Cancel
          </button>
      </div>
  </form>
