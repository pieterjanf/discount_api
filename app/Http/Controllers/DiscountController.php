<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Condition;
use \App\Discount;

class DiscountController extends Controller
{
    public function postIndex(Request $request)
    {
        $order = $request->all();
        if (empty($order)) {
            return response()->json(
                array(
                    'error' => 'Missing payload'
                )
            );
        }

        try {
            // assert all conditions
            $allConditions = Condition::all();
            // convert to array
            $conditions = json_decode(json_encode($allConditions), true);
            foreach ($conditions as $condition) {
                $conditionClass = '\\App\\Conditions\\' . $condition['id'];
                // if not false
                if ($conditionClass::assert($order, $condition['condition_params']) !== false) {
                    $discountClass = '\\App\\Discounts\\' . $condition['discount'];
                    $order = $discountClass::apply(
                        $order,
                        $condition['discount_params']
                    );
                }
            }
        } catch (\Throwable $t) {
            return response()->json(
                array(
                    'error' => 'Failed parsing order'
                )
            );
        }
        return response()->json(
            $order
        );
    }
}
