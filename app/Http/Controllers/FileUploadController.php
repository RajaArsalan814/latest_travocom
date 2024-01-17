<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FileUpload;
use App\User;
use App\upload_sharing;
use Illuminate\Support\Facades\Session;
use Response;

class FileUploadController extends Controller {

    public function index(Request $request) {
        $fromdate = date('d-m-Y', strtotime('-30 days')); //date('01-m-Y');
        $todate = date('d-m-Y');

        if ($request->fromdate && $request->todate) {
            $fromdate = $request->fromdate;
            $todate = $request->todate;
        }

        $fileUpload = FileUpload::select('file_upload.*', 'users.name', 'users.id as userid')
                ->join('users', 'users.id', '=', 'file_upload.created_by');
        if (auth()->user()->id != 1) {
            $fileUpload = $fileUpload->where('file_upload.created_by', auth()->user()->id);
        }
        $fileUpload = $fileUpload->where('file_upload.created_at', '>=', date('Y-m-d', strtotime($fromdate)));
        $fileUpload = $fileUpload->where('file_upload.created_at', '<=', date('Y-m-d', strtotime($todate . ' +1 day')));

        $fileUpload = $fileUpload->get()->toArray();

        $users = User::select('*')->where('business_id', auth()->user()->business_id)->get();
        return view('fileupload.index')->with(compact('fileUpload', 'fromdate', 'todate', 'users'));
    }

    public function create() {
        return view('fileupload.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required|string',
            'file' => 'max:2048|required',
                ], ['file.max' => 'file may not be greater than 2048 kb']);

        $fileupload = new FileUpload;

        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $destinationPath = 'uploads/files/' . date('Y-m');
        $file->move($destinationPath, $filename);

        $fileupload->title = $request->title;
        $fileupload->description = $request->description;
        $fileupload->file_name = $filename;
        $fileupload->file_path = 'files/' . date('Y-m') . '/';
        $fileupload->created_by = auth()->user()->id;
        $fileupload->save();

        Session::flash('message', 'File has been uploaded');
        Session::flash('message_type', 'success');
        return back();
    }

    public function sharedwith(Request $request) {
        //print_r($request->all()); exit;

        $upload_id = $request->hdn_upload_id;
        $values = $request->checkValue;

        $sharing = upload_sharing::where('upload_id', $upload_id)->delete();
        if ($values) {
            foreach ($values as $val) {
                $sharing = new upload_sharing();
                $sharing->upload_id = $upload_id;
                $sharing->shared_by = auth()->user()->id;
                $sharing->shared_with = $val;
                $sharing->created_by = auth()->user()->id;
                $sharing->save();
            }
            Session::flash('message', 'File has been shared');
            Session::flash('message_type', 'success');
        } else {
            Session::flash('message', 'File has not been shared');
            Session::flash('message_type', 'warning');
        }
        return redirect('fileupload');
    }

    public function getusers(Request $request) {
        $upload_id = $request->upload_id;
        $users = User::select('users.*', 'shared_with')
                ->leftJoin('upload_sharing', function($join) use($upload_id) {
                    $join->on('upload_sharing.shared_with', 'users.id');
                    $join->where('upload_id', $upload_id);
                })
                ->where('business_id', auth()->user()->business_id)
                ->where('users.id', '!=', auth()->user()->id)
                ->get();
        // print_r($users);exit;
        return \Response::json($users);
    }

    public function sharedwithmelist(Request $request) {
        $data = User::select('file_upload.*', 'users.name')
                        ->join('upload_sharing', 'users.id', 'upload_sharing.shared_by')
                        ->join('file_upload', 'file_upload.id_file_upload', 'upload_sharing.upload_id')
                        ->where('shared_with', auth()->user()->id)->
                        where('business_id', auth()->user()->business_id)
                        ->get()->toArray();
        //$uploads =upload_sharing::where('shared_with',auth()->user()->id);
        return view('fileupload.shared')->with(compact('data'));
    }

    //user will view files where other users shared with him/her
    public function sharewithmeview(Request $request) {
        $file_id = $request->fileid;
        $data = upload_sharing::select()
                ->join('file_upload', 'file_upload.id_file_upload', '=', 'upload_sharing.upload_id')
                ->where('upload_sharing.upload_id', $file_id)
                ->where('upload_sharing.shared_with', auth()->user()->id)
                ->first();

        if (!$data) {
            Session::flash('message', 'Sorry Link expired');
            Session::flash('message_type', 'warning');
            return back();
        }

        return view('fileupload.sharewithmeview')->with(compact('data'));
    }

    public function destroy($id) {
        FileUpload::find($id)->delete();
        Session::flash('message', 'File has been deleted');
        Session::flash('message_type', 'success');
        return back();
    }

}
