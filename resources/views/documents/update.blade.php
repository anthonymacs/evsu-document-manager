<x-layouts.app title="Edit Submission">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Edit Submission</h2>
            <p class="text-sm text-gray-500 mt-1">Update the document submission record.</p>
        </div>
        <a href="{{ route('documents.index') }}"
            class="border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-50 transition flex items-center gap-2">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Documents
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Form --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-base font-semibold text-gray-800">Submission Details</h3>
                </div>

                <form method="POST" action="{{ route('documents.update', $document) }}" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')

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
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
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
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
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
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remarks --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            Remarks
                            <span class="text-gray-400 font-normal normal-case tracking-normal ml-1">(optional)</span>
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
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                            class="flex-1 bg-university-red text-white py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition">
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

        {{-- Side Panel --}}
        <div class="flex flex-col gap-6">

            {{-- Record Info --}}
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-base font-semibold text-gray-800 mb-4">Record Info</h3>
                <div class="space-y-3 text-xs text-gray-500">
                    <div class="flex justify-between">
                        <span>Document ID</span>
                        <span class="font-semibold text-gray-700">#{{ $document->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Faculty Name</span>
                        <span class="font-semibold text-gray-700">{{ $document->faculty_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Created</span>
                        <span class="font-semibold text-gray-700">{{ $document->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Last Updated</span>
                        <span class="font-semibold text-gray-700">{{ $document->updated_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>Current Status</span>
                        @php
                        $statusColors = [
                            'submitted' => 'bg-yellow-100 text-yellow-800',
                            'reviewed'  => 'bg-blue-100 text-blue-800',
                            'approved'  => 'bg-green-100 text-green-800',
                            'rejected'  => 'bg-red-100 text-red-800',
                        ];
                        @endphp
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $statusColors[$document->status] }}">
                            {{ ucfirst($document->status) }}
                        </span>
                    </div>
                    @if($document->category)
                    <div class="flex justify-between items-center">
                        <span>Category</span>
                        <span class="px-2 py-0.5 rounded-md text-xs font-semibold"
                            style="background-color: {{ $document->category->color }}22; color: {{ $document->category->color }}">
                            {{ $document->category->name }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="bg-white rounded-xl shadow-sm p-6 border border-red-100">
                <h3 class="text-base font-semibold text-red-600 mb-2">Danger Zone</h3>
                <p class="text-xs text-gray-400 mb-4">
                    Deleting this record is permanent and cannot be undone.
                </p>
                <form method="POST" action="{{ route('documents.destroy', $document) }}"
                    onsubmit="return confirm('Are you sure you want to delete this submission? This cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-50 text-red-700 py-2 rounded-xl text-sm font-semibold hover:bg-red-100 transition">
                        🗑 Delete Submission
                    </button>
                </form>
            </div>

        </div>

    </div>

</x-layouts.app>