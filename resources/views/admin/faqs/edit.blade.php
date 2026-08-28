@extends('layouts.admin')
@section('title', 'Edit FAQ')
@section('content')
@include('admin.faqs._form', ['faq' => $faq])
@endsection