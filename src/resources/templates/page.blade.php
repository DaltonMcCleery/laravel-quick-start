@extends('base')
@section('title', $page->title)
@section('meta_title', $page->meta_title ?: $page->title)
@section('meta_description', $page->meta_description ?: '')
@section('meta_keywords', $page->meta_keywords ?: '')
@section('og_title', $page->og_title ?: $page->title)
@section('og_description', $page->og_description ?: $page->meta_description)
@section('og_image', $page->social_image ?: asset('images/logo.png'))

@section('content')

    @include('includes.content_builder', ['content' => $page->content, 'page' => $page])

@endsection
