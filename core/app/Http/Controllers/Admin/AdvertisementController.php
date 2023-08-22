<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;

class AdvertisementController extends Controller
{

    public function index()
    {
        $advertisements = Advertisement::latest()->paginate(getPaginate());
        $pageTitle = 'All Advertisement';
        $emptyMessage = 'No advertisement found.';
        return view('admin.advertisement.index', compact('advertisements', 'pageTitle', 'emptyMessage'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'type'               => 'required|in:image,script',
            'size'               => 'required|in:728x90,300x600,300x250',
            'redirect_url'       => 'required_if:type,image',
            'script'             => 'required_if:type,script',
        ]);

        //==========validation for request image ===============

        if($request->type == 'image'){
            $this->imageValidation($request);
        }

        //========upload image if request has ================
        if ($request->hasFile('image')) {
            $value = uploadFile($request->file('image'), imagePath()['advertisement']['path']);
        } else {
            $value = $request->script;
        }

        $advertisement = new Advertisement();
        $advertisement->type = $request->type;
        $advertisement->value = $value;
        $advertisement->size = $request->size;
        $advertisement->redirect_url = $request->redirect_url;
        $advertisement->save();
        $notify[] = ['success', 'Advertisement added successfully'];
        return redirect()->route('admin.advertisement.index')->withNotify($notify);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'type'               => 'required|in:image,script',
            'size'               => 'required|in:728x90,300x600,300x250',
            'redirect_url'       => 'required_if:type,image',
            'script'             => 'required_if:type,script',
        ]);

        if($request->type == 'image' && $request->hasFile('image')){
            $this->imageValidation($request, 'nullable');
        }

        $advertisement = Advertisement::findOrFail($id);

        $value = $advertisement->value;

        if ($request->hasFile('image')) {
            $oldImage = $advertisement->type == 'image'?$advertisement->value:null;
            $value = uploadFile($request->file('image'), imagePath()['advertisement']['path'], null, $oldImage);
        }

        if ($request->type == "script") {
            $value = $request->script;
        }

        $advertisement->value = $value;
        $advertisement->redirect_url = $request->redirect_url;
        $advertisement->status = $request->status ? 1 : 0;;
        $advertisement->save();
        $notify[] = ['success', 'Advertisement updated successfully'];

        return redirect()->route('admin.advertisement.index')->withNotify($notify);
    }


    public function imageValidation($request, $isRequired = 'required')
    {
        $size = explode('x', $request->size);
        $request->validate( [
            'image'  => [$isRequired, 'image', new FileTypeValidate(['jpeg', 'jpg', 'png', 'gif']), 'dimensions:width=' . $size[0] . ',height=' . $size[1]],
        ]);
    }

}
