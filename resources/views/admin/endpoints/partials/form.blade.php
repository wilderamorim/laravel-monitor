@csrf

<div class="mb-6">
    <label for="endpoint" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Endpoint</label>
    <input type="text" name="endpoint" id="endpoint" value="{{ $endpoint->endpoint ?? old('endpoint') }}" placeholder="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
</div>
<div class="mb-6">
    <label for="frequency" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Frequência</label>
    <input type="number" name="frequency" id="frequency" value="{{ $endpoint->frequency ?? old('frequency') }}" placeholder="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
</div>
<button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
    Enviar
</button>
