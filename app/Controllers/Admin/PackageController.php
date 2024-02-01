<?php

namespace Viserlab\Controllers\Admin;

use Viserlab\Controllers\Controller;
use Viserlab\BackOffice\Request;
use Viserlab\Models\Package;

class PackageController extends Controller{

    public function all(){
        $pageTitle = 'Manage Package';
        $packages = Package::paginate(viser_paginate());
        return $this->view('admin/package/all', compact('pageTitle' , 'packages'));
    }

    public function add(){ 

        $this->addOrUpdate();

        $notify[] = ['success', 'Package added successfully'];
        viser_back($notify);
    }

    public function update(){
     
        $this->addOrUpdate();

        $notify[] = ['success', 'Package updated successfully'];
        viser_back($notify);
    }

    private function addOrUpdate(){
      
        $request = new Request();
        $package = new Package();

        $validation = [
            'name'=> 'required|max:250|unique:viser_packages,name,'.$request->id,
            'price'=> 'required|numeric|gt:0',
            'validity'=> 'required|integer|gt:0',
            'features' => 'required',
        ];
  
        if($request->id){
            $validation['id'] = 'required|integer';
        }
     
        $request->validate($validation);
   
        if($request->id){
            $package = Package::findOrFail($request->id);
        }
        
        $package->name = $request->name;
        $package->price = $request->price;
        $package->validity = $request->validity;
        $package->features = json_encode($request->features); 
        $package->save();
    }

    public function status(){ 
        $request = new Request();
        
        $package = Package::findOrFail($request->id);
        $package->status = $package->status ? 0 : 1;
        $package->save();

        $notify[] = ['success', 'Status changed successfully'];
        viser_back($notify);
    }

}
