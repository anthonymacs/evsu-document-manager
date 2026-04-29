<x-layouts.app title="Add Category">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Add Category</h2>
            <p class="text-sm text-gray-500 mt-1">Create a new document submission category.</p>
        </div>
        <a href="{{ route('categories.index') }}"
            class="border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-50 transition flex items-center gap-2">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Categories
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Form --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-base font-semibold text-gray-800">Category Details</h3>
                </div>
                <form method="POST" action="{{ route('categories.store') }}">
                @csrf
                <div class="p-6 space-y-5">

                    {{-- Category Name --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            placeholder="e.g. CSR, Teaching Load, Syllabus..."
                            class="w-full px-4 py-2.5 bg-gray-50 border {{ $errors->has('name') ? 'border-red-400' : 'border-gray-200' }} rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                        @error('name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            Description
                        </label>
                        <textarea name="description" rows="3"
                            placeholder="Brief description of this category..."
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all resize-none">{{ old('description') }}</textarea>
                    </div>

                    {{-- Color --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            Color Label
                        </label>
                        <div class="flex gap-3 flex-wrap">
                            @php
                            $colors = [
                                ['value' => 'blue',   'bg' => 'bg-blue-500',   'label' => 'Blue'],
                                ['value' => 'green',  'bg' => 'bg-green-500',  'label' => 'Green'],
                                ['value' => 'yellow', 'bg' => 'bg-yellow-500', 'label' => 'Yellow'],
                                ['value' => 'red',    'bg' => 'bg-red-500',    'label' => 'Red'],
                                ['value' => 'purple', 'bg' => 'bg-purple-500', 'label' => 'Purple'],
                                ['value' => 'pink',   'bg' => 'bg-pink-500',   'label' => 'Pink'],
                                ['value' => 'indigo', 'bg' => 'bg-indigo-500', 'label' => 'Indigo'],
                                ['value' => 'orange', 'bg' => 'bg-orange-500', 'label' => 'Orange'],
                            ];
                            @endphp
                            @foreach($colors as $color)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="color" value="{{ $color['value'] }}"
                                    class="hidden peer"
                                    {{ old('color', 'blue') === $color['value'] ? 'checked' : '' }}>
                                <div class="w-7 h-7 rounded-full {{ $color['bg'] }} peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-gray-400 transition cursor-pointer"></div>
                                <span class="text-xs text-gray-500">{{ $color['label'] }}</span>
                            </label>
                            @endforeach
                        </div>
                        @error('color')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            Status
                        </label>
                        <select name="status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                            class="flex-1 bg-university-red text-white py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition">
                            Save Category
                        </button>
                        <a href="{{ route('categories.index') }}"
                            class="flex-1 text-center bg-gray-100 text-gray-700 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">
                            Cancel
                        </a>
                    </div>

                </div>
                </form>
            </div>
        </div>

        {{-- Side Info --}}
        <div class="flex flex-col gap-6">

            {{-- Existing Categories --}}
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-base font-semibold text-gray-800 mb-4">Existing Categories</h3>
                <div class="space-y-2">
                    @php
                    $sideColors = [
                        'blue'   => ['bg' => 'bg-blue-100',   'text' => 'text-blue-700'],
                        'green'  => ['bg' => 'bg-green-100',  'text' => 'text-green-700'],
                        'yellow' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
                        'red'    => ['bg' => 'bg-red-100',    'text' => 'text-red-700'],
                        'purple' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
                        'pink'   => ['bg' => 'bg-pink-100',   'text' => 'text-pink-700'],
                        'indigo' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-700'],
                        'orange' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700'],
                    ];
                    @endphp
                    @forelse($existing as $e)
                    @php $sc = $sideColors[$e->color] ?? $sideColors['blue']; @endphp
                    <div class="flex justify-between items-center py-2 border-b border-gray-50 last:border-0">
                        <span class="px-2 py-1 rounded-md text-xs font-bold {{ $sc['bg'] }} {{ $sc['text'] }}">
                            {{ $e->name }}
                        </span>
                        <span class="text-xs text-gray-400">{{ $e->status }}</span>
                    </div>
                    @empty
                    <p class="text-xs text-gray-400">No categories yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Tips --}}
            <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                <h4 class="text-sm font-semibold text-blue-800 mb-2">💡 Tips</h4>
                <ul class="text-xs text-blue-700 space-y-1.5">
                    <li>• Use short, clear category names.</li>
                    <li>• Each category maps to a document type.</li>
                    <li>• Inactive categories won't appear in forms.</li>
                    <li>• You can edit or delete categories anytime.</li>
                </ul>
            </div>

        </div>

    </div>

</x-layouts.app>