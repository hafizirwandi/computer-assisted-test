  <table>
      <thead>
          <tr>
              <th>Ujian</th>
              <th>NIS</th>
              <th>Nama</th>
              <th>Kelas</th>
              <th>Jlh Soal</th>
              <th>Jlh Benar</th>
              <th>Jlh Salah</th>
              <th>Jlh Tidak Jawab</th>
              <th>Nilai</th>
          </tr>
      </thead>
      <tbody>
          @foreach ($data as $r)
              <tr>
                  <td>{{ $r['kode_ujian'] . ' - ' . $r['matapelajaran'] }}</td>
                  <td>{{ $r['nis'] }}</td>
                  <td>{{ $r['nama_siswa'] }}</td>
                  <td>{{ $r['kelas'] }}</td>
                  <td>{{ $r['jlh_soal'] }}</td>
                  <td>{{ $r['jlh_jawab_benar'] }}</td>
                  <td>{{ $r['jlh_jawab_salah'] }}</td>
                  <td>{{ $r['jlh_tidak_jawab'] }}</td>
                  <td>{{ $r['nilai'] }}</td>
              </tr>
          @endforeach
      </tbody>

  </table>
