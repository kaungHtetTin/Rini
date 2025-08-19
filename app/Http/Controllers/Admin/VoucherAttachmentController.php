<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoucherAttachment;
use Illuminate\Support\Facades\Storage;

class VoucherAttachmentController extends Controller
{
    public function store(Request $req){
        $req->validate([
            'voucher_id'=>'required',
            'image'=>'required',
        ]);

        if($req->hasFile('image')){
            $image = $req->file('image');
            $path = $image->store('images', 'public');
            
            $attachment = new VoucherAttachment();
            $attachment->voucher_id = $req->voucher_id;
            $attachment->image_url = $path;
            $attachment->save();
            
            return back()->with('msg', 'The attachment was successfully added');
        }

        return back()->with('error', 'Job Fail! An expected error.');

    }

    public function destroy($id){
        $attachment = VoucherAttachment::find($id);
        Storage::disk('public')->delete($attachment->image_url);
        $attachment->delete();
        return back()->with('msg', 'The attachment was successfully deleted');
    }   
}
