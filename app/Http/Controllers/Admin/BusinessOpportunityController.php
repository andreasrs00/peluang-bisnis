<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessOpportunity;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BusinessOpportunityController extends Controller
{
    public function index()
    {
        $items = BusinessOpportunity::latest()->paginate(10);
        return view('admin.opportunities.index', compact('items'));
    }

    public function create()
    {
        return view('admin.opportunities.create');
    }

    public function store(Request $request)
    {
        $allowedCategories = [
            'Pangan',
            'Sandang',
            'Manufaktur',
            'Teknologi Informasi',
            'Material Maju',
            'Kesehatan & kosmetik',
            'Jasa Lainnya',
        ];

        $allowedPartners = [
            'Investor',
            'Reseller',
            'Distributor',
            'Buyer',
        ];

        $data = $request->validate([
            'category'      => 'required|in:' . implode(',', $allowedCategories),
            'product_name'  => 'required|string|max:255',
            'product_type'  => 'required|string|max:255',
            'social_media'  => 'nullable|string|max:255',
            'website'       => 'nullable|string|max:255',
            'partner_need'  => 'nullable|in:' . implode(',', $allowedPartners),
            'lat'           => 'required|numeric',
            'lng'           => 'required|numeric',
            'is_active'     => 'sometimes|boolean',
            'is_featured'   => 'sometimes|boolean',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['slug']        = Str::slug($data['product_name']) . '-' . Str::random(6);
        $data['is_active']   = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        // ✅ upload gambar
        if ($request->hasFile('image')) {
            // akan tersimpan di storage/app/public/opportunities/xxxx.ext
            $data['image_path'] = $request->file('image')->store('opportunities', 'public');
        }

        BusinessOpportunity::create($data);

        return redirect()
            ->route('admin.peluang_bisnis.index')
            ->with('success', 'Berhasil ditambah');
    }

    public function edit(string $id)
    {
        $item = BusinessOpportunity::findOrFail($id);
        return view('admin.opportunities.edit', compact('item'));
    }

    public function update(Request $request, string $id)
    {
        $item = BusinessOpportunity::findOrFail($id);

        $allowedCategories = [
                'Pangan',
                'Sandang',
                'Manufaktur',
                'Teknologi Informasi',
                'Material Maju',
                'Kesehatan & kosmetik',
                'Jasa Lainnya',
        ];

        $allowedPartners = [
            'Investor',
            'Reseller',
            'Distributor',
            'Buyer',
        ];

        $data = $request->validate([
            'category'      => 'required|in:' . implode(',', $allowedCategories),
            'product_name'  => 'required|string|max:255',     // ✅ WAJIB, karena dipakai buat slug
            'product_type'  => 'required|string|max:255',     // ✅ kamu punya field ini di create
            'social_media'  => 'nullable|string|max:255',
            'website'       => 'nullable|string|max:255',
            'partner_need'  => 'nullable|in:' . implode(',', $allowedPartners),
            'lat'           => 'required|numeric',
            'lng'           => 'required|numeric',
            'is_active'     => 'sometimes|boolean',
            'is_featured'   => 'sometimes|boolean',

            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_image'  => 'sometimes|boolean',
        ]);

        $data['is_active']   = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        // ✅ slug regen kalau nama berubah
        if ($item->product_name !== $data['product_name']) {
            $data['slug'] = Str::slug($data['product_name']) . '-' . Str::random(6);
        }

        // ✅ remove image
        if ($request->boolean('remove_image')) {
            if ($item->image_path && Storage::disk('public')->exists($item->image_path)) {
                Storage::disk('public')->delete($item->image_path);
            }
            $data['image_path'] = null;
        }

        // ✅ upload baru (overwrite)
        if ($request->hasFile('image')) {
            if ($item->image_path && Storage::disk('public')->exists($item->image_path)) {
                Storage::disk('public')->delete($item->image_path);
            }
            $data['image_path'] = $request->file('image')->store('opportunities', 'public');
        }

        $item->update($data);

        return redirect()
            ->route('admin.peluang_bisnis.index')
            ->with('success', 'Berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $item = BusinessOpportunity::findOrFail($id);

        if ($item->image_path && Storage::disk('public')->exists($item->image_path)) {
            Storage::disk('public')->delete($item->image_path);
        }

        $item->delete();

        return redirect()
            ->route('admin.peluang_bisnis.index')
            ->with('success', 'Berhasil dihapus');
    }
}
