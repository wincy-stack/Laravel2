<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 14px;
            box-sizing: border-box;
        }
        input:focus, textarea:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
            margin-left: 10px;
        }
        .btn-secondary:hover {
            background-color: #545b62;
        }
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        .error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }
        .form-group.error input {
            border-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Book</h1>

        @if ($errors->any())
            <div style="color: #dc3545; margin-bottom: 20px;">
                <strong>Please fix the following errors:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('books.update', $book->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group @error('book_name') error @enderror">
                <label for="book_name">Book Name *</label>
                <input type="text" id="book_name" name="book_name" value="{{ old('book_name', $book->book_name) }}" required>
                @error('book_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group @error('book_author') error @enderror">
                <label for="book_author">Author *</label>
                <input type="text" id="book_author" name="book_author" value="{{ old('book_author', $book->book_author) }}" required>
                @error('book_author')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group @error('book_stock') error @enderror">
                <label for="book_stock">Stock *</label>
                <input type="number" id="book_stock" name="book_stock" value="{{ old('book_stock', $book->book_stock) }}" min="0" required>
                @error('book_stock')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group @error('book_date') error @enderror">
                <label for="book_date">Date *</label>
                <input type="date" id="book_date" name="book_date" value="{{ old('book_date', $book->book_date->format('Y-m-d')) }}" required>
                @error('book_date')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Update Book</button>
                <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
