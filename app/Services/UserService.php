<?php

namespace App\Services;

use App\Models\User;
use App\Models\Period;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class UserService extends BaseService
{

    /**
     * @var $model
     */
    protected $model, $userDetailModel;
    /**
     * @var string
     */


    public function __construct(User $user, Period $userDetail)
    {
        $this->model = $user;
        $this->userDetailModel = $userDetail;
    }


    /**
     *
     * @return JsonResponse
     */
    public function getAllData($request)
    {
        $query = $this->model->with('role')->where('role_id', '<>', 4)->select();
        if (Auth::user()->role->slug == 'moderator' or Auth::user()->role->slug == 'admin'){
            $query =  $query->where('id',  Auth::id());
        }

        return Datatables::of($query)
            ->addColumn('action', function ($row) {
                $actions = '';
                if (Auth::user()->can('update', $row)){
                    $actions .= '<a href="' . route('admin.users.edit', [$row->id]) . '" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="flaticon-edit-1"></i></a>';
                }
                $actions .= '<a href="' . route('admin.users.show', [$row->id]) . '" class="btn btn-sm btn-clean btn-icon" title="View"><i class="flaticon-eye"></i></a>';
                return $actions;
            })

            ->editColumn('role_id', function ($row){
                return isset($row->role) ? $row->role->name : '-';
            })

            ->editColumn('image', function ($row){
                $src = asset('assets/uploads/users/default.png');
                if (isset($row->image)){
                    $src = asset('assets/uploads/users/'.$row->image);
                }

                return '<img src="'.$src.'" style="width: 50px;">';
            })
            ->editColumn('status', function ($row){
                return setStatus($row->status);
            })


            ->rawColumns(['action', 'status', 'image'])
            ->make(true);
    }

    public function saveUser($request){
        //upload image
        if ($request->hasFile('image')){
            $userImage = $request->file('image');
            $userImageFileName = 'user'.time() . '.' . $userImage->getClientOriginalExtension();
            if (!file_exists('assets/uploads/users')){
                mkdir('assets/uploads/users', 0777, true);
            }
            $userImage->move('assets/uploads/users', $userImageFileName);
        }else{
            $userImageFileName = 'default.png';
        }



       return $this->model->create([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $userImageFileName,
            'role_id' => $request->role_id,
            'password' => Hash::make('12345678'),
        ]);
    }

    public function updateUser($request, $user){
        //upload advertise image
        $userImageFileName = $user->image;
        if ($request->hasFile('image')){
            $userImage = $request->file('image');
            $userImageFileName = 'user'.time() . '.' . $userImage->getClientOriginalExtension();
            if (!file_exists('assets/uploads/users')){
                mkdir('assets/uploads/users', 0777, true);
            }

            //delete old image if exist
            if (file_exists('assets/uploads/users/'.$user->image) and $user->image != 'default.png'){
                unlink('assets/uploads/users/'.$user->image);
            }
            $userImage->move('assets/uploads/users', $userImageFileName);
        }

        return $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'image' => $userImageFileName,
            'role_id' => $request->role_id ?? $user->role_id,
            'phone' => $request->phone ?? $user->phone,
            'birth_date' => $request->birth_date ?? $user->birth_date,
            'status' => $request->status ?? $user->status,

        ]);
    }


    // update password
    public function updatePassword($request){
        return $this->model->where('id', $request->user_id)
            ->update(['password' => Hash::make($request->password)]);

    }

    public function saveTodayPeriodSings($request){
        $periodInfo = $this->userDetailModel->firstOrFail($request->last_period_id);
        $periodInfo->attach($request->period_sign_ids);

    }
}
