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
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . AccountStudent::screenId());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account = new AccountStudent;
        $account->setAttribute('student_entity_id', $id);
        $account->loadDetail();
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
                $server->deleteCache($id.'.'.$extension);

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

        $account = new AccountStudent($request->input());
        $account->setAttribute('student_entity_id', $id);
        $account->setAttribute('login_name', $account->mobile_phone);

        if (empty($request->input('active'))) {
            $account->setActiveToFalse();
        }
        if (empty($request->input('login_active'))) {
            $account->setLoginActiveToFalse();
        }

        $group = $account->securityGroupForParent();
        if (isset($group[0]['security_group_entity_id'])) {
            $account->setAttribute('security_group_entity_id', $group[0]['security_group_entity_id']);
        }

        $account->update();
        flash('Student Updated!');
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
        $account = new AccountStudent;
        $account->setAttribute('student_entity_id', $id);
        $account->delete();
        flash('Student Deleted!');
        return redirect('/cabinet/student-account');
    }
}
