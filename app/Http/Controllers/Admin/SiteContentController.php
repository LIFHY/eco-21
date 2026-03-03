<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteContent;
use Illuminate\Http\Request;

class SiteContentController extends Controller
{
    /**
     * Display all site content organized by sections
     */
    public function index()
    {
        $sections = SiteContent::distinct()->pluck('section')->sort();
        $contents = [];
        
        foreach ($sections as $section) {
            $contents[$section] = SiteContent::getBySection($section);
        }
        
        return view('admin.content.index', compact('contents', 'sections'));
    }

    /**
     * Show form to edit a specific content
     */
    public function edit(SiteContent $siteContent)
    {
        return view('admin.content.edit', compact('siteContent'));
    }

    /**
     * Update content
     */
    public function update(Request $request, SiteContent $siteContent)
    {
        $data = [];

        // Validate based on content type
        if ($siteContent->content_type === 'image') {
            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => 'required|image|max:2048',
                ]);
                
                // Delete old image if exists
                if ($siteContent->image_path && file_exists(public_path($siteContent->image_path))) {
                    @unlink(public_path($siteContent->image_path));
                }

                // Upload new image
                $file = $request->file('image');
                $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '_', $file->getClientOriginalName());
                $file->move(public_path('images/content'), $filename);
                $data['image_path'] = 'images/content/' . $filename;
            }
        } else {
            // Text content validation
            $request->validate([
                'content' => 'required|string|max:5000',
            ]);
            $data['content'] = $request->input('content');
        }

        $siteContent->update($data);

        return redirect()->route('admin.content.index')->with('success', 'Konten berhasil diupdate');
    }

    /**
     * Create new content (for adding new items)
     */
    public function create()
    {
        return view('admin.content.create');
    }

    /**
     * Store new content
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string|unique:site_content|max:255',
            'content_type' => 'required|in:text,image,textarea,number',
            'content' => 'required_unless:content_type,image|string|max:5000',
            'image' => 'required_if:content_type,image|image|max:2048',
            'section' => 'required|string|max:255',
            'order' => 'integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '_', $file->getClientOriginalName());
            $file->move(public_path('images/content'), $filename);
            $data['image_path'] = 'images/content/' . $filename;
        }

        SiteContent::create($data);

        return redirect()->route('admin.content.index')->with('success', 'Konten baru berhasil ditambahkan');
    }

    /**
     * Delete content
     */
    public function destroy(SiteContent $siteContent)
    {
        // Delete image if exists
        if ($siteContent->image_path && file_exists(public_path($siteContent->image_path))) {
            @unlink(public_path($siteContent->image_path));
        }

        $siteContent->delete();

        return redirect()->route('admin.content.index')->with('success', 'Konten berhasil dihapus');
    }
}
