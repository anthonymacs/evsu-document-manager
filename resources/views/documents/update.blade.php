<x-layouts.app title="Edit Submission">

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
        <h2 class="text-2xl font-bold text-gray-800">Edit Submission</h2>
        <p class="text-sm text-gray-500 mt-1">Update the document submission record.</p>
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
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-800">Submission Details</h3>
            </div>

            <form method="POST" action="{{ route('documents.update', $document) }}" class="p-6 space-y-5">
            @csrf @method('PUT')

                {{-- Faculty Name --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                        Faculty Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="faculty_name"
                        value="{{ old('faculty_name', $document->faculty_name) }}"
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
                            <option value="{{ $cat->id }}"
                                {{ old('category_id', $document->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
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
                            <option value="{{ $s }}"
                                {{ old('status', $document->status) === $s ? 'selected' : '' }}>
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
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all resize-none">{{ old('remarks', $document->remarks) }}</textarea>
                </div>

                {{-- Date --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                        Submission Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="submission_date"
                        value="{{ old('submission_date', $document->submission_date->format('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 bg-gray-50 border @error('submission_date') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                    @error('submission_date')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 bg-university-red text-white py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition shadow-sm">
                        💾 Save Changes
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

        {{-- Record Info --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-semibold text-gray-800 mb-4">Record Info</h3>
            @php
            $statusColors = [
                'submitted' => 'bg-yellow-100 text-yellow-800',
                'reviewed'  => 'bg-blue-100   text-blue-800',
                'approved'  => 'bg-green-100  text-green-800',
                'rejected'  => 'bg-red-100    text-red-800',
            ];
            @endphp
            <div class="space-y-0 text-xs text-gray-500">
                <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                    <span>Document ID</span>
                    <span class="font-mono font-semibold text-gray-700 bg-gray-100 px-2 py-0.5 rounded">#{{ $document->id }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                    <span>Faculty</span>
                    <span class="font-semibold text-gray-700">{{ $document->faculty_name }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                    <span>Created</span>
                    <span class="font-semibold text-gray-700">{{ $document->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                    <span>Last Updated</span>
                    <span class="font-semibold text-gray-700">{{ $document->updated_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                    <span>Status</span>
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusColors[$document->status] }}">
                        {{ ucfirst($document->status) }}
                    </span>
                </div>
                @if($document->category)
                <div class="flex justify-between items-center py-2.5">
                    <span>Category</span>
                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold"
                        style="background-color:{{ $document->category->color }}18; color:{{ $document->category->color }}">
                        {{ $document->category->name }}
                    </span>
                </div>
                @endif
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
            <p class="text-xs text-gray-400 mb-4">Deleting this record is permanent and cannot be undone.</p>
            <x-ui.delete-button
                :action="route('documents.destroy', $document)"
                :name="$document->faculty_name"
                label="🗑 Delete Submission"
                size="md"
                class="w-full justify-center" />
        </div>

    </div>

</div>

</x-layouts.app>