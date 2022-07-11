<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\User\CreateRequest;
use App\Services\UploadService;
use App\Jobs\SendEmail;
use App\Models\District;
use App\Models\Province;
use Session;

class UserController extends Controller
{
    protected $productupl;
    public function __construct(UploadService $uploadService)
    {
        

        $this->productupl = $uploadService;
    }

    /**
     * middleware check login
     * @return void
     */



    /**
     * Show list of users
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $keyword = $request->key;
        $users = User::select(
            "users.id",
            "users.user_name",
            "users.fist_name",
            "users.last_name",
            "users.email",
            "users.birthday",
            "users.status",
            "users.avatar",
        )
            ->where(function ($q) use ($keyword) {
                $q->orwhere('users.user_name', 'like', '%' . $keyword . '%');
                $q->orWhere('users.fist_name', 'like', '%' . $keyword . '%');
                $q->orWhere('users.last_name', 'like', '%' . $keyword . '%');
                $q->orWhere('users.email', 'like', '%' . $keyword . '%');
            });
        $users = $users->paginate(PAGE_RECORDS);
        return view('admin.user.index', ['users' => $users]);
    }

    /**
     * create new user
     * @return Application|Factory|View
     */
    public function create()
    {
        $provinces = Province::select('id', 'name')
            ->get();
        return view('admin/user/create', [
            'provinces' => $provinces
        ]);
    }

    /**
     * save new user
     * @param CreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {

        $issue = new User();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $issue->avatar = $this->productupl->store($file);
        } else {
            $issue->avatar = "";
        }

        $issue->id = $request['id'];
        $issue->user_name = $request->user_name;
        $issue->email = $request->email;
        $issue->fist_name = $request->fist_name;
        $issue->last_name = $request->last_name;
        $issue->birthday = $request->birthday;
        $issue->status = STATUS_ACTIVE;
        $issue->reset_password = Hash::make($request->password_confirm);
        $issue->password = Hash::make($request->password);
        $issue->address = $request->address;
        $issue->province_id = $request->province_id;
        $issue->district_id = $request->district_id;
        $issue->commune_id = $request->commune_id;
        $issue->save();
        $email_data = array(
            'user_name' => $request->user_name,
            'email' => $request->email,

        );
        dispatch(new SendEmail($email_data));
        return redirect()->route('user')->with('success', 'Thêm user thành công');
    }

    /**
     * edit user
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $users = User::select('id', 'email', 'user_name', 'avatar', 'birthday', 'fist_name', 'last_name','address','province_id','district_id','commune_id', 'password', 'status')
            ->where('id', '=', $id)
            ->first();
        if ($users) {

            return view('admin.user.update', [
                'user' => $users,
                'provinces' => $this->getAllProvince(),
            ]);
        } else {
            return redirect()->with('error', 'Sửa user thất bại');
        };
    }

    /**
     * update user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        try {
            $user = User::find($request->id);
            if ($user) {
                $province_id = (int) $request->province;
                $district_id = (int) $request->district;
                $commune_id = (int) $request->commune;
                if (!$this->checkDistrict($province_id, $district_id)) {
                    $user->session()->flash('error', 'Please check the info on the district of the province.');
                    return back()->withInput();
                }

                // Check the commune belong to the district and province.
                if (!$this->checkCommune($district_id, $commune_id)) {
                    $user->session()->flash('error', 'Please check the info on the commune of the district.');
                    return back()->withInput();
                }
                $user->user_name = $request->user_name;
                $user->email = $request->email;
                $user->fist_name = $request->fist_name;
                $user->last_name = $request->last_name;
                $user->birthday = $request->birthday;
                $user->address = $request->address;
                $user->status = STATUS_ACTIVE;
                $user->reset_password = Hash::make($request->password_confirm);
                $user->password = Hash::make($request->password);
                $email_data = array(
                    'user_name' => $request->user_name,
                    'email' => $request->email,

                );
                dispatch(new SendEmail($email_data));

                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $user->avatar = $this->productupl->store($file);
                }

                $user->save();
            } else {
                return redirect()->with('error');
            };
            return redirect()->route('user')->with('success', 'Sửa user thành công');
        } catch (\Exception $e) {
            return redirect()->route('user')->with('error', 'Sửa user thất bại');
        }
    }
    public function delete(Request $request)
    {
        $product = User::find($request->id);
        $product->delete($request->id);
        return response()->json();
    }

    /**
     * Get province list.
     *
     * @return Province
     */
    public function getAllProvince()
    {
        return Province::get(['id', 'name']);
    }


    /** Get all district with province id.
     * @param int $province_id
     * @return false | District
     */
    public function getAllDistrict(int $province_id)
    {
        // check exist province
        $province = Province::where(['id' => $province_id])->first();

        if ($province) {
            return District::where(['province_id' => $province_id])->get(['id', 'name']);
        }

        return false;
    }


    /**
     * Get all commune with province id and district id.
     *
     * @param Request $request
     * @return Collection | false
     */
    public function getAllCommune(Request $request)
    {
        try {
            // check exist district and province
            $province = $request->province;

            $district = $request->district;

            $districts = $this->getAllDistrict($province);

            $district_item = $districts->filter(function ($item) use ($district) {
                return $item->id == $district;
            })->first();

            return $district_item->communes->map->only(['id', 'name']);
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * Check the district belong to the province.
     *
     * @param int $province_id
     * @param int $district_id
     * @return bool
     */
    public function checkDistrict(int $province_id, int $district_id)
    {
        // Get province with province id.
        $province = Province::where(["id" => $province_id])->first();

        if (in_array($district_id, $province->districts->pluck("id")->toArray())) {
            return true;
        }

        return false;
    }

    /**
     * Check the commune belong to the district and province.
     *
     * @param int $district_id
     * @param int $commune_id
     * @return bool
     */
    public function checkCommune(int $district_id, int $commune_id)
    {
        // Get district with district id.
        $district = District::where(["id" => $district_id])->first();

        if (in_array($commune_id, $district->communes->pluck("id")->toArray())) {
            return true;
        }

        return false;
    }
}
