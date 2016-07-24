<?php

namespace App\Http\Modules\System\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\System\Models\OwnerOrganization;
use App\Http\Modules\System\Requests\OwnerOrganizationFormRequest;
use Illuminate\Http\Request;
use League\Glide\ServerFactory;
use League\Glide\Responses\LaravelResponseFactory;

class OwnerOrganizationController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . OwnerOrganization::screenId());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $organization = OwnerOrganization::findOrFail(0);
        return view('modules.system.OwnerOrganization.form', compact('organization'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(OwnerOrganizationFormRequest $request)
    {
        if ($request->hasFile('attachment')) {

            // clear cache for older images
            $server = ServerFactory::create([
                'source'   => storage_path('uploads/'.domain().'/student-images'),
                'cache'    => storage_path('uploads/'.domain().'/student-images-cache'),
                'response' => new LaravelResponseFactory()
            ]);

            // get old image extension
            $extensionPath = storage_path('uploads/'.domain()."/student-images/{$id}");

            if (file_exists($extensionPath)) {
                $extension = file_get_contents($extensionPath);
                $extension = trim($extension);

                // clear previous image cache
                $server->deleteCache(domain().'/'.$id.'.'.$extension);

                // clear previous image extension info
                unlink($extensionPath);
            }

            // store the uploaded file
            $file = $request->file('attachment');
            $newName = $id.'.'.$file->clientExtension();
            $savedFile = $file->move(storage_path('uploads/'.domain().'/student-images'), $newName);

            // save the file extension info
            file_put_contents($extensionPath, $file->clientExtension());

        }


        $input = $request->input();
        $input['city_area'] = $request->input('city_area_new');

        $organization = OwnerOrganization::findOrFail(0);
        $organization->fill($input);

        $organization->update();
        flash('Organization Updated!');
        return redirect_back();
    }
}
