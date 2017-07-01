<?php

namespace Encore\Admin\Controllers;

use \Illuminate\Http;

trait ModelForm
{
    public function show(Request $request)
    {
        return $this->edit($this->getRouteId($request));
    }

    public function update(Request $request)
    {
        return $this->form()->update($this->getRouteId($request));
    }

    public function destroy(Request $request)
    {
        if ($this->form()->destroy($this->getRouteId($request))) {
            return response()->json([
                'status'  => true,
                'message' => trans('admin::lang.delete_succeeded'),
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => trans('admin::lang.delete_failed'),
            ]);
        }
    }

    public function store()
    {
        return $this->form()->store();
    }
    
    protected function getRouteId(Request $request)
    {
        $t = $request->route()->parameters();
        return end($t);
    }
}
