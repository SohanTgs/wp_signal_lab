<?php

namespace Viserlab\Controllers\Admin;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;
use Viserlab\Models\Extension;

class ExtensionController extends Controller
{
    public function index()
    {
        $pageTitle = "Extensions";
        $extensions = Extension::orderBy('name', 'asc')->get();
        return $this->view('admin/extension/index', compact('pageTitle', 'extensions'));
    }

    public function update()
    {
        $request = new Request();
        $extension = Extension::find($request->id);
        if (!$extension) {
            viser_abort(404);
        }
        $validation_rule = [];
        foreach (json_decode($extension->shortcode) as $key => $val) {
            $validation_rule = array_merge($validation_rule, [$key => 'required']);
        }
        $request->validate($validation_rule);

        $shortcode = json_decode($extension->shortcode, true);
        foreach ($shortcode as $key => $value) {
            $shortcode[$key]['value'] = $request->$key;
        }

        $extension->shortcode = json_encode($shortcode);
        $extension->save();
        $notify[] = ['success', $extension->name . ' updated successfully'];
        viser_back($notify);
    }

    public function status()
    {
        $request = new Request();
        $extension = Extension::find($request->id);
        if (!$extension) {
            viser_abort(404);
        }
        $extension->status = $extension->status ? 0 : 1;
        $extension->save();
        $notify[] = ['success', 'Status changed successfully'];
        viser_back($notify);
    }
}
