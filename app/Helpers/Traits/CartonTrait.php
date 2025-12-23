<?php

namespace App\Helpers\Traits;

use Illuminate\Support\Facades\Auth;

trait CartonTrait
{
    public static function carton($stock, $carton)
    {
        if ($carton <= 0) {
            return 0;
        }

        $quantity = $stock;
        $cartonAt = $carton;
        $cartonCount = floor($quantity / $cartonAt);
        $remainingPieces = $quantity % $cartonAt;

        $result = '';

        if ($cartonCount > 0) {
            $result .= $cartonCount . ' C';
            if ($cartonCount > 1) {
                $result .= 's';
            }

            if ($remainingPieces > 0) {
                $result .= ' & ';
            }
        }

        if ($remainingPieces > 0 || $cartonCount === 0) {
            $result .= $remainingPieces . ' P';
        }

        return $result;
    }

    public static function single_pics($stock, $carton)
    {
        if ($carton == 0) {
            return $stock;
        } else if ($carton == 1) {
            return $stock;
        } else {
            $cartonAt = $carton;
            $quantity = $stock;
            if ($cartonAt == 0) {
                $cartonAt = 0;
                return $stock;
            } elseif ($quantity == 0) {
                $quantity = 0;
                return $stock;
            } else {
                $result = $quantity / $cartonAt;
                $explode_result = explode('.', $result);
                $carton_pics_qty = $explode_result['0'] * $carton;
                return $stock - $carton_pics_qty;
            }
        }
    }
}
