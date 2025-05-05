<?php

namespace App\Http\Controllers;

use App\Models\LoaiSP;
use Illuminate\Http\Request;

class LoaiSPController extends Controller
{
    public function index(Request $request)
    {
        $sortColumn = $request->get('sort', 'loai_sp');
        $sortDirection = $request->get('direction', 'asc');
        $search = $request->get('search');

        $query = LoaiSP::withCount('sanPhams');

        if ($search) {
            $query->where('loai_sp', 'like', "%{$search}%");
        }

        $loaiSPs = $query->orderBy($sortColumn, $sortDirection)->paginate(10);

        return view('loaisp.index', compact('loaiSPs', 'sortColumn', 'sortDirection', 'search'));
    }

    public function create()
    {
        return view('loaisp.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'loai_sp' => 'required|string|max:20|unique:loai_sp',
        ]);

        LoaiSP::create($request->all());
        return redirect()->route('loai-sp.index')->with('success', 'Thêm loại sản phẩm thành công!');
    }

    public function edit($loai_sp)
    {
        $loaiSP = LoaiSP::findOrFail($loai_sp);
        return view('loaisp.edit', compact('loaiSP'));
    }

    public function update(Request $request, $loai_sp)
    {
        $request->validate([
            'loai_sp' => 'required|string|max:20|unique:loai_sp,loai_sp,' . $loai_sp . ',loai_sp',
        ]);

        $loaiSP = LoaiSP::findOrFail($loai_sp);
        $loaiSP->update($request->all());
        return redirect()->route('loai-sp.index')->with('success', 'Cập nhật loại sản phẩm thành công!');
    }

    public function destroy($loai_sp)
    {
        $loaiSP = LoaiSP::findOrFail($loai_sp);
        $loaiSP->delete();
        return redirect()->route('loai-sp.index')->with('success', 'Xóa loại sản phẩm thành công!');
    }
}