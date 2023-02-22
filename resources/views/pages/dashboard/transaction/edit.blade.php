<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Transaction / Edit
    </h2>
  </x-slot>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div>
        @if ($errors->any())
          <div class="mb-5" role="alert">
            <div class="bg-green-500 text-white font-bold rounded px-4 py-2">
              There something wrong!
            </div>
            <div class="border brder-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
              <p>
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
              </p>
            </div>
          </div>
        @endif
      </div>
      <form action="{{ route('dashboard.transaction.update', $transaction->id) }}" class="w-full" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="flex flex-wrap mx-3 mb-6">
          <div class="w-full px-3">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
              Name
            </label>
            <select name="status"
              class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
              <option value="{{ $transaction->status }}">{{ $transaction->status }}</option>
              <option desabled>----------</option>
              <option value="PENDING">PENDING</option>
              <option value="SUCCESS">SUCCESS</option>
              <option value="CHALLENGE">CHALLENGE</option>
              <option value="SHIPPING">SHIPPING</option>
              <option value="SHIPPED">SHIPPED</option>
            </select>
          </div>

          <div class="flex flex-wrap mx-3 mb-6">
            <div class="w-full px-3">
              <button type="submit"
                class="bg-green-500 hover:bg-green-700 text-white font-bold px-4 py-2 rounded shadow-lg">
                Update Transaction
              </button>
            </div>
          </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
  <script>
    CKEDITOR.replace('description');
  </script>
</x-app-layout>
