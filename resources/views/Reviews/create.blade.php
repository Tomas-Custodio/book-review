 @extends('Layouts.public')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-10">

    {{-- Cabeçalho --}}
    <div class="mb-8">
        <a href="{{ route('books.details', $book) }}"
           class="text-sm text-gray-500 hover:text-gray-900">
            ← Voltar ao livro
        </a>

        <p class="mt-6 text-sm font-semibold uppercase tracking-widest text-indigo-600">
            Book Review · Nova avaliação
        </p>

        <h1 class="mt-2 text-3xl font-bold text-gray-900">
            Avaliar livro
        </h1>

        <p class="mt-2 text-gray-600">
            Partilha a tua opinião e ajuda outros leitores a escolherem a próxima leitura.
        </p>
    </div>

    {{-- Livro selecionado --}}
    <div class="mb-8 rounded-2xl border border-gray-200 bg-gray-50 p-6">
        <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-gray-500">
            Estás a avaliar este livro
        </p>

        <h2 class="text-xl font-bold text-gray-900">
            {{ $book->title }}
        </h2>

        <p class="mt-2 text-sm text-gray-600">
            Autor: {{ $book->user?->name ?? 'Autor não identificado' }}
        </p>

        <p class="mt-1 text-xs text-gray-400">
            Livro ID: #{{ $book->id }}
        </p>
    </div>

    {{-- Formulário --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">

        <h3 class="mb-6 text-lg font-semibold text-gray-900">
            A tua avaliação
        </h3>

        <form method="POST"
              action="{{ route('books.reviews.store', $book) }}"
              class="space-y-6">

            @csrf

            <div>
                <label for="review" class="mb-2 block text-sm font-medium text-gray-700">
                    A tua opinião
                </label>

                <textarea
                    name="review"
                    id="review"
                    rows="5"
                    minlength="15"
                    required
                    placeholder="O que achaste deste livro? O que aprendeste com a leitura?"
                    class="input w-full"
                >{{ old('review') }}</textarea>

                @error('review')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="rating" class="mb-2 block text-sm font-medium text-gray-700">
                    Classificação
                </label>

                <select
                    name="rating"
                    id="rating"
                    required
                    class="input w-full"
                >
                    <option value="">Escolhe uma classificação</option>

                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" @selected(old('rating') == $i)>
                            {{ $i }} {{ $i === 1 ? 'estrela' : 'estrelas' }}
                        </option>
                    @endfor
                </select>

                @error('rating')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <p class="mt-2 text-xs text-gray-500">
                    1 estrela: não gostei · 5 estrelas: excelente
                </p>
            </div>

            <div class="flex flex-col gap-3 border-t border-gray-100 pt-5 sm:flex-row">
                <button type="submit" class="btn">
                    Publicar avaliação
                </button>

                <a href="{{ route('books.details', $book) }}"
                   class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancelar
                </a>
            </div>

        </form>
    </div>

</div>
@endsection