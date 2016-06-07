<?php

namespace App\Http\Modules\Organization\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Organization\Models\AccountStudent;
use App\Http\Modules\Organization\Requests\AccountStudentFormRequest;
use League\Glide\ServerFactory;
use League\Glide\Responses\LaravelResponseFactory;

class AccountStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account = new AccountStudent;
        return view('modules.organization.AccountStudent.list', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account = AccountStudent::findOrFail($id);
        return view('modules.organization.AccountStudent.form', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AccountStudentFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccountStudentFormRequest $request, $id)
    {
        if ($request->hasFile('attachment')) {

            // clear cache for older images
            $server = ServerFactory::create([
                'source'   => storage_path('uploads/student-images'),
                'cache'    => storage_path('uploads/student-images-cache'),
                'response' => new LaravelResponseFactory()
            ]);

            // get old image extension
            $extensionPath = storage_path('uploads/student-images/'. domain() . "/{$id}");

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
            $savedFile = $file->move(storage_path('uploads/student-images/'.domain()), $newName);

            // save the file extension info
            file_put_contents($extensionPath, $file->clientExtension());

        }

        $account = new AccountStudent($request->input());
        $account->setAttribute('student_entity_id', $id);
        if (empty($request->input('active'))) {
            $account->setActiveToFalse();
        }

        $account->update();
        return redirect('/cabinet/student-account');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = AccountStudent::findOrFail($id);
        $account->delete();
        return redirect('/cabinet/student-account');
    }
}
