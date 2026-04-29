<x-layouts.app title="Log Submission">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Log Document Submission</h2>
            <p class="text-sm text-gray-500 mt-1">Record a faculty member's document submission.</p>
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
                <div class="p-6 space-y-5">

                    {{-- Faculty Name --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            Faculty Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" placeholder="e.g. John Jaro"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                    </div>

                    {{-- Category --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            Document Category <span class="text-red-500">*</span>
                        </label>
                        <select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                            <option value="">-- Select Category --</option>
                            <option value="csr">CSR</option>
                            <option value="teaching-load">Teaching Load</option>
                            <option value="clearance-letter">Clearance Letter</option>
                            <option value="syllabus">Syllabus</option>
                            <option value="pr">PR</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                            <option value="submitted">Submitted</option>
                            <option value="reviewed">Reviewed</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>

                    {{-- Remarks --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            Remarks
                            <span class="text-gray-400 font-normal normal-case tracking-normal ml-1">(optional)</span>
                        </label>
                        <textarea rows="3" placeholder="e.g. Hard copy submitted, original document..."
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all resize-none"></textarea>
                    </div>

                    {{-- Date --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            Submission Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" value="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                            class="flex-1 bg-university-red text-white py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition">
                            ✅ Log Submission
                        </button>
                        <a href="{{ route('documents.index') }}"
                            class="flex-1 text-center bg-gray-100 text-gray-700 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">
                            Cancel
                        </a>
                    </div>

                </div>
            </div>
        </div>

        {{-- Side Panel --}}
        <div class="flex flex-col gap-6">

            {{-- Category Summary --}}
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-base font-semibold text-gray-800 mb-4">Category Summary</h3>
                <div class="space-y-3">
                    @php
                    $bars = [
                        ['label' => 'CSR',           'count' => 24, 'max' => 87, 'color' => 'bg-blue-500'],
                        ['label' => 'Teaching Load', 'count' => 18, 'max' => 87, 'color' => 'bg-green-500'],
                        ['label' => 'Clearance',     'count' => 15, 'max' => 87, 'color' => 'bg-yellow-500'],
                        ['label' => 'Syllabus',      'count' => 17, 'max' => 87, 'color' => 'bg-red-500'],
                        ['label' => 'PR',            'count' => 13, 'max' => 87, 'color' => 'bg-purple-500'],
                    ];
                    @endphp
                    @foreach($bars as $bar)
                    <div>
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>{{ $bar['label'] }}</span>
                            <span class="font-semibold">{{ $bar['count'] }}</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5">
                            <div class="{{ $bar['color'] }} h-1.5 rounded-full"
                                style="width: {{ round(($bar['count'] / $bar['max']) * 100) }}%">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Recent Submissions --}}
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-base font-semibold text-gray-800 mb-4">Recent Submissions</h3>
                <div class="space-y-3">
                    @php
                    $recent = [
                        ['name' => 'John Jaro',     'cat' => 'CSR',          'bg' => 'bg-blue-100',   'text' => 'text-blue-700'],
                        ['name' => 'Maria Santos',  'cat' => 'Syllabus',     'bg' => 'bg-red-100',    'text' => 'text-red-700'],
                        ['name' => 'Carlo Reyes',   'cat' => 'Teaching Load','bg' => 'bg-green-100',  'text' => 'text-green-700'],
                        ['name' => 'Ana Dela Cruz', 'cat' => 'Clearance',    'bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
                        ['name' => 'Jose Mendoza',  'cat' => 'PR',           'bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
                    ];
                    @endphp
                    @foreach($recent as $r)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="h-6 w-6 rounded-full bg-university-red text-white text-xs flex items-center justify-center font-semibold flex-shrink-0">
                                {{ strtoupper(substr($r['name'], 0, 1)) }}
                            </div>
                            <span class="text-xs text-gray-700 font-medium">{{ $r['name'] }}</span>
                        </div>
                        <span class="px-2 py-0.5 rounded-md text-xs font-semibold {{ $r['bg'] }} {{ $r['text'] }}">
                            {{ $r['cat'] }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

</x-layouts.app>