<x-layouts.app title="Log Submission">

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
        <h2 class="text-2xl font-bold text-gray-800">Log Document Submission</h2>
        <p class="text-sm text-gray-500 mt-1">Record a faculty member's document submission.</p>
    </div>
    <a href="{{ route('documents.index') }}"
        class="border border-gray-200 text-gray-600 px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-50 transition flex items-center gap-2">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Documents
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
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586l5.414 5.414V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-800">Submission Details</h3>
            </div>

            <form method="POST" action="{{ route('documents.store') }}" class="p-6 space-y-5">
            @csrf

                {{-- Faculty Name --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                        Faculty Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="faculty_name" value="{{ old('faculty_name') }}"
                        placeholder="e.g. John Jaro"
                        class="w-full px-4 py-2.5 bg-gray-50 border @error('faculty_name') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                    @error('faculty_name')
                        <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1">
                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                        Document Category <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id"
                        class="w-full px-4 py-2.5 bg-gray-50 border @error('category_id') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1">
                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status"
                        class="w-full px-4 py-2.5 bg-gray-50 border @error('status') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                        @foreach(['submitted', 'reviewed', 'approved', 'rejected'] as $s)
                            <option value="{{ $s }}" {{ old('status', 'submitted') === $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remarks --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                        Remarks <span class="text-gray-400 font-normal normal-case tracking-normal">(optional)</span>
                    </label>
                    <textarea name="remarks" rows="3"
                        placeholder="e.g. Hard copy submitted, original document..."
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all resize-none">{{ old('remarks') }}</textarea>
                </div>

                {{-- Date --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                        Submission Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="submission_date"
                        value="{{ old('submission_date', date('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 bg-gray-50 border @error('submission_date') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                    @error('submission_date')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 bg-university-red text-white py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition shadow-sm">
                        ✅ Log Submission
                    </button>
                    <a href="{{ route('documents.index') }}"
                        class="flex-1 text-center bg-gray-100 text-gray-700 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="flex flex-col gap-5 animate-fade-up-delay-2">

        {{-- Category Summary --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-base font-semibold text-gray-800">Category Summary</h3>
                <a href="{{ route('categories.index') }}" class="text-xs text-gray-400 hover:text-gray-600 transition">Manage →</a>
            </div>
            @php $totalDocs = $catStats->sum('documents_count'); @endphp
            <div class="space-y-3.5">
                @forelse($catStats as $cat)
                <div>
                    <div class="flex justify-between text-xs mb-1.5">
                        <span class="text-gray-600 font-medium">{{ $cat->name }}</span>
                        <span class="font-bold text-gray-700">{{ $cat->documents_count }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="h-1.5 rounded-full transition-all duration-700"
                            style="width: {{ $totalDocs > 0 ? round(($cat->documents_count / $totalDocs) * 100) : 0 }}%;
                                   background-color: {{ $cat->color ?? '#6b7280' }}">
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <p class="text-xs text-gray-400">No categories yet.</p>
                    <a href="{{ route('categories.create') }}" class="text-xs text-university-red hover:underline mt-1 inline-block">
                        Add a category →
                    </a>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Recent Submissions --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-semibold text-gray-800 mb-4">Recent Submissions</h3>
            <div class="space-y-3">
                @forelse($recent as $r)
                <div class="flex items-center justify-between py-1">
                    <div class="flex items-center gap-2.5">
                        <div class="h-7 w-7 rounded-full bg-university-red text-white text-xs flex items-center justify-center font-semibold flex-shrink-0">
                            {{ strtoupper(substr($r->faculty_name, 0, 1)) }}
                        </div>
                        <span class="text-xs text-gray-700 font-medium">{{ $r->faculty_name }}</span>
                    </div>
                    @if($r->category)
                        <span class="px-2 py-0.5 rounded-md text-xs font-semibold"
                            style="background-color:{{ $r->category->color }}22; color:{{ $r->category->color }}">
                            {{ $r->category->name }}
                        </span>
                    @endif
                </div>
                @empty
                <p class="text-xs text-gray-400 text-center py-4">No recent submissions.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>

</x-layouts.app>