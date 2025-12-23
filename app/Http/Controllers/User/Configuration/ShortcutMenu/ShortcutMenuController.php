<?php

namespace App\Http\Controllers\User\Configuration\ShortcutMenu;

use App\DataTables\ShortcutDataTable;
use App\Http\Controllers\Controller;
use App\Models\Shortcutmenu;
use Carbon\Carbon;
use App\Helpers\FileManager;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ShortcutMenuRequest;
use Illuminate\Http\Request;
use App\Helpers\Traits\DeleteLogTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ShortcutMenuController extends Controller
{
    use DeleteLogTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(ShortcutDataTable $dataTable)
    {
        $pageTitle = __('messages.shortcut_menu') . ' ' . __('messages.list');
        return $dataTable->render('user.config.shortcut-menu.index', compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShortcutMenuRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = new Shortcutmenu();

            $file = new FileManager();
            // For sortcut manu icon image
            if ($request->img) {
                $img = $request->img;
                $file->folder('shortcut-manu-icon')->prefix('shortcut_manu_icon')->upload($img) ? $image = $file->getName() : null;
            } else {
                $image = null;
            }

            $data->title = $request->title;
            $data->address = $request->address;
            $data->icon = $request->icon;
            $data->img = $image;
            $data->bg_color = $request->bg_color;
            $data->text_color = $request->text_color;
            $data->created_by = Auth::user()->created_by;
            $data->save();

            DB::commit();

            toast('Shortcut Menu Added Successfully!', 'success');
            return redirect()->route('user.configuration.shortcut-menu.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Shortcutmenu::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShortcutMenuRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $data = Shortcutmenu::findOrFail($id);
            if ($data->img != null) {
                Storage::disk('shortcut-manu-icon')->delete($data->img);
            }
            $file = new FileManager();
            // For sortcut manu icon image
            if ($request->img) {
                $img = $request->img;
                $file->folder('shortcut-manu-icon')->prefix('shortcut_manu_icon')->upload($img) ? $image = $file->getName() : null;
            } else {
                $image = null;
            }

            $data->title = $request->title;
            $data->address = $request->address;
            $data->icon = $request->icon;
            $data->img = $image;
            $data->bg_color = $request->bg_color;
            $data->text_color = $request->text_color;
            $data->updated_by = Auth::user()->created_by;
            $data->save();

            DB::commit();

            toast('Shortcut Menu Updated Successfully!', 'success');
            return response()->json($data);
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        /**
         * For the delete log
         * 1. Model Name
         * 2. Row ID
         */

        $this->deleteLog(Shortcutmenu::class, $id);


        toast('Shortcut Menu Deleted !', 'error', 'top-right');
        return redirect()->back();
    }
}
