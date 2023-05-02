<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobType;
use App\Models\Region;
use App\Models\User;
use App\Models\UserCV;
use App\Models\Country;
use App\Models\VacancyType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if($request->type == 'USER'){
            $title = 'Соискатели';
        } elseif ($request->type == 'COMPANY'){
            $title = 'Работодатели';
        } elseif($request->type == 'ADMIN') {
            $title = 'Администраторы';
        } else {
            abort(403);
        }

        $genders = [
            0 => 'Мужской',
            1 => 'Женский',
        ];

        $ages = [
            1 => '18-24',
            2 => '25-29',
            3 => '30-39',
            4 => '40-49',
            5 => '50 и старше',
        ];

        $regions = Region::pluck('nameRu', 'id')->toArray();
        $job_types = JobType::pluck('name_ru', 'id')->toArray();

        if(request()->ajax()){
            $data = User::query();

            if(request()->type == 'USER'){
                $data = $data->where('type', 'USER');
            } else if(request()->type == 'COMPANY') {
                $data = $data->where('type', 'COMPANY');
            } else {
                $data = $data->where('type', 'ADMIN');
            }

            if (request()->region) {
                $data = $data->where('region', request()->region);
            }

            if (request()->gender) {
                $data = $data->where('gender', request()->gender);
            }

            if (request()->age) {
                if(request()->age == 1){
                    $data = $data->where('birth_date', '<=', Carbon::now()->subYears(18)->format('Y-m-d'))->where('birth_date', '>', Carbon::now()->subYears(25)->format('Y-m-d'));
                }
                if(request()->age == 2){
                    $data = $data->where('birth_date', '<=', Carbon::now()->subYears(25)->format('Y-m-d'))->where('birth_date', '>', Carbon::now()->subYears(30)->format('Y-m-d'));
                }
                if(request()->age == 3){
                    $data = $data->where('birth_date', '<=', Carbon::now()->subYears(30)->format('Y-m-d'))->where('birth_date', '>', Carbon::now()->subYears(40)->format('Y-m-d'));
                }
                if(request()->age == 4){
                    $data = $data->where('birth_date', '<=', Carbon::now()->subYears(40)->format('Y-m-d'))->where('birth_date', '>', Carbon::now()->subYears(50)->format('Y-m-d'));
                }
                if(request()->age == 5){
                    $data = $data->where('birth_date', '<=', Carbon::now()->subYears(50)->format('Y-m-d'));
                }
            }

            if (request()->job_type) {
                $data = $data->where('job_type', request()->job_type);
            }

//            $data = $data->get();

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('acts', function ($row) {
                    return '
                    <a href="'.route('users.show', $row).'" class="btn btn-sm btn-clean btn-icon mr-2" title="Просмотр">
                        <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M15.9956071,6 L9,6 C7.34314575,6 6,7.34314575 6,9 L6,15.9956071 C4.70185442,15.9316381 4,15.1706419 4,13.8181818 L4,6.18181818 C4,4.76751186 4.76751186,4 6.18181818,4 L13.8181818,4 C15.1706419,4 15.9316381,4.70185442 15.9956071,6 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                    <path d="M10.1818182,8 L17.8181818,8 C19.2324881,8 20,8.76751186 20,10.1818182 L20,17.8181818 C20,19.2324881 19.2324881,20 17.8181818,20 L10.1818182,20 C8.76751186,20 8,19.2324881 8,17.8181818 L8,10.1818182 C8,8.76751186 8.76751186,8 10.1818182,8 Z" fill="#000000"/>
                                </g>
                            </svg>
                        </span>
                    </a>
                    <a href="'.route('users.edit', $row).'" class="btn btn-sm btn-clean btn-icon mr-2" title="Редактировать">
                        <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                    <path d="M7.10343995,21.9419885 L6.71653855,8.03551821 C6.70507204,7.62337518 6.86375628,7.22468355 7.15529818,6.93314165 L10.2341093,3.85433055 C10.8198957,3.26854411 11.7696432,3.26854411 12.3554296,3.85433055 L15.4614112,6.9603121 C15.7369117,7.23581259 15.8944065,7.6076995 15.9005637,7.99726737 L16.1199293,21.8765672 C16.1330212,22.7048909 15.4721452,23.3869929 14.6438216,23.4000848 C14.6359205,23.4002097 14.6280187,23.4002721 14.6201167,23.4002721 L8.60285976,23.4002721 C7.79067946,23.4002721 7.12602744,22.7538546 7.10343995,21.9419885 Z" id="Path-11" fill="#000000" fill-rule="nonzero" transform="translate(11.418039, 13.407631) rotate(-135.000000) translate(-11.418039, -13.407631) "></path>
                                </g>
                            </svg>
                        </span>
                    </a>
                    <a href="'.route('users.delete', $row).'" class="btn btn-sm btn-clean btn-icon" title="Удалить">
                        <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>
                                    <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
                                </g>
                            </svg>
                        </span>
                    </a>';
                })
                ->addColumn('region', function ($row) { return $row->region && Region::find($row->region) ? Region::find($row->region)->nameRu : '-'; })
                ->rawColumns(['acts'])
                ->make(true);
        }

        return view('admin.users.index', compact('title', 'genders', 'regions', 'ages', 'job_types'));
    }

    public function create()
    {
        $user = new User();
        $title = 'Соискатели';
        $types = [
            'USER' => 'Соискатель',
            'COMPANY' => 'Работодатель',
            'ADMIN' => 'Администратор'
        ];
		$sexes = [
			'male' => 'Мужской',
			'female' => 'Женский'
		];
		$citizenship = Country::pluck('nameRu', 'id')->toArray();
        $vacancy_types = VacancyType::pluck('name_ru', 'id')->toArray();
        return view('admin.users.create', compact('user', 'title', 'types', 'sexes', 'citizenship', 'vacancy_types'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  => ['required', 'min:3', 'max:255'],
            'lastname' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'gender' => ['required'],    
            'citizen' => ['required'],
            'password' => ['required', 'min:5'],
            'phone_number' => ['required'],
            'address' => ['required', 'min:3', 'max:255'],
            'region' => ['required'],
            'birth_date' => ['required'],
        ]);
        $request->login = $request->email;
        $user = User::create($request->except( 'password', 'avatar', 'avatar_remove'));
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        if($request->file('image')){

            $file = $request->file('image');

            $dir  = 'assets/media/users/';
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            $name = Str::slug($user->name, '-').'.'.$file->getClientOriginalExtension();

            Image::make($file)->fit(400, 400)->save($dir.$name, 75);

            $user->avatar = $dir.$name;
        }

        $user->save();

        if($user && $user->type == 'USER') {
            UserCV::create([
                'user_id' => $user->id
            ]);
        }

        return redirect()->route('users.show', $user);
    }

    public function show(User $user)
    {
        $title = 'Соискатели';
        $types = [
            'USER' => 'Соискатель',
            'COMPANY' => 'Работодатель',
            'ADMIN' => 'Администратор'
        ];
		$sexes = [
			'male' => 'Мужской',
			'female' => 'Женский'
		];
		$citizenship = $citizenship = Country::pluck('nameRu', 'id')->toArray();
        $vacancy_types = VacancyType::pluck('name_ru', 'id')->toArray();
        return view('admin.users.show', compact('user', 'title', 'types', 'sexes', 'citizenship', 'vacancy_types'));
    }

    public function edit(User $user)
    {
        // dd($user);
        $title = 'Соискатели';
        $types = [
            'USER' => 'Соискатель',
            'COMPANY' => 'Работодатель',
            'ADMIN' => 'Администратор'
        ];
        $sexes = [
			'male' => 'Мужской',
			'female' => 'Женский'
		];
		$citizenship = $citizenship = Country::pluck('nameRu', 'id')->toArray();
        $vacancy_types = VacancyType::pluck('name_ru', 'id')->toArray();
        return view('admin.users.edit', compact('user', 'title', 'types', 'sexes', 'citizenship', 'vacancy_types'));
    }

    public function update(Request $request, User $user)
    {
        // dd($request->all());
        if ($user->login!=$request->login){
            $this->validate($request, [
                'name'  => ['required', 'min:3', 'max:255'],
                'lastname' => ['required', 'min:3', 'max:255'],
                'email' => ['required', 'email'],
                'gender' => ['required'],    
                'citizen' => ['required'],
                'phone_number' => ['required'],
                'address' => ['required', 'min:3', 'max:255'],
                'region' => ['required'],
                'birth_date' => ['required'],
            ]);
        } else {
            $this->validate($request, [
                'name'  => ['required', 'min:3', 'max:255'],
                'lastname' => ['required', 'min:3', 'max:255'],
                'email' => ['required', 'email'],
                'gender' => ['required'],    
                'citizen' => ['required'],
                // 'password' => ['required', 'min:5'],
                'phone_number' => ['required'],
                'address' => ['required', 'min:3', 'max:255'],
                'region' => ['required'],
                'birth_date' => ['required'],
                'vacancy_type' => ['nullable'],
            ]);
        }
        $user->update($request->except( 'password', 'image', 'image_remove'));

        if($request->password){
            $user->password = Hash::make($request->password);
        }

        if($request->file('image')){

            if($user->avatar) @unlink($user->avatar);
            $file = $request->file('image');

            $dir  = 'assets/media/users/';
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            $name = Str::slug($user->name, '-').'.'.$file->getClientOriginalExtension();

            Image::make($file)->fit(400, 400)->save($dir.$name, 75);

            $user->avatar = $dir.$name;
        }

        $user->save();

        if(auth()->user()->type == 'COMPANY'){
            return redirect()->route('admin.profile');
        }
        return redirect()->route('users.show', $user);
    }

    public function destroy(User $user)
    {
        $type = $user->type;
        if($user->avatar) @unlink($user->avatar);
        $user->delete();
        return redirect()->route('users.index', ['type' => $type]);
    }

    public function api(Request $request)
    {
        $pagination = $request->pagination;
        $sort = $request->sort;
        $query = $request->input('query');

        if(array_key_exists('perpage', $pagination)) { $perpage = $pagination['perpage']; }
        else { $perpage = 5; }

        if(array_key_exists('page', $pagination)) { $page = $pagination['page']; }
        else { $page = 1; }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $type = $request->type;

        if($type == 'USER'){
            $resultPaginated = User::where('type', 'USER');
        } else if($type == 'COMPANY') {
            $resultPaginated = User::where('type', 'COMPANY');
        } else {
            $resultPaginated = User::where('type', 'ADMIN');
        }

        if($query){
            if(array_key_exists('generalSearch', $query)){
                $resultPaginated = $resultPaginated->search($query['generalSearch'], null, true, true);
            }
            if(array_key_exists('region', $query)){
                if($query['region'] > 0){
                    $resultPaginated = $resultPaginated->where('region', $query['region']);
                }
            }
            if(array_key_exists('job_type', $query)){
                if($query['job_type'] > 0){
                    $resultPaginated = $resultPaginated->where('job_type', $query['job_type']);
                }
            }
            if(array_key_exists('gender', $query)){
                if($query['gender'] != 99){
                    $resultPaginated = $resultPaginated->where('gender', $query['gender']);
                }
            }
            if(array_key_exists('age', $query)){
                if($query['age'] != 99){
                    if($query['age'] == 1){
                        $resultPaginated = $resultPaginated->where('birth_date', '<=', Carbon::now()->subYears(18)->format('Y-m-d'))->where('birth_date', '>', Carbon::now()->subYears(25)->format('Y-m-d'));
                    }
                    if($query['age'] == 2){
                        $resultPaginated = $resultPaginated->where('birth_date', '<=', Carbon::now()->subYears(25)->format('Y-m-d'))->where('birth_date', '>', Carbon::now()->subYears(30)->format('Y-m-d'));
                    }
                    if($query['age'] == 3){
                        $resultPaginated = $resultPaginated->where('birth_date', '<=', Carbon::now()->subYears(30)->format('Y-m-d'))->where('birth_date', '>', Carbon::now()->subYears(40)->format('Y-m-d'));
                    }
                    if($query['age'] == 4){
                        $resultPaginated = $resultPaginated->where('birth_date', '<=', Carbon::now()->subYears(40)->format('Y-m-d'))->where('birth_date', '>', Carbon::now()->subYears(50)->format('Y-m-d'));
                    }
                    if($query['age'] == 5){
                        $resultPaginated = $resultPaginated->where('birth_date', '<=', Carbon::now()->subYears(50)->format('Y-m-d'));
                    }
                }
            }
        }

        if($sort && $sort['field'] != 'order'){
            $resultPaginated = $resultPaginated->orderBy($sort['field'], $sort['sort']);
        } else {
            $resultPaginated = $resultPaginated->orderBy('name', 'asc')->orderBy('lastname', 'asc');
        }

        $resultPaginated = $resultPaginated->paginate($perpage);

        foreach ($resultPaginated as $key => $row) {
            $row->date = date('d/m/y H:i', strtotime($row->created_at));
            $row->order = ($page - 1) * $perpage + $key + 1;

            $row->region = Region::find($row->region) ? Region::find($row->region)->nameRu : '-';

            $row->actions = '
                <a href="'.route('users.show', $row).'" class="btn btn-sm btn-clean btn-icon mr-2" title="Просмотр">
                    <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path d="M15.9956071,6 L9,6 C7.34314575,6 6,7.34314575 6,9 L6,15.9956071 C4.70185442,15.9316381 4,15.1706419 4,13.8181818 L4,6.18181818 C4,4.76751186 4.76751186,4 6.18181818,4 L13.8181818,4 C15.1706419,4 15.9316381,4.70185442 15.9956071,6 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                <path d="M10.1818182,8 L17.8181818,8 C19.2324881,8 20,8.76751186 20,10.1818182 L20,17.8181818 C20,19.2324881 19.2324881,20 17.8181818,20 L10.1818182,20 C8.76751186,20 8,19.2324881 8,17.8181818 L8,10.1818182 C8,8.76751186 8.76751186,8 10.1818182,8 Z" fill="#000000"/>
                            </g>
                        </svg>
                    </span>
                </a>
                <a href="'.route('users.edit', $row).'" class="btn btn-sm btn-clean btn-icon mr-2" title="Редактировать">
                    <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                <path d="M7.10343995,21.9419885 L6.71653855,8.03551821 C6.70507204,7.62337518 6.86375628,7.22468355 7.15529818,6.93314165 L10.2341093,3.85433055 C10.8198957,3.26854411 11.7696432,3.26854411 12.3554296,3.85433055 L15.4614112,6.9603121 C15.7369117,7.23581259 15.8944065,7.6076995 15.9005637,7.99726737 L16.1199293,21.8765672 C16.1330212,22.7048909 15.4721452,23.3869929 14.6438216,23.4000848 C14.6359205,23.4002097 14.6280187,23.4002721 14.6201167,23.4002721 L8.60285976,23.4002721 C7.79067946,23.4002721 7.12602744,22.7538546 7.10343995,21.9419885 Z" id="Path-11" fill="#000000" fill-rule="nonzero" transform="translate(11.418039, 13.407631) rotate(-135.000000) translate(-11.418039, -13.407631) "></path>
                            </g>
                        </svg>
                    </span>
                </a>
                <a href="'.route('users.delete', $row).'" class="btn btn-sm btn-clean btn-icon" title="Удалить">
                    <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>
                                <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
                            </g>
                        </svg>
                    </span>
                </a>
            ';
        }

        if(array_key_exists('pages', $pagination)) { $pages = $pagination['pages']; }
        else { $pages = $resultPaginated->lastPage(); }

        if(array_key_exists('total', $pagination)) { $total = $pagination['total']; }
        else { $total = $resultPaginated->total(); }

        $pages = $resultPaginated->lastPage();
        $total = $resultPaginated->total();

        $meta = array(
            'page' => $page,
            'pages' => $pages,
            'perpage' => $perpage,
            'total' => $total
        );

        $result = array('meta' => $meta, 'data' => $resultPaginated->all());
        return json_encode($result);
    }
}
