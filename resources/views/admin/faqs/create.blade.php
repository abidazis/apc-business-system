@extends('layouts.admin')
@section('title', 'Tambah FAQ')
@section('content')
@include('admin.faqs._form', ['faq' => null])
@endsection