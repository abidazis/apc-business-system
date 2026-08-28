@extends('layouts.admin')
@section('title', 'Edit Halaman')
@section('content')
@include('admin.pages._form', ['page' => $page])
@endsection