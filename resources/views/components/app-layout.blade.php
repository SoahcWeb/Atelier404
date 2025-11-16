@props(['title' => null])

@extends('layouts.main')

@section('title', $title)

@section('content')
    {{ $slot }}
@endsection
