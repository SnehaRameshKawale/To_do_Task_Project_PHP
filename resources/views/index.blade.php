<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body class="flex flex-col justify-center items-center w-screen h-screen font-serif">
    @if(session('success'))
    <div class="success_mes" id="successMes">
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    </div>
    @endif
    <div class="todoList bg-purple-300 p-5 rounded-xl shadow-purple-400 shadow-lg lg:w-[90%] xl:w-1/2">
        <span class="text-center block mb-2 font-bold text-black text-3xl">Todo List</span>
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="flex items-center space-x-3 justify-center">
                <textarea name="tasks" id="tasks" class="border-purple-700 border p-2 w-[90%] sm:w-[80%] md:w-[70%] lg:w-[60%] xl:w-[750px] rounded-sm"
                    placeholder="Enter a task!"> </textarea>
                <button type="submit"
                    class="sm:block text-center xl:inline sm:mt-5 xl:mt-0 mb-3 pt-3 pb-3 pl-8 pr-8 rounded-lg bg-purple-400 text-black font-bold hover:shadow-purple-700 hover:shadow-sm hover:border-2 hover:border-purple-500">Add
                    Task</button>
            </div>
        </form>
    </div>
    <div
        class="show_task max-h-[80%] overflow-y-auto text-black text-lg bg-purple-400 p-5 rounded-xl shadow-purple-700 shadow-sm mt-8 w-[90%] sm:w-[80%] md:w-[70%] lg:w-[60%] xl:w-1/2">
        @if(count($tasks) > 0)
        <h2 class="text-lg font-semibold mb-3 text-black">Your Tasks:</h2>
        <ul class="space-y-2">
            @foreach ($tasks as $index => $task)
            <div class="task-item bg-purple-300 p-5 rounded-md">
                <span class="block text-end space-x-5 text-xl">
                    <!-- Mark complete -->
                    <button type="button" class="text-green-700 hover:text-green-900 mark-complete"
                        data-id="{{ $index }}">
                        <i class="fa-solid fa-check"></i>
                    </button>
                    <!-- Delete -->
                    <form action="{{ route('tasks.destroy', $index) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-700 hover:text-red-900">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </form>
                </span>
                <span class="task-text">{{ $task }}</span>
            </div>
            @endforeach
        </ul>
        @else
        <p class="text-lg font-semibold mb-3 text-gray-700">No task found <i class="fa-solid fa-heart-crack"></i></p>
        @endif
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const successMes = document.getElementById('successMes');
            if (successMes) {
                setTimeout(() => {
                    successMes.classList.add('opacity-0');
                    setTimeout(() => successMes.style.display = 'none', 500);
                }, 2000);
            }
            // ✅ Mark complete functionality
            const markBtns = document.querySelectorAll('.mark-complete');
            markBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const taskDiv = btn.closest('.task-item');
                    if (!taskDiv) return; // safety check

                    const taskText = taskDiv.querySelector('.task-text');
                    if (!taskText) return; // safety check

                    taskText.classList.toggle('line-through');
                    taskText.classList.toggle('text-gray-500');
                });
            });
        });
    </script>
</body>

</html>