<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestão de Colaboradores') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Sucesso!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Erro!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Lista de Colaboradores</h3>
                        <a href="{{ route('colaboradores.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Adicionar Novo Colaborador
                        </a>
                    </div>

                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 px-6">ID</th>
                                    <th scope="col" class="py-3 px-6">Nome</th>
                                    <th scope="col" class="py-3 px-6">CPF</th>
                                    <th scope="col" class="py-3 px-6">Cargo</th>
                                    <th scope="col" class="py-3 px-6">Departamento</th>
                                    <th scope="col" class="py-3 px-6 text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($colaboradores as $colaborador)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $colaborador->id }}
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $colaborador->nome }}
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $colaborador->cpf }}
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $colaborador->cargo->nome ?? 'N/A' }}
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $colaborador->departamento->nome ?? 'N/A' }}
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <a href="{{ route('colaboradores.show', $colaborador->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-3">Ver</a>
                                            <a href="{{ route('colaboradores.edit', $colaborador->id) }}" class="font-medium text-yellow-600 dark:text-yellow-500 hover:underline mr-3">Editar</a>
                                            <form action="{{ route('colaboradores.destroy', $colaborador->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este colaborador? Essa ação é irreversível e pode afetar registros de entrega de EPIs!');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td colspan="6" class="py-4 px-6 text-center text-gray-500">Nenhum colaborador encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $colaboradores->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>