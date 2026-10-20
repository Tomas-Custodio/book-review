@extends('Layouts.public')

@section('content')
    <div class="mx-auto max-w-4xl px-4 py-8">

        {{-- Voltar à lista --}}
        <a href="{{ route('books.index') }}"
           class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-indigo-600">
            &larr; Voltar aos livros
        </a>

        {{-- Informações do livro --}}


        <div class="mb-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

            <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <span class="mb-3 inline-block rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-indigo-600">
                        Detalhes do livro
                    </span>

                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                        {{ $book->title }}
                    </h1>

                    <p class="mt-2 text-lg text-slate-500">
                        Escrito por
                        <span class="font-semibold text-slate-700">
                            {{ $book->user->name }}
                        </span>
                    </p>
                </div>

                <div class="rounded-xl bg-amber-50 px-5 py-4 text-center">

                    <div class="text-3xl font-bold text-amber-600">
                        {{ number_format($book->reviews_avg_rating ?? 0, 1) }}
                    </div>
                         

                    <div class="mt-1 text-lg text-amber-500">
                        ★★★★★
                    </div>

                    <p class="mt-1 text-xs text-slate-500">
                        Média das avaliações
                    </p>
                </div>

            </div>

            <div class="flex flex-wrap items-center gap-3 border-t border-slate-100 pt-5">

                <span class="rounded-lg bg-slate-100 px-3 py-2 text-sm font-medium text-slate-700">
                    {{ $book->reviews_count ?? $book->reviews->count() }}
                    {{ Str::plural('avaliação', $book->reviews_count ?? $book->reviews->count()) }}
                </span>

                <a href="#reviews"
                   class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">

                    Ver avaliações

                </a>

                <a href="{{ route('books.reviews.create',$book->id) }}"
                   class="rounded-lg border border-indigo-200 px-4 py-2 text-sm font-semibold text-indigo-600 transition hover:bg-indigo-50">

                    + Adicionar avaliação

                </a>
            </div>
        </div>

        {{-- Lista de avaliações --}}

        <section id="reviews">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">
                        Avaliações
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Opiniões dos leitores sobre este livro.
                    </p>
                </div>
            </div>

            <ul class="space-y-4">

                @forelse ($book->reviews as $review)

                    <li class="rounded-xl border border-slate-200 bg-white p-5 transition hover:border-indigo-200 hover:shadow-sm">

                        <div class="mb-3 flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-lg font-bold text-slate-800">
                                        {{ number_format($review->rating, 1) }}
                                    </span>

                                    <span class="text-lg text-amber-500">
                                        @for ($i = 1; $i <= 5; $i++)
                                            {{ $i <= $review->rating ? '★' : '☆' }}
                                        @endfor
                                    </span>
                                </div>

                                <p class="mt-1 text-xs text-slate-500">
                                    Avaliação publicada em
                                    {{ $review->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>

                        <p class="leading-7 text-slate-600">
                            {{ $review->review }}
                        </p>
                    </li>
                @empty
                    <li class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center">
                        <div class="mb-3 text-4xl text-slate-300">☆</div>

                        <h3 class="text-lg font-semibold text-slate-800">
                            Ainda não há avaliações
                        </h3>

                        <p class="mt-2 text-sm text-slate-500">
                            Este livro ainda não recebeu nenhuma avaliação.
                            Sê o primeiro a partilhar a tua opinião!
                        </p>
                    </li>
                @endforelse
            </ul>
        </section>

    </div>
@endsection