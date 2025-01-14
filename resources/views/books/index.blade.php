@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="text-center mb-4">Books List</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('books.create') }}" class="btn btn-success">
                <i class="bi bi-plus-lg"></i> Add New Book
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Year</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($books as $book)
                    <tr id="book-{{ $book->id }}" class="book-row" data-book-id="{{ $book->id }}">
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->description }}</td>
                        <td>{{ $book->publication_year }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $books->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Контекстное меню -->
    <div id="context-menu" class="dropdown-menu" style="display: none; position: absolute; z-index: 1000;">
        <a href="#" id="edit-book" class="dropdown-item">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="#" id="delete-book" class="dropdown-item text-danger">
            <i class="bi bi-trash"></i> Delete
        </a>
    </div>

    <!-- AJAX Delete Script -->
    <script>
        let currentBookId = null; // Переменная для хранения ID текущей книги

        // Обработчик правого клика на строке
        document.querySelectorAll('.book-row').forEach(row => {
            row.addEventListener('contextmenu', function(event) {
                event.preventDefault(); // Отменяем стандартное контекстное меню

                // Получаем ID книги
                currentBookId = this.dataset.bookId;

                // Позиционируем контекстное меню
                const contextMenu = document.getElementById('context-menu');
                contextMenu.style.display = 'block';
                contextMenu.style.left = `${event.pageX}px`;
                contextMenu.style.top = `${event.pageY}px`;
            });
        });

        // Закрыть контекстное меню, если кликнуть вне
        window.addEventListener('click', function() {
            const contextMenu = document.getElementById('context-menu');
            contextMenu.style.display = 'none';
        });

        // Обработчик клика по редактированию
        document.getElementById('edit-book')?.addEventListener('click', function() {
            if (currentBookId) {
                window.location.href = `/books/${currentBookId}/edit`; // Перенаправление на страницу редактирования
            }
        });

        // Обработчик клика по удалению
        document.getElementById('delete-book')?.addEventListener('click', function() {
            if (currentBookId) {
                // if (confirm('Are you sure you want to delete this book?')) {
                    // Выполняем запрос AJAX для удаления
                    fetch(`/books/${currentBookId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Передаем CSRF токен для защиты
                        },
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Удаляем книгу из таблицы
                                let bookRow = document.getElementById('book-' + data.bookId);
                                bookRow.remove();
                            } else {
                                alert('Error deleting book!');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('There was an error deleting the book.');
                        });
                // }
            }
        });
    </script>
@endsection
