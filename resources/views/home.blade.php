@extends('layouts.app')
@section('today', $today)
@section('content')
    <div class="mx-auto bg-white rounded mb-10 p-10">
        <form method="post" action="{{ route('movements.store') }}">
            @csrf
            <div class="flex flex-col justify-around">
                <div class="mt-5">
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <div class="mt-1">
                        <input type="text" name="description" id="description" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Descripción">
                    </div>
                </div>
                <div class="mt-5">
                    <label for="amount" class="block text-sm font-medium text-gray-700">Monto</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-gray-500 sm:text-sm">S/</span>
                        </div>
                        <input type="text" name="amount" id="amount" class="block w-full rounded-md border-gray-300 pl-7 pr-12 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="0.00" aria-describedby="price-currency">
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <span class="text-gray-500 sm:text-sm" id="price-currency">PEN</span>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <label for="sum" class="block text-sm font-medium text-gray-700">Sumatoria</label>
                    <select id="sum" name="sum" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                        <option value="increase">Ingreso</option>
                        <option value="decrease" selected>Gasto</option>
                    </select>
                </div>
                <div class="mt-5">
                    <label for="type" class="block text-sm font-medium text-gray-700">Tipo</label>
                    <select id="type" name="type" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                        <option value="food">Restaurantes</option>
                        <option value="delivery">Delivery</option>
                        <option value="supermarket">Supermercado</option>
                        <option value="transfer">Transferencia</option>
                        <option value="services">Servicios</option>
                        <option value="home">Casa</option>
                        <option value="taxi">Taxi</option>
                        <option value="salary">Sueldo</option>
                        <option value="goal">Abono a Objetivo</option>
                    </select>
                </div>
                <button type="submit" class="text-center mt-10 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Guardar</button>
            </div>
        </form>
    </div>
    <div class="flex flex-col xl:flex-row justify-around">
        <div class="flow-root bg-white rounded p-10 shadow-xl order-2 xl:order-1">
            <div class="pb-10 font-semibold text-xl">
                Movimientos
            </div>
            <ul role="list" class="">
                @foreach($movements as $move)
                <li>
                    <div class="relative pb-8">
                        @if($movements->last() !== $move)
                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                        @endif
                        <div class="relative flex space-x-3">
                            <div>
                                <span class="h-8 w-8 rounded-full @if($move->amount < 0) bg-red-500 @else bg-green-500 @endif flex items-center justify-center ring-8 ring-white">
                                    @if($move->amount < 0)
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-white">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-white">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                                        </svg>
                                    @endif
                                </span>
                            </div>
                            <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                <div>
                                    <p class="text-sm text-gray-500">{{ round($move->amount/100,2) }} <a href="#" class="font-medium text-gray-900">{{ $move->description }}</a></p>
                                </div>
                                <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                    <time datetime="2020-09-20">{{ Illuminate\Support\Carbon::parse($move->created_at)->setTimezone('America/Lima')->isoFormat('lll') }}</time>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="flow-root bg-white rounded p-10 order-1 xl:order-2 mb-10 xl:mb-0">
            <div class="pb-10 font-semibold text-xl">
                Objetivos
            </div>
            <div class="overflow-hidden bg-white shadow sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200">
                    <li>
                        <a href="#" class="block hover:bg-gray-50">
                            <div class="flex items-center px-4 py-4 sm:px-6">
                                <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                    <div class="truncate">
                                        <div class="flex text-sm">
                                            <p class="truncate font-medium text-indigo-600">Viaje Cuzco</p>
                                            <p class="ml-1 flex-shrink-0 font-normal text-gray-500">Objetivo S/1200 de S/5000</p>
                                        </div>
                                        <div class="mt-2 flex">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 30%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-5 flex-shrink-0">
                                    <!-- Heroicon name: mini/chevron-right -->
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
