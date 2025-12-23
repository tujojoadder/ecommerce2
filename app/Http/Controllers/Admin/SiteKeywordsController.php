<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SiteKeywordDataTable;
use App\Helpers\Traits\DeleteLogTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Models\SiteKeyword;
use Illuminate\Http\Request;

class SiteKeywordsController extends Controller
{
    use DeleteLogTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(SiteKeywordDataTable $dataTable)
    {
        $pageTitle = "Language Settings";
        return $dataTable->render('admin.language.index', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LanguageRequest $request)
    {
        $keyword = $request->keyword;
        $check = SiteKeyword::where('keyword', $keyword)->count();
        if ($check >= 1) {
            $data = 'duplicate';
            return response()->json($data);
        } else {
            $data = new SiteKeyword($request->all());
            $data->save();
            toast('Successfully Added!', 'success');
            return response()->json($data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = SiteKeyword::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LanguageRequest $request, string $id)
    {
        $language = SiteKeyword::findOrFail($id);
        $language->update($request->except('_token', '_method'));
        $language->save();
        toast('Successfully Updated!', 'success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        SiteKeyword::findOrFail($id)->delete();
        toast('Lnaguage Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
