@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ isset($book) ? 'Edit Book' : 'Add New Book' }}</h1>
        <form action="{{ isset($book) ? route('books.update', $book->id) : route('books.store') }}" method="POST">
            @csrf
            @if(isset($book))
                @method('PUT')
            @endif
            <div class="form-group mb-3">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $book->title ?? '' }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ $book->description ?? '' }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label for="author_id">Author ID</label>
                <input type="number" name="author_id" id="author_id" class="form-control" value="{{ $book->author_id ?? '' }}">
            </div>
            <div class="form-group mb-3">
                <label for="publication_year">Publication Year</label>
                <input type="number" name="publication_year" id="publication_year" class="form-control" value="{{ $book->publication_year ?? '' }}" required>
            </div>
            <button type="submit" class="btn btn-success">{{ isset($book) ? 'Update' : 'Add' }}</button>
        </form>
    </div>
@endsection
