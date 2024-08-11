 @extends('layouts.main-layout.app')
 @section('title', 'Edit Butir Soal')
 @section('css')
     <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
 @endsection
 @section('content')


     @if ($data->ref_butir_soal == '1')
         @include('soal.butirsoal.edit.1')
     @elseif ($data->ref_butir_soal == '2')
         @include('soal.butirsoal.edit.2')
     @elseif ($data->ref_butir_soal == '3')
         @include('soal.butirsoal.edit.3')
     @elseif ($data->ref_butir_soal == '4')
         @include('soal.butirsoal.edit.4')
     @endif

 @endsection
