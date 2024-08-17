 @extends('layouts.main-layout.app')
 @section('title', 'Detail Rekap Nilai')
 @section('css')
     <style>
         .box-jwb {
             border: 1px solid #dbdade;
             border-radius: 10px;
             margin-bottom: 10px;
         }

         /* .styled-list {
                                                                                                                                                                                                                                                                                                                                     list-style-type: lower-alpha;
                                                                                                                                                                                                                                                                                                                                     margin-left: 10px;
                                                                                                                                                                                                                                                                                                                                 }

                                                                                                                                                                                                                                                                                                                                 .styled-list li {
                                                                                                                                                                                                                                                                                                                                     margin-left: 10px;
                                                                                                                                                                                                                                                                                                                                 } */

         .circle-container {
             width: 30px !important;
             height: 30px !important;
             border-radius: 50%;
             display: flex;
             justify-content: center;
             align-items: center;
             margin-right: 10px;
             font-size: 16px;

         }

         .circle-container-sm {
             width: 20px !important;
             height: 20px !important;
             border-radius: 50%;
             display: flex;
             justify-content: center;
             align-items: center;
             margin-right: 10px;
             font-size: 16px;

         }

         /* Teks di dalam lingkaran */
         .circle-text {

             text-align: center;
         }

         .circle-container.active {
             background-color: #7367f0;
             color: #fff !important;
         }

         .circle-container-sm.active {
             background-color: #7367f0;
             color: #fff !important;
         }
     </style>
 @endsection
 @section('content')

     <div class="card mb-4">
         <div class="card-body">
             @php $no = 1; @endphp
             @foreach ($data as $j)
                 <tr>
                     <td>
                         <b><span>Soal Nomor : {{ $no }}</span></b><br>{!! tipeSoal($j->ref_butir_soal) !!}
                         <br>
                         <br>
                         @if ($j->ref_butir_soal == '1')
                             @php $r = $j->butirSoal; @endphp

                             {!! $r->soal !!}
                             <br>

                             @php $const_jwb = explode(",",$r->tipe_optional_jawaban); @endphp
                             @foreach ($const_jwb as $jwb)
                                 <div class="form-check custom-option custom-option-basic mb-3 ">
                                     <label class="form-check-label custom-option-content">
                                         <div class="circle-container {{ $jwb == $j->jawaban ? 'active' : '' }}  form-check-input checkbox-jwb"
                                             value="{{ $jwb }}">
                                             <span class="circle-text">{{ strtoupper($jwb) }}</span>
                                         </div>
                                         <span class="custom-option-body ">
                                             {!! $r->{'jawaban_' . $jwb} !!}
                                         </span>
                                     </label>
                                 </div>
                             @endforeach

                             <span class="badge bg-primary">
                                 Poin
                                 Benar :
                                 {{ $j->poin_benar }}</span>
                             <br>
                             <span class="badge bg-success">Poin dan Jawaban Benar :
                                 {{ $r->jawaban_benar }} = {{ $r->poin_benar }}
                             </span>
                         @elseif ($j->ref_butir_soal == '2')
                             @php $r = $j->butirSoal2; @endphp
                             {!! $r->soal !!}
                             <br>
                             @php
                                 $const_jwb = explode(',', $r->tipe_optional_jawaban);
                                 $jawaban = json_decode($j->jawaban, true);
                             @endphp
                             @foreach ($const_jwb as $jwb)
                                 <div class="form-check custom-option custom-option-basic mb-3 ">
                                     <label class="form-check-label custom-option-content">
                                         <div class="circle-container {{ is_array($jawaban) && in_array($jwb, $jawaban) ? 'active' : '' }}  form-check-input checkbox-jwb"
                                             value="{{ $jwb }}">
                                             <span class="circle-text">{{ strtoupper($jwb) }}</span>
                                         </div>
                                         <span class="custom-option-body ">
                                             {!! $r->{'jawaban_' . $jwb} !!}
                                         </span>
                                     </label>
                                 </div>
                             @endforeach


                             <span class="badge bg-primary">
                                 Poin
                                 Benar :
                                 {{ $j->poin_benar }}</span>
                             <br>
                             <span class="badge bg-success">Poin dan Jawaban Benar :

                                 @foreach ($const_jwb as $l)
                                     {{ $l }} = {!! $r->{'poin_benar_' . $l} !!}
                                 @endforeach
                             </span>
                         @elseif ($j->ref_butir_soal == '3')
                             @php $r = $j->butirSoal3; @endphp
                             {!! $r->soal !!}
                             <br>
                             @php

                                 $jawaban = json_decode($j->jawaban, true);
                             @endphp
                             <table class="table table-bordered">
                                 <thead>
                                     <tr>
                                         <th style="width:70%">Pernyataan</th>

                                         @foreach (json_decode($r->optional_jawaban) as $oj)
                                             <th>{{ $oj }}</th>
                                         @endforeach
                                     </tr>
                                 </thead>
                                 <tbody>

                                     @php
                                         $pernyataan = json_decode($r->pernyataan_soal);
                                         $poin_benar = json_decode($r->poin_benar);
                                         $i = 0;
                                     @endphp


                                     @foreach ($pernyataan as $p)
                                         <tr>
                                             <td>{{ $p }}</td>

                                             @for ($m = 0; $m < count(json_decode($r->optional_jawaban)); $m++)
                                                 <td>


                                                     <label class="form-check-label custom-option-content">
                                                         <div class="circle-container-sm {{ ($jawaban[$i] ?? '') == $m ? 'active' : '' }}  form-check-input checkbox-jwb"
                                                             value="{{ $m }}">
                                                             <span class="circle-text"></span>
                                                         </div>
                                                         <span class="badge bg-success">Poin :
                                                             {{ $poin_benar[$i][$m] }}</span>

                                                     </label>
                                                 </td>
                                             @endfor

                                         </tr>
                                         @php $i++; @endphp
                                     @endforeach
                                 </tbody>
                             </table>
                             <br>
                             <span class="badge bg-primary">
                                 Poin
                                 Benar :
                                 {{ $j->poin_benar }}</span>
                             <br>
                         @elseif ($j->ref_butir_soal == '4')
                             @php $r = $j->butirSoal4; @endphp

                             {!! $r->soal !!}
                             <br>
                             <span>Jawab : </span>
                             <input type="text" class="form-control" value="{{ $j->jawaban }}"
                                 placeholder="Enter Text" readonly>

                             <br>
                             <span class="badge bg-primary">
                                 Poin
                                 Benar :
                                 {{ $j->poin_benar }}</span>
                             <br>
                             <span class="badge bg-success">Poin dan Jawaban Benar :

                                 {{ $r->jawaban }} | Range : {{ $r->poin_minimal }} -
                                 {{ $r->poin_maksimal }} | Kunci Kata : {{ $r->kunci_kata == 1 ? 'Ya' : 'Tidak' }}
                             </span>
                         @endif
                         <br>
                         <hr>
                     </td>

                 </tr>
                 @php $no++; @endphp
             @endforeach


         </div>
     </div>
 @endsection
