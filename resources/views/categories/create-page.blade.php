<x-layouts.app title="Add Category">

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up         { animation: fadeInUp 0.4s ease forwards; }
    .animate-fade-up-delay-1 { animation: fadeInUp 0.4s ease 0.08s forwards; opacity: 0; }
    .animate-fade-up-delay-2 { animation: fadeInUp 0.4s ease 0.16s forwards; opacity: 0; }
</style>
@endpush

{{-- Header --}}
<div class="flex flex-wrap justify-between items-start gap-4 mb-8 animate-fade-up">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Add Category</h2>
        <p class="text-sm text-gray-500 mt-1">Create a new document submission category.</p>
    </div>
    <a href="{{ route('categories.index') }}"
        class="border border-gray-200 text-gray-600 px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-50 transition flex items-center gap-2">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Categories
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Form --}}
    <div class="lg:col-span-2 animate-fade-up-delay-1">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 bg-university-red/10 rounded-xl flex items-center justify-center">
                    <svg class="h-4 w-4 text-university-red" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5l5 5v11a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h2z"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-800">Category Details</h3>
            </div>

            <form method="POST" action="{{ route('categories.store') }}">
            @csrf
            <div class="p-6 space-y-5">

                {{-- Name --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                        Category Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        placeholder="e.g. CSR, Teaching Load, Syllabus..."
                        class="w-full px-4 py-2.5 bg-gray-50 border {{ $errors->has('name') ? 'border-red-400' : 'border-gray-200' }} rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                    @error('name')
                        <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1">
                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                        Description <span class="text-gray-400 font-normal normal-case tracking-normal">(optional)</span>
                    </label>
                    <textarea name="description" rows="3"
                        placeholder="Brief description of this category..."
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all resize-none">{{ old('description') }}</textarea>
                </div>

                {{-- Color --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">
                        Color Label
                    </label>
                    @php
                    $colors = [
                        ['value' => 'blue',   'bg' => 'bg-blue-500',   'ring' => 'ring-blue-400',   'label' => 'Blue'],
                        ['value' => 'green',  'bg' => 'bg-green-500',  'ring' => 'ring-green-400',  'label' => 'Green'],
                        ['value' => 'yellow', 'bg' => 'bg-yellow-500', 'ring' => 'ring-yellow-400', 'label' => 'Yellow'],
                        ['value' => 'red',    'bg' => 'bg-red-500',    'ring' => 'ring-red-400',    'label' => 'Red'],
                        ['value' => 'purple', 'bg' => 'bg-purple-500', 'ring' => 'ring-purple-400', 'label' => 'Purple'],
                        ['value' => 'pink',   'bg' => 'bg-pink-500',   'ring' => 'ring-pink-400',   'label' => 'Pink'],
                        ['value' => 'indigo', 'bg' => 'bg-indigo-500', 'ring' => 'ring-indigo-400', 'label' => 'Indigo'],
                        ['value' => 'orange', 'bg' => 'bg-orange-500', 'ring' => 'ring-orange-400', 'label' => 'Orange'],
                    ];
                    @endphp
                    <div class="grid grid-cols-4 sm:grid-cols-8 gap-3">
                        @foreach($colors as $color)
                        <label class="flex flex-col items-center gap-1.5 cursor-pointer group">
                            <input type="radio" name="color" value="{{ $color['value'] }}"
                                class="hidden peer"
                                {{ old('color', 'blue') === $color['value'] ? 'checked' : '' }}>
                            <div class="w-9 h-9 rounded-full {{ $color['bg'] }} peer-checked:ring-2 peer-checked:ring-offset-2 {{ $color['ring'] }} transition-all group-hover:scale-110 shadow-sm"></div>
                            <span class="text-xs text-gray-400 group-hover:text-gray-600 transition">{{ $color['label'] }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('color')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                        Status
                    </label>
                    <select name="status"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                        <option value="active"   {{ old('status') === 'active'   ? 'selected' : '' }}>✅ Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>⏸ Inactive</option>
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 bg-university-red text-white py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition shadow-sm">
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

    {{-- Sidebar --}}
    <div class="flex flex-col gap-5 animate-fade-up-delay-2">

        {{-- Existing Categories --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-base font-semibold text-gray-800">Existing Categories</h3>
                <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">{{ count($existing) }}</span>
            </div>
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
            <div class="space-y-2">
                @forelse($existing as $e)
                @php $sc = $sideColors[$e->color] ?? $sideColors['blue']; @endphp
                <div class="flex justify-between items-center py-2 border-b border-gray-50 last:border-0">
                    <span class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $sc['bg'] }} {{ $sc['text'] }}">
                        {{ $e->name }}
                    </span>
                    @if($e->isActive())
                        <span class="text-xs text-green-600 font-medium">Active</span>
                    @else
                        <span class="text-xs text-gray-400">Inactive</span>
                    @endif
                </div>
                @empty
                <div class="text-center py-6">
                    <p class="text-xs text-gray-400">No categories yet.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Tips --}}
        <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100">
            <h4 class="text-sm font-semibold text-blue-800 mb-3 flex items-center gap-2">
                <span>💡</span> Tips
            </h4>
            <ul class="text-xs text-blue-700 space-y-2">
                <li class="flex items-start gap-2"><span class="mt-0.5">•</span> Use short, clear category names.</li>
                <li class="flex items-start gap-2"><span class="mt-0.5">•</span> Each category maps to a document type.</li>
                <li class="flex items-start gap-2"><span class="mt-0.5">•</span> Inactive categories won't appear in forms.</li>
                <li class="flex items-start gap-2"><span class="mt-0.5">•</span> You can edit or delete categories anytime.</li>
            </ul>
        </div>

    </div>

</div>

</x-layouts.app>