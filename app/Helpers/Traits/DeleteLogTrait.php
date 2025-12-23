<?php

namespace App\Helpers\Traits;

use App\Models\DeleteLog;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait DeleteLogTrait
{
    use AccountBalanceTrait;
    public function deleteLog($model, $row)
    {
        // Deleted status update
        $find = $model::findOrFail($row);
        $find->deleted_by = Auth::user()->username;
        $find->save();
        $find->delete();

        if ($model == Transaction::class) {
            $this->adjustBalance($find->account_id, 'delete-cost', $find->amount);
        }

        // Inserting the delete log
        $deletelog = new DeleteLog();
        $deletelog->model = $model;
        $deletelog->row_id = $row;
        $deletelog->deleted_by = Auth::user()->username;
        $deletelog->save();
        return $deletelog;
    }
}
