<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Colaborador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Bloco para exibir TODOS os erros de validação --}}
                    @if ($errors->any())
                        <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                            <p class="font-bold">Por favor, corrija os seguintes erros:</p>
                            <ul class="mt-1 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{--
                        ESTE É O PONTO CRÍTICO:
                        A action do formulário DEVE apontar para a rota 'update'
                        e DEVE passar o ID do colaborador.
                        O @method('PUT') é ESSENCIAL para que o Laravel reconheça a requisição como PUT.
                    --}}
                    <form method="POST" action="{{ route('colaboradores.update', $colaborador->id) }}">
                        @csrf
                        @method('PUT') {{-- NÃO ESQUEÇA ESTA LINHA! --}}

                        <!-- Nome Completo -->
                        <div class="mb-4">
                            <x-input-label for="nome" :value="__('Nome Completo')" />
                            {{-- old() para manter o valor se houver erro, $colaborador->nome para o valor atual --}}
                            <x-text-input id="nome" class="block mt-1 w-full" type="text" name="nome" :value="old('nome', $colaborador->nome)" required autofocus />
                            <x-input-error :messages="$errors->get('nome')" class="mt-2" />
                        </div>

                        <!-- CPF -->
                        <div class="mb-4">
                            <x-input-label for="cpf" :value="__('CPF')" />
                            <x-text-input id="cpf" class="block mt-1 w-full" type="text" name="cpf" :value="old('cpf', $colaborador->cpf)" required />
                            <x-input-error :messages="$errors->get('cpf')" class="mt-2" />
                        </div>

                        <!-- Matrícula -->
                        <div class="mb-4">
                            <x-input-label for="matricula" :value="__('Matrícula')" />
                            <x-text-input id="matricula" class="block mt-1 w-full" type="text" name="matricula" :value="old('matricula', $colaborador->matricula)" required autocomplete="off" />
                            <x-input-error :messages="$errors->get('matricula')" class="mt-2" />
                        </div>

                        <!-- Data de Nascimento -->
                        <div class="mb-4">
                            <x-input-label for="data_nascimento" :value="__('Data de Nascimento')" />
                            <x-text-input id="data_nascimento" class="block mt-1 w-full" type="date" name="data_nascimento" :value="old('data_nascimento', $colaborador->data_nascimento)" required />
                            <x-input-error :messages="$errors->get('data_nascimento')" class="mt-2" />
                        </div>

                        <!-- Telefone -->
                        <div class="mb-4">
                            <x-input-label for="telefone" :value="__('Telefone (Opcional)')" />
                            <x-text-input id="telefone" class="block mt-1 w-full" type="text" name="telefone" :value="old('telefone', $colaborador->telefone)" autocomplete="tel" />
                            <x-input-error :messages="$errors->get('telefone')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <x-input-label for="email" :value="__('Email (Opcional)')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $colaborador->email)" autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Cargo ID (Dropdown) -->
                        <div class="mb-4">
                            <x-input-label for="cargo_id" :value="__('Cargo')" />
                            <select id="cargo_id" name="cargo_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Selecione um Cargo</option>
                                @foreach($cargos as $cargo)
                                    <option value="{{ $cargo->id }}" {{ old('cargo_id', $colaborador->cargo_id) == $cargo->id ? 'selected' : '' }}>
                                        {{ $cargo->nome }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('cargo_id')" class="mt-2" />
                        </div>

                        <!-- Departamento ID (Dropdown) -->
                        <div class="mb-4">
                            <x-input-label for="departamento_id" :value="__('Departamento')" />
                            <select id="departamento_id" name="departamento_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Selecione um Departamento</option>
                                @foreach($departamentos as $departamento)
                                    <option value="{{ $departamento->id }}" {{ old('departamento_id', $colaborador->departamento_id) == $departamento->id ? 'selected' : '' }}>
                                        {{ $departamento->nome }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('departamento_id')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('colaboradores.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button>
                                {{ __('Atualizar Colaborador') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>