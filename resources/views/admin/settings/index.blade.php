<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Website') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    @foreach($settings as $group => $groupSettings)
                        <div class="mb-8">
                            <h3 class="text-lg font-medium mb-4 capitalize">{{ $group }}</h3>
                            
                            @foreach($groupSettings as $setting)
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                        {{ $setting->label }}
                                    </label>

                                    @switch($setting->type)
                                        @case('textarea')
                                            <textarea 
                                                name="{{ $setting->key }}"
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                rows="4"
                                            >{{ $setting->value }}</textarea>
                                            @break

                                        @case('file')
                                            @if($setting->value)
                                                <div class="mb-2">
                                                    @if(in_array(pathinfo($setting->value, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                        <img src="{{ Storage::url($setting->value) }}" alt="{{ $setting->label }}" class="h-20">
                                                    @else
                                                        <a href="{{ Storage::url($setting->value) }}" target="_blank">Lihat File</a>
                                                    @endif
                                                </div>
                                            @endif
                                            <input 
                                                type="file"
                                                name="{{ $setting->key }}"
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            >
                                            @break

                                        @default
                                            <input 
                                                type="{{ $setting->type }}"
                                                name="{{ $setting->key }}"
                                                value="{{ $setting->value }}"
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            >
                                    @endswitch
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 