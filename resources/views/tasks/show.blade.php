<!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Atividade</title>
  </head>
  <body>
    @include('nav')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-5">
        <div class="pb-4 bg-white dark:bg-gray-900 mt-5">
          <form action="/dashboard" method="GET">
            <div class="flex">
              <div class="relative mt-1">
                <div
                  class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                >
                  <svg
                    class="w-4 h-4 text-gray-500 dark:text-gray-400"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 20 20"
                  >
                    <path
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                    />
                  </svg>
                </div>
                <input
                  type="search"
                  id="search"
                  name="search"
                  class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Buscar por tarefas"
                />
              </div>

              <div class="relative mt-3 left-2/4">
                @if($search)
                <p class="text-sm dark:text-white">
                  Buscando por: {{ $search }}
                </p>
                @endif
              </div>
            </div>
          </form>
        </div>

        <table
          class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
        >
          <caption
            class="p-6 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800"
          >
            {{ __("Suas Tarefas") }}
          </caption>
          <thead
            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
          >
            <tr>
              <th scope="col" class="px-6 py-4">{{ __("Título") }}</th>
              <th scope="col" class="px-6 py-4">{{ __("Descrição") }}</th>
              <th scope="col" class="px-6 py-4">{{ __("Status") }}</th>
              <th
                scope="col"
                class="px-6 py-4 flex items-center justify-center"
              >
                {{ __("Deletar") }}
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tasks as $task)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
              <th
                scope="row"
                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
              >
                {{$task->title}}
              </th>
              <td class="px-6 py-4">{{$task->description}}</td>
              <td class="px-6 py-4">
                @if ($task->status === 'Ativa')
                <span style="color: #86efac">{{$task->status}}</span>
                @else
                <span style="color: #fca5a5">{{$task->status}}</span>
                @endif
              </td>
              <td class="px-6 py-4 flex items-center justify-center">
                <form method="post" action="{{ route('task.destroy', [$task->id]) }}">
                  @csrf @method('delete')

                  <button>Deletar</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="text-center mt-10">
        @if(count($tasks) == 0)
        <p class="text-lg dark:text-white">
          {{ __("Nenhuma atividade encontrada") }}
        </p>
        @endif
      </div>

      <div class="px-6 py-4 mt-3 font-medium text-black dark:text-white">
        {{ $tasks->appends([ 'search' => request()->get('search', ''
        )])->links('pagination::tailwind') }}
      </div>
    </div>
  </body>
</html>
