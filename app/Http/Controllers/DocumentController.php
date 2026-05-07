<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Category;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with('category')->latest();

        if ($request->filled('search')) {
            $query->where('faculty_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $documents   = $query->paginate(10)->withQueryString();
        $categories  = Category::where('status', 'active')->orderBy('name')->get();
        $total       = Document::count();

        $statusCounts = Document::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('documents.index', compact('documents', 'categories', 'total', 'statusCounts'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        $recent     = Document::with('category')->latest()->take(5)->get();
        $catStats   = Category::withCount('documents')->get();

        return view('documents.create-page', compact('categories', 'recent', 'catStats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'faculty_name'    => 'required|string|max:255',
            'category_id'     => 'required|exists:nativephp.categories,id', // ✅ FIX: specify nativephp connection
            'status'          => 'required|in:submitted,reviewed,approved,rejected',
            'remarks'         => 'nullable|string',
            'submission_date' => 'required|date',
        ]);

        Document::create($validated);

        return redirect()->route('documents.index')
            ->with('notify', [
                'message' => 'Document submission logged successfully.',
                'type'    => 'success',
            ]);
    }

    public function edit(Document $document)
    {
        $categories = Category::where('status', 'active')->orderBy('name')->get();

        // If the document's current category is inactive, still include it so the form doesn't break
        if ($document->category && $document->category->status !== 'active') {
            $categories = $categories->prepend($document->category);
        }

        return view('documents.update', compact('document', 'categories'));
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'faculty_name'    => 'required|string|max:255',
            'category_id'     => 'required|exists:nativephp.categories,id', // ✅ FIX: specify nativephp connection
            'status'          => 'required|in:submitted,reviewed,approved,rejected',
            'remarks'         => 'nullable|string',
            'submission_date' => 'required|date',
        ]);

        $document->update($validated);

        return redirect()->route('documents.index')
            ->with('notify', [
                'message' => 'Document updated successfully.',
                'type'    => 'success',
            ]);
    }

    public function destroy(Document $document)
    {
        $document->delete();

        return redirect()->route('documents.index')
            ->with('notify', [
                'message' => 'Document deleted successfully.',
                'type'    => 'success',
            ]);
    }
}