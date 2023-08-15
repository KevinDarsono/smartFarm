<?php


namespace App\Helpers;

class DatatableHelper
{
    static function createAction($row, $route = '', $delete = false, $edit = false, $show = false)
    {
        $id = $row['id'];
        return view('layouts.components.helper_action', compact('id', 'route', 'delete', 'edit', 'show'))->render();
    }
}
