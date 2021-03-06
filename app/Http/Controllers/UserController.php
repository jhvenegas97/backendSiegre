<?php

namespace App\Http\Controllers;

use App\Models\Identification;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;

class UserController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(DB::select('select u.id,name,email,state,i.documento from users u inner join identifications i on u.identification_id = i.id where u.id !="' . Auth::user()->id . '"'))
                ->addColumn('action', 'admin.userAction')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.adminUsers');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|max:20',
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'identification_id' => 'required',
            'state' => 'required',
            'program_id' => 'required',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        try {
            $userId = $request->id;
            if ($request->has('file')) {
                $imagePath = $request->file('file');
                $imageName = $imagePath->getClientOriginalName();
                $name = time().'.'.request()->file->getClientOriginalExtension();
                $path = $request->file->move(public_path('uploads'), $imageName);

                $user   =   User::updateOrCreate(
                    [
                        'id' => $userId
                    ],
                    [
                        'name' => $request->name,
                        'email' => $request->email,
                        'description' => $request->description,
                        'phone' => $request->phone,
                        'showCurriculum' => $request->has('showCurriculum') ? $request->input('showCurriculum') == 0 ? 1 : 0 : 0,
                        'identification_id' => Identification::where('documento','=',$request->identification_id)->select('id')->first()->id,
                        'state' => $request->state,
                        'program_id' => $request->program_id,
                        'direction' => $request->direction,
                        'fileName'=> $imageName,
                        'path'=>$path,
                    ]
                );
            }
            $user   =   User::updateOrCreate(
                [
                    'id' => $userId
                ],
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'description' => $request->description,
                    'phone' => $request->phone,
                    'showCurriculum' => $request->has('showCurriculum') ? $request->input('showCurriculum') == 0 ? 1 : 0 : 0,
                    'identification_id' => Identification::where('documento','=',$request->identification_id)->select('id')->first()->id,
                    'state' => $request->state,
                    'program_id' => $request->program_id,
                    'direction' => $request->direction,
                ]
            );
            
            return Response()->json($user);
            
        } catch (Exception $e) {
            return Response()->json($e,500);
        }
    }

    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $user  = User::where($where)->first();

        return view('admin.adminUsersEdit')->with('user', $user,)->with('programs', DB::select('select * from programs'))->with('academicLevels', DB::select('select * from academic_levels'))->with('workTypes', DB::select('select * from work_types'));
    }

    public function destroy(Request $request)
    {
        $user = User::where('id', $request->id)->delete();
        //Delete on cascade, because the publications and all data related is going to be deleted
        return Response()->json($user);
    }
    
    public function exportExcel()
    {
    	return Excel::download(new UsersExport, 'user-list.xlsx');
    }
}
