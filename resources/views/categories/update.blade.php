<x-layouts.app title="Edit Category">

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
        <h2 class="text-2xl font-bold text-gray-800">Edit Category</h2>
        <p class="text-sm text-gray-500 mt-1">Update the document submission category.</p>
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
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-800">Category Details</h3>
            </div>

            <form method="POST" action="{{ route('categories.update', $category) }}">
            @csrf @method('PUT')
            <div class="p-6 space-y-5">

                {{-- Name --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                        Category Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}"
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
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all resize-none">{{ old('description', $category->description) }}</textarea>
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
                                {{ old('color', $category->color) === $color['value'] ? 'checked' : '' }}>
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
                        <option value="active"   {{ old('status', $category->status) === 'active'   ? 'selected' : '' }}>✅ Active</option>
                        <option value="inactive" {{ old('status', $category->status) === 'inactive' ? 'selected' : '' }}>⏸ Inactive</option>
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 bg-university-red text-white py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition shadow-sm">
                        💾 Save Changes
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

        {{-- Record Info --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-semibold text-gray-800 mb-4">Record Info</h3>
            @php
            $colorMap = [
                'blue'   => 'bg-blue-500',   'green'  => 'bg-green-500',
                'yellow' => 'bg-yellow-500', 'red'    => 'bg-red-500',
                'purple' => 'bg-purple-500', 'pink'   => 'bg-pink-500',
                'indigo' => 'bg-indigo-500', 'orange' => 'bg-orange-500',
            ];
            @endphp
            <div class="space-y-3 text-xs text-gray-500">
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span>Category ID</span>
                    <span class="font-mono font-semibold text-gray-700 bg-gray-100 px-2 py-0.5 rounded">#{{ $category->id }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span>Created</span>
                    <span class="font-semibold text-gray-700">{{ $category->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span>Last Updated</span>
                    <span class="font-semibold text-gray-700">{{ $category->updated_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span>Status</span>
                    @if($category->isActive())
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Inactive
                        </span>
                    @endif
                </div>
                <div class="flex justify-between items-center py-2">
                    <span>Color</span>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-full shadow-sm {{ $colorMap[$category->color] ?? 'bg-gray-400' }}"></div>
                        <span class="font-semibold text-gray-700 capitalize">{{ $category->color }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Other Categories --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-semibold text-gray-800 mb-4">Other Categories</h3>
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
                <p class="text-xs text-gray-400 text-center py-4">No other categories.</p>
                @endforelse
            </div>
        </div>

        {{-- Danger Zone --}}
        <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-6">
            <div class="flex items-center gap-2 mb-2">
                <svg class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
                <h3 class="text-base font-semibold text-red-600">Danger Zone</h3>
            </div>
            <p class="text-xs text-gray-400 mb-4">Deleting this category is permanent and cannot be undone.</p>
            <form method="POST" action="{{ route('categories.destroy', $category) }}"
                onsubmit="return confirm('Delete category \'{{ $category->name }}\'? This cannot be undone.')">
                @csrf @method('DELETE')
                <button type="submit"
                    class="w-full bg-red-50 text-red-700 py-2.5 rounded-xl text-sm font-semibold hover:bg-red-100 transition border border-red-200">
                    🗑 Delete Category
                </button>
            </form>
        </div>

    </div>

</div>

</x-layouts.app>