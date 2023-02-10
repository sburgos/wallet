<x-layout>
    <header class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">Billeteras</h1>
        </div>
    </header>
    <div class="mx-auto bg-white rounded mb-10 p-10">
        <form method="post" action="{{ route('wallets.store') }}">
            @csrf
            <div class="flex flex-col justify-around">
                <div class="mt-5">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Descripción">
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
                    <label for="type" class="block text-sm font-medium text-gray-700">Tipo</label>
                    <select id="type" name="type" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                        <option value="budget">presupuesto</option>
                        <option value="goal">Meta</option>
                    </select>
                </div>
                <button type="submit" class="text-center mt-10 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Guardar</button>
            </div>
        </form>
    </div>
    <div class="flex flex-col xl:flex-row justify-around">
        <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
           @foreach($wallets as $wallet)
           <li class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow">
                <a href="{{ route('movements', $wallet->id) }}">
                    <div class="flex w-full items-center justify-between space-x-6 p-6">
                        <div class="flex-1 truncate">
                            <div class="flex items-center space-x-3">
                                <h3 class="truncate text-sm font-medium text-gray-900">{{ $wallet->name }}</h3>
                                <span class="inline-block flex-shrink-0 rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">S/ {{ ($wallet->positive + $wallet->negative) / 100 }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="flex pb-5 px-5 ">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                @if($wallet->type == 'budget')
                                    <div class="bg-red-600 h-2.5 rounded-full" style="width: {{ (($wallet->positive + $wallet->negative) / $wallet->positive) * 100 }}%"></div>
                                @else
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ ($wallet->positive/($wallet->negative*-1)) * 100 }}%"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</x-layout>
