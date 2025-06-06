<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function index()
    {
        $pages  = Page::all();
        $slides = Slide::orderBy('orden')->get();
        return view('admin.pages.index', compact('pages', 'slides'));
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'image'      => 'nullable|image',
            'image2'     => 'nullable|image',
            'image3'     => 'nullable|image',
            'video_url'  => 'nullable|url',
        ]);

        // Actualizo campos básicos
        $page->update([
            'title'   => $data['title'],
            'content' => html_entity_decode($data['content']),
        ]);

        // Imagen principal
        if ($request->hasFile('image')) {
            // Solo borro si había una imagen anterior
            if ($page->image) {
                Storage::disk('public')->delete($page->image);
            }
            $page->update([
                'image' => $request->file('image')->store('pages', 'public')
            ]);
        }

        // Campos extra solo para 'informacion-importante'
        if ($page->slug === 'informacion-importante') {
            // Imagen secundaria y adicional
            foreach (['image2', 'image3'] as $field) {
                if ($request->hasFile($field)) {
                    if ($page->$field) {
                        Storage::disk('public')->delete($page->$field);
                    }
                    $page->update([
                        $field => $request->file($field)->store('pages', 'public'),
                    ]);
                }
            }

            // Vídeo (no necesita borrado)
            $page->update([
                'video_url' => $data['video_url']
            ]);
        }

        return back()->with('success', 'Se guardó correctamente');
    }
}
