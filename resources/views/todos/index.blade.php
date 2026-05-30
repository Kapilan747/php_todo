<!DOCTYPE html>
<html>
<head>
    <title>Laravel PHP Todo App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 40px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h1 {
            text-align: center;
        }

        form {
            display: inline;
        }

        .add-form {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
        }

        .add-form input {
            flex: 1;
            padding: 10px;
        }

        button {
            padding: 10px 14px;
            cursor: pointer;
        }

        .todo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .completed {
            text-decoration: line-through;
            color: gray;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .status {
            text-align: center;
            margin-bottom: 20px;
            color: green;
        }

        .db-info {
            text-align: center;
            font-size: 13px;
            color: #666;
            margin-bottom: 20px;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
            border: none;
        }

        .toggle-btn {
            background: #198754;
            color: white;
            border: none;
        }

        .add-btn {
            background: #0d6efd;
            color: white;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Laravel PHP Todo App</h1>

        <div class="status">
            App is running successfully
        </div>

        <div class="db-info">
            Database: {{ config('database.connections.mysql.database') }}
        </div>

        <form class="add-form" method="POST" action="/todos">
            @csrf
            <input type="text" name="title" placeholder="Enter todo item" required>
            <button class="add-btn" type="submit">Add</button>
        </form>

        @forelse ($todos as $todo)
    <div class="todo">
        <span class="{{ $todo->completed ? 'completed' : '' }}">
            {{ $todo->title }}
        </span>

        <div class="actions">
            <form method="POST" action="/todos/{{ $todo->id }}/toggle">
                @csrf
                <button class="toggle-btn" type="submit">
                    {{ $todo->completed ? 'Undo' : 'Done' }}
                </button>
            </form>

            <form method="POST" action="/todos/{{ $todo->id }}">
                @csrf
                @method('DELETE')
                <button class="delete-btn" type="submit">Delete</button>
            </form>
        </div>
    </div>
@empty
    <p style="text-align:center; color:#777;">No todos yet. Add your first todo above.</p>
@endforelse
    </div>
</body>
</html>
