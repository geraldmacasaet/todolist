<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="/tasks" method="POST">
                        @CSRF
                        <div>
                            <label for="description">Task Description</label>
                            <input type="text" name="description" class="rounded-lg border-blue-600">
                            <input type="submit"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-800 text-white cursor-pointer rounded-lg" />
                            @error('description')
                                <p class="text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="grid grid-cols-2">
                    <div class="p-6 border border-gray-400">
                        <h2 class="font-bold text-lg">Pending Tasks</h2>
                        <ul class="list-disc">
                            @forelse ($pendingTasks as $task)
                                <li class="flex gap-2 my-2 items-center justify-between">
                                    {{ $task->description }}
                                    <div class="flex gap-2">
                                        <form action="/tasks/{{ $task->id }}" method="POST">
                                            @method('PUT')
                                            @CSRF
                                            <input type="hidden" value="1" name="is_done" />
                                            <input type="submit" value="Mark as Done"
                                                class="px-2 py-1 rounded-lg border-2
                                                    border-blue-600" />
                                        </form>
                                        <form action="/tasks/{{ $task->id }}" method="POST">
                                            @method('DELETE')
                                            @CSRF
                                            <input type="submit" value="Delete"
                                                class="px-2 py-1 rounded-lg border-2
                                                    border-red-600" />
                                        </form>
                                    </div>
                                </li>
                            @empty
                                <p>Add tasks at the input field above.</p>
                            @endforelse
                        </ul>
                    </div>
                    <div class="p-6 border border-gray-400">
                        <h2 class="font-bold text-lg">Tasks Done</h2>
                        <ul class="list-disc">
                            @forelse ($doneTasks as $task)
                                <li class="flex gap-2 my-2 items-center justify-between">
                                    {{ $task->description }}
                                    <div class="flex gap-2">
                                        <form action="/tasks/{{ $task->id }}" method="POST">
                                            @method('PUT')
                                            @CSRF
                                            <input type="hidden" value="0" name="is_done" />
                                            <input type="submit" value="Mark as Pending"
                                                class="px-2 py-1 rounded-lg border-2 border-yellow-600" />
                                        </form>
                                        <form action="/tasks/{{ $task->id }}" method="POST">
                                            @method('DELETE')
                                            @CSRF
                                            <input type="submit" value="Delete"
                                                class="px-2 py-1 rounded-lg border-2 border-red-600" />
                                        </form>
                                    </div>
                                </li>
                            @empty
                                <p>No task done yet.</p>
                            @endforelse
                        </ul>
                    </div>
                    <div class="p-6 border border-gray-400">
                        <h2 class="font-bold text-lg text-red-500">Deleted Tasks</h2>
                        <ul class="list-disc">
                            @forelse ($deletedTasks as $deletedTask)
                                <li class="flex gap-2 my-2 items-center justify-between">
                                    {{ $deletedTask->description }}
                                    <div class="flex gap-2">
                                        <form action="/tasks/restore/{{ $deletedTask->id }}" method="GET">
                                            @CSRF
                                            <input type="submit" value="Restore"
                                                class="px-2 py-1 rounded-lg border-2 border-green-600" />
                                        </form>
                                    </div>
                                </li>
                            @empty
                                <p>Trash is empty. Hooray!</p>
                            @endforelse
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
