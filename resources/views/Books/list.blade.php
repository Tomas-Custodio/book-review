
@extends('Layouts.public')

@section('content')

    <section class="px-4 py-12 sm:px-8 lg:px-20">

            {{-- Search --}}

        <h1 class="mb-8 text-center text-4xl font-bold text-slate-900 sm:text-5xl pb-4">
            Books
        </h1>

        <section class="mx-auto w-full max-w-4xl pb-5">


            <form action="{{ route('books.index') }} "method="GET"
                class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
        
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">

                    {{-- Search input --}}

                    <div class="relative min-w-0 flex-1">

                        <svg
                            class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            aria-hidden="true">

                            <circle cx="11" cy="11" r="7" />
                            <path d="m20 20-4-4" />
                        </svg>

                        <input
                            type="search"
                            id="title"
                            name="title"
                            value="{{ request('title') }}"
                            placeholder="Enter a book title..."
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-12 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10">

                    </div>

                    <input type="hidden" name="filter" value="{{ request('filter') }}">

                    {{-- Action buttons --}}

                    <div class="flex gap-2">

                        <button
                            type="submit"
                            class="flex-1 rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/20 sm:flex-none">

                            Search

                        </button>

                        @if(request()->filled('title'))

                            <a
                                href="{{ route('books.index') }}"
                                class="flex-1 rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-100 sm:flex-none">

                                Clear
                            </a>

                        @endif

                    </div>

                </div>

            </form>

        </section>

        <section class="flex flex-row items-center justify-center gap-4 py-4">

              @php
                $filters = [
                    '' => 'latest',
                    'popular_last_month' => 'popular last month',
                    'popular_last_6month' => 'popular last 6 month',
                    'Heighest_rated__last_month' => 'popular last month',
                    'Heighest_rated__last_6month' => 'popular last 6 month',
                ];

            @endphp

            @foreach ( $filters as $key => $value )

                <a href="{{ route('books.index', ['filter' => $key]) }}" class="hover:underline focus-within:bg-blue-500 p-1 rounded-sm text-slate-700">{{$value}}</a>
                
            @endforeach
             
        </section>



        <section class="mx-auto flex w-full max-w-4xl flex-col items-center gap-5">

            @forelse ($books as $book)

                <article class="flex min-h-36 w-full flex-col justify-between 
                    gap-5 rounded-xl border border-slate-200 bg-white p-5 shadow-sm 
                        transition hover:shadow-md">

                    {{-- Reviews and ratings --}}

                    <section class="flex items-center justify-end gap-4">

                        {{-- Number of reviews --}}

                        <div class="text-sm text-slate-500">
                            Out of {{ $book->reviews_count }}
                            {{ Str::plural('review', $book->reviews_count) }}
                        </div>

                        {{-- Average rating --}}

                        <div class="min-w-12 rounded-lg bg-amber-400 px-2 py-1 text-center font-bold text-slate-900">
                            {{ number_format($book->reviews_avg_rating ?? 0, 1) }}
                        </div>
                        
                    </section>

                    {{-- Book information --}}

                    <div class="flex-grow">

                        <a
                            href="{{ route('books.show', $book) }}"
                            class="text-lg font-bold text-slate-900 transition hover:text-blue-600">

                            {{ $book->title }}

                        </a>

                        <p class="mt-2 text-sm text-slate-500">

                            Author:

                            <span class="font-medium text-slate-700">
                                {{ $book->user?->name ?? 'Unknown author' }}
                            </span>
                            
                        </p>

                    </div>

                </article>

            @empty

                <div class="w-full rounded-xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center">

                    <h2 class="text-xl font-bold text-slate-800">
                        No books found
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        Try another title or reset your search.
                    </p>

                    <a href="{{ route('books.index') }}"

                        class="mt-5 inline-block rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold 
                        text-white transition hover:bg-blue-700">

                        Reset criteria
                    </a>

                </div>

            @endforelse

        </section>

    </section>

@endsection
