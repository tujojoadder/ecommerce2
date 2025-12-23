<?php

namespace App\Http\Controllers\User\Configuration\CompanyInformation;

use App\Http\Controllers\Controller;
use App\Models\CompanyInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Helpers\FileManager;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Traits\DeleteLogTrait;
use Illuminate\Support\Facades\DB;

class CompanyInformationController extends Controller
{
    use DeleteLogTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = __('messages.company_information');
        $company = CompanyInformation::first();
        return view('user.config.company-information.index', compact('pageTitle', 'company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = CompanyInformation::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $data = CompanyInformation::findOrFail($id);
            $data->update($request->except('_token', '_method'));

            $file = new FileManager();
            // For company logo
            if ($request->logo) {
                if ($data->logo != null) {
                    Storage::disk('company')->delete($data->logo);
                }
                $logo = $request->logo;
                $file->folder('company')->prefix('logo')->upload($logo) ? $data->logo = $file->getName() : null;
            }

             if ($request->favicon) {
                if ($data->favicon != null) {
                    Storage::disk('company')->delete($data->favicon);
                }
                $favicon = $request->favicon;
                $file->folder('company')->prefix('favicon')->upload($favicon) ? $data->favicon = $file->getName() : null;
            }

            // For company banner
            if ($request->banner) {
                if ($data->banner != null) {
                    Storage::disk('company')->delete($data->banner);
                }
                $banner = $request->banner;
                $file->folder('company')->prefix('banner')->upload($banner) ? $data->banner = $file->getName() : null;
            }

            // For company banner
            if ($request->invoice_header) {
                if ($data->invoice_header != null) {
                    Storage::disk('company')->delete($data->invoice_header);
                }
                $invoiceHeader = $request->invoice_header;
                $file->folder('company')->prefix('invoice-header')->upload($invoiceHeader) ? $data->invoice_header = $file->getName() : null;
            }

            $data->updated_by = Auth::user()->username;
            $data->save();

            DB::commit();

            toast('Company information Updated Successfully!', 'success');
            return redirect()->back();
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
        $this->deleteLog(CompanyInformation::class, $id);

        toast('Company Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
