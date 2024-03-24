<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function Pagination($query, $request)
    {
        if (isset($request->pagination)) {
            $pagination = is_numeric($request->pagination) ? $request->pagination : 10;
            return $query->paginate($pagination);
        }
        return $query->get();
    }
}
