<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Busyness;
use App\Models\JobType;
use App\Models\Region;
use App\Models\District;
use App\Models\Schedule;
use App\Models\User;
use App\Models\UserCourse;
use App\Models\UserCV;
use App\Models\UserEducation;
use App\Models\UserExperience;
use App\Models\UserVacancy;
use App\Models\UserCompany;
use App\Models\Vacancy;
use App\Models\VacancyType;
use App\Models\Country;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use DateTime;

class InvitationController extends Controller
{
    public function index()
    {
        $title = 'Приглашения';

        $vacancies = Vacancy::where('company_id', auth()->user()->id)->pluck('name', 'id')->toArray();
        $vacancies_ids = Vacancy::where('company_id', auth()->user()->id)->pluck('id')->toArray();
        $region_ids = Vacancy::where('company_id', auth()->user()->id)->pluck('region')->toArray();
        $regions = Region::whereIn('id', $region_ids)->pluck('nameRu', 'id')->toArray();
        $regions_countries = Region::whereIn('id', $region_ids)->pluck('country')->toArray();
        $statuses = UserCompany::where("company_id", auth()->user()->id)->pluck('type')->toArray();
        $statuses_count = array_count_values($statuses);
        $user_ids = UserVacancy::whereIn('vacancy_id', $vacancies_ids)->pluck('user_id')->toArray();
        $citizen_ids = User::whereIn('id', $user_ids)->pluck('citizen')->toArray();
        $citizens = Country::whereIn('id', $citizen_ids)->pluck('nameRu', 'id')->toArray();
        $district_ids = User::whereIn('id', $user_ids)->pluck('district')->toArray();
        $districts = District::whereIn('id', $district_ids)->pluck('nameRu', 'id')->toArray();
        $total_invited = UserCompany::where('company_id', auth()->user()->id)->where('show_phone', '1')->get()->count();

        $stats = [
            'all' => '<button type="button" class="btn btn-lg btn-success" status_id="all">Всего <span class="label label-primary">' . count($statuses) . '</span></button>&nbsp;',
            'LIKED' => '<button type="button" class="btn btn-lg btn-light" status_id="LIKED">Приглашенные <span class="label label-primary">0</span></button>&nbsp;',
            'LIKED_THEN_DELETED' => '<button type="button" class="btn btn-lg btn-light" status_id="LIKED_THEN_DELETED">Удаленные <span class="label label-primary">0</span></button>&nbsp;',
            'INVITED' => '<button type="button" class="btn btn-lg btn-light" status_id="INVITED">Отобранные <span class="label label-primary">0</span></button>&nbsp;',
        ];

        foreach ($statuses as $key => $value) {
            if ($value === 'LIKED') {
                $stats[$value] = '<button type="button" class="btn btn-lg btn-light" status_id="LIKED">Приглашенные <span class="label label-primary">' . $statuses_count[$value] . '</span></button>&nbsp;';
            }
            if ($value === 'INVITED') {
                $stats[$value] = '<button type="button" class="btn btn-lg btn-light" status_id="INVITED">Отобранные <span class="label label-primary">' . $statuses_count[$value] . '</span></button>&nbsp;';
            }
            if ($value === 'LIKED_THEN_DELETED') {
                $stats[$value] = '<button type="button" class="btn btn-lg btn-light" status_id="LIKED_THEN_DELETED">Удаленные <span class="label label-primary">' . $statuses_count[$value] . '</span></button>&nbsp;';
            }
        }

        if (request()->ajax()) {

            $data = UserCompany::where('user_company.company_id', auth()->user()->id)->orderBy('id', 'desc');

            if (request()->status_id && request()->status_id != 'all') {
                $data = $data->where('user_company.type', request()->status_id);
            }

            if (request()->search) {
                $data = $data->search(request()->search);
            }

            if (request()->vacancy_id) {
                $data = $data->where("user_company.vacancy_id", request()->vacancy_id);
            }

            if (request()->region_id) {
                $vacancies = Vacancy::where('vacancies.region', request()->region_id)->where('vacancies.company_id', auth()->user()->id)->pluck('id')->toArray();
                $data = $data->whereIn("user_company.vacancy_id", $vacancies);
            }

            if (request()->citizen_id) {
                $data = $data->with(['usersList']);
                $user_citizen = request()->citizen_id;
                $data = $data->where(function ($query) use ($user_citizen) {
                    $query->whereHas('usersList', function ($q) use ($user_citizen) {
                        $q->where('citizen', $user_citizen);
                    });
                });
            }

            if (request()->district_id) {
                $data = $data->with(['usersList']);
                $user_district = request()->district_id;
                $data = $data->where(function ($query) use ($user_district) {
                    $query->whereHas('usersList', function ($q) use ($user_district) {
                        $q->where('district', $user_district);
                    });
                });
            }

            if (request()->period_id) {
                $dates = explode('-', request()->period_id);
                $dates[0] = trim($dates[0]);
                $dates[1] = trim($dates[1]);
                $data = $data->whereRaw(
                    "(created_at >= ? AND created_at <= ?)",
                    [
                        date('Y-m-d', strtotime($dates[0])) . " 00:00:00",
                        date('Y-m-d', strtotime($dates[1])) . " 23:59:59"
                    ]
                );
            }

            return datatables()->of($data)
                ->addColumn('check_box', function ($row) {
                    return '<input type="checkbox" name="checkbox-product" product_data_id="' . $row->id . '" />';

                })
                ->addColumn('acts', function ($row) {
                    $chat = Chat::where('user_id', $row->user->id)->where('vacancy_id', $row->vacancy_id)->first();
                    if ($chat) {
                        $msgs = Message::where('chat_id', $chat->id)->where('read', 0)->pluck('message')->toArray();
                        if (count($msgs) > 0) {
                            return '<a href="' . route('admin.chat' ) . '?id=' . $chat->id . '" class="btn btn-light-primary font-weight-bold mr-2 position-relative" title="Перейти в чат">
                                Перейти в чат <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">' . count($msgs) . '</span></a>';
                        } else {
                            return '
                            <a href="' . route('admin.chat' ) . '?id=' . $chat->id . '" class="btn btn-light-primary font-weight-bold mr-2" title="Перейти в чат">
                                Перейти в чат
                            </a>';
                        }
                    } else {
                        return '';
                    }
                })
                ->addColumn('date', function ($row) {
                    return date('d.m.Y H:i', strtotime($row->created_at));
                })
                ->addColumn('name', function ($row) {
                    $vacancy_ids = UserVacancy::where('user_id', $row->user->id)->where('type', 'LIKED')->pluck('vacancy_id')->toArray();
                    $vacancies = Vacancy::whereIn('id', $vacancy_ids)->pluck('name')->toArray();
                    $options = '';
                    foreach ($vacancies as $value => $label) {
                        $options .= $label . ', ';
                    }
                    return $options ? substr($options, 0, -2) : '';
                })
                ->addColumn('recommended', function ($row) {
                    if ($row->vacancy_id && $row->vacancy_date) {
                        $vacancy = Vacancy::where('id', $row->vacancy_id)->first();
                        return $vacancy->name;
                    } else {
                        $vacancies = Vacancy::where('company_id', auth()->user()->id)->pluck('name', 'id')->toArray();
                        $options = '';
                        $options .= '<option value="" disabled selected>Выберите вакансию</option>';
                        foreach ($vacancies as $value => $label) {
                            $selected = $row->id == $value ? 'selected' : '';
                            if (strlen($label) > 50) {
                                $options .= '<option value="' . $value . '" data-vacancy-id="' . $row->id . '" ' . $selected . '>' . mb_substr($label, 0, 50) . '</option>';
                            } else {
                                $options .= '<option value="' . $value . '" data-vacancy-id="' . $row->id . '" ' . $selected . '>' . $label . '</option>';
                            }
                        }
                        return '<select class="select_recommended form-control">' . $options . '</select>';
                    }

                })
                ->addColumn('citizen', function ($row) {
                    return Country::where('id', $row->user->citizen)->first()->nameRu;
                })
                ->addColumn('user_name', function ($row) {
                    return $row->user->name . ' ' . $row->user->lastname;
                })
                ->addColumn('phone', function ($row) {
                    if ($row->show_phone < 1 ) {
                        return '<a href="#" data-id = " ' . $row->id . '"data-phone="' . $row->user->phone_number . '" class="text-link mr-2 show_phone" title="Показать">Показать</a>';
                    } else {
                        return '<a href="#" class="text-link mr-2" title="Показать"> ' . $row->user->phone_number . '</a>';
                    }
                })
                ->addColumn('city', function ($row) {
                    $city = District::where('id', $row->user->district)->first();
                    return $city ? $city->nameRu : '-';
                })
                ->addColumn('birth_date', function ($row) {
                    $birthdate = new DateTime($row->user->birth_date);
                    $current_date = new DateTime('today');
                    $age = $birthdate->diff($current_date)->y;
                    return $age . ' лет';
                })
                ->addColumn('status', function ($row) {
                    if ($row->vacancy_id && $row->vacancy_date) {
                        return 'Отправлено <br />' . date('d.m.Y H:s', strtotime($row->vacancy_date));
                    } else {
                        return '<a href="#" data-user-id="' . $row->id . '" class="btn btn-primary font-weight-bold mr-2 btn-invite" title="Пригласить">
                    Пригласить
                            </a>';
                    }
                })
                ->rawColumns(['check_box', 'acts', 'status', 'phone', 'recommended'])
                ->make(true);
        }

        return view('admin.invitations.index', compact('title', 'vacancies', 'regions', 'districts', 'citizens', "user_ids", "statuses_count", "stats", 'total_invited'));
    }

    public function create()
    {
        $title = 'Приглашения';

        return view('admin.invitations.create', compact('title'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'salary_from' => ['required_without:salary_to'],
            'salary_to' => ['required_without:salary_from'],
            'currency' => ['required'],
            'period' => ['required'],
            'company_id' => ['required'],
            'description' => ['required'],
            'address' => ['required', 'min:3', 'max:255'],
            'busyness_id' => ['required'],
            'vacancy_type_id' => ['required'],
            'job_type_id' => ['required'],
            'schedule_id' => ['required'],
            'experience' => ['required'],
            'pay_period' => ['required'],
        ]);
        $vacancy = Vacancy::create($request->except('region', 'district'));
        $vacancy->region = Region::where('nameRu', $request->region)->first() ? Region::where('nameRu', $request->region)->first()->id : null;
        $vacancy->district = District::where('nameRu', $request->district)->first() ? District::where('nameRu', $request->district)->first()->id : null;

        if ($request->salary) {
            $salary = $request->salary;
        } else {
            if ($request->salary_from) {
                if ($request->salary_to) {
                    $salary = $request->salary_from . '-' . $request->salary_to;
                } else {
                    $salary = $request->salary_from;
                }
            } else {
                $salary = '';
            }
        }
        $vacancy->salary = $salary;
        $vacancy->save();

        return redirect()->route('invitations.index');
    }

    public function show(Vacancy $vacancy)
    {
        $title = 'Приглашения';
        return view('admin.invitations.show', compact('vacancy', 'title'));
    }

    public function edit(Vacancy $vacancy)
    {
        $title = 'Приглашения';


        return view('admin.invitations.edit', compact('title'));
    }

    public function update(Request $request, Vacancy $vacancy)
    {
        $this->validate($request, [
            'name' => ['required'],
            'salary_from' => ['required_without:salary_to'],
            'salary_to' => ['required_without:salary_from'],
            'currency' => ['required'],
            'period' => ['required'],
            'company_id' => ['required'],
            'description' => ['required'],
            'address' => ['required', 'min:3', 'max:255'],
            'busyness_id' => ['required'],
            'vacancy_type_id' => ['required'],
            'job_type_id' => ['required'],
            'schedule_id' => ['required'],
            'experience' => ['required'],
            'pay_period' => ['required'],
        ]);
        $vacancy->update($request->except('region', 'district'));
        $vacancy->status = 'not_published';
        $vacancy->region = Region::where('nameRu', $request->region)->first() ? Region::where('nameRu', $request->region)->first()->id : null;
        $vacancy->district = District::where('nameRu', $request->district)->first() ? District::where('nameRu', $request->district)->first()->id : null;

        if ($request->salary) {
            $salary = $request->salary;
        } else {
            if ($request->salary_from) {
                if ($request->salary_to) {
                    $salary = $request->salary_from . '-' . $request->salary_to;
                } else {
                    $salary = $request->salary_from;
                }
            } else {
                $salary = '';
            }
        }
        $vacancy->salary = $salary;
        $vacancy->save();

        return redirect()->route('invitations.index');
    }

    public function destroy(Vacancy $vacancy)
    {
        $chats = Chat::where('vacancy_id', $vacancy->id)->get();
        foreach ($chats as $chat) {
            $chat->delete();
        }
        $vacancy->delete();
        return redirect()->route('invitations.index');
    }

    public function api(Request $request)
    {
        $pagination = $request->pagination;
        $sort = $request->sort;
        $query = $request->input('query');

        if (array_key_exists('perpage', $pagination)) {
            $perpage = $pagination['perpage'];
        } else {
            $perpage = 5;
        }

        if (array_key_exists('page', $pagination)) {
            $page = $pagination['page'];
        } else {
            $page = 1;
        }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        if (auth()->user()->type == 'COMPANY') {
            $resultPaginated = Vacancy::where('company_id', auth()->user()->id);
        } else {
            $resultPaginated = Vacancy::whereNotNull('company_id');
        }

        if ($query) {
            if (array_key_exists('generalSearch', $query)) {
                $resultPaginated = $resultPaginated->search($query['generalSearch'], null, true, true);
            }
            if (array_key_exists('region', $query)) {
                if ($query['region'] > 0) {
                    $resultPaginated = $resultPaginated->where('region_id', $query['region']);
                }
            }
            if (array_key_exists('busyness', $query)) {
                if ($query['busyness'] > 0) {
                    $resultPaginated = $resultPaginated->where('busyness_id', $query['busyness']);
                }
            }
            if (array_key_exists('vacancy_type', $query)) {
                if ($query['vacancy_type'] > 0) {
                    $resultPaginated = $resultPaginated->where('vacancy_type_id', $query['vacancy_type']);
                }
            }
            if (array_key_exists('job_type', $query)) {
                if ($query['job_type'] > 0) {
                    $resultPaginated = $resultPaginated->where('job_type_id', $query['job_type']);
                }
            }
            if (array_key_exists('schedule', $query)) {
                if ($query['schedule'] > 0) {
                    $resultPaginated = $resultPaginated->where('schedule_id', $query['schedule']);
                }
            }
        }

        if ($sort && $sort['field'] != 'order') {
            $resultPaginated = $resultPaginated->orderBy($sort['field'], $sort['sort']);
        } else {
            $resultPaginated = $resultPaginated->orderBy('name', 'asc');
        }

        $resultPaginated = $resultPaginated->paginate($perpage);

        foreach ($resultPaginated as $key => $row) {
            //            $row->date = date('d/m/y H:i', strtotime($row->created_at));
            $row->order = ($page - 1) * $perpage + $key + 1;

            $row->company_name = $row->company->name;

            $row->region = Region::find($row->region_id) ? Region::find($row->region_id)->nameRu : '-';
            $row->job_type = $row->jobtype ? $row->jobtype->name_ru : '-';

            $row->actions = '
                <a href="' . route('invitations.show', $row) . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Просмотр">
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
                <a href="' . route('invitations.edit', $row) . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Редактировать">
                    <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                <path d="M7.10343995,21.9419885 L6.71653855,8.03551821 C6.70507204,7.62337518 6.86375628,7.22468355 7.15529818,6.93314165 L10.2341093,3.85433055 C10.8198957,3.26854411 11.7696432,3.26854411 12.3554296,3.85433055 L15.4614112,6.9603121 C15.7369117,7.23581259 15.8944065,7.6076995 15.9005637,7.99726737 L16.1199293,21.8765672 C16.1330212,22.7048909 15.4721452,23.3869929 14.6438216,23.4000848 C14.6359205,23.4002097 14.6280187,23.4002721 14.6201167,23.4002721 L8.60285976,23.4002721 C7.79067946,23.4002721 7.12602744,22.7538546 7.10343995,21.9419885 Z" id="Path-11" fill="#000000" fill-rule="nonzero" transform="translate(11.418039, 13.407631) rotate(-135.000000) translate(-11.418039, -13.407631) "></path>
                            </g>
                        </svg>
                    </span>
                </a>
                <a href="' . route('invitations.delete', $row) . '" class="btn btn-sm btn-clean btn-icon" title="Удалить">
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

        //        if(array_key_exists('pages', $pagination)) { $pages = $pagination['pages']; }
        //        else { $pages = $resultPaginated->lastPage(); }
        //
        //        if(array_key_exists('total', $pagination)) { $total = $pagination['total']; }
        //        else { $total = $resultPaginated->total(); }

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

    public function invite(Request $request)
    {
        $user_company = UserCompany::where('id', $request->id)->first();
        $user_company->vacancy_id = $request->vacancy_id;
        $user_company->vacancy_date = date("Y-m-d H:i:s");
        $user_company->type = 'INVITED';
        $user_company->save();
        return 'success';
    }

    public function invite_all(Request $request)
    {
        if ($request->status_type === 'INVITED') {
            for ($i = 0; $i < count($request->options); $i++) {
                if ($request->vacancies[$i]) {
                    $user_company = UserCompany::where('id', $request->options[$i])->first();
                    $user_company->vacancy_id = $request->vacancies[$i];
                    $user_company->vacancy_date = date("Y-m-d H:i:s");
                    $user_company->type = $request->status_type;
                    $user_company->save();
                }
            }
        }
        if ($request->status_type === 'DELETED') {
            for ($i = 0; $i < count($request->options); $i++) {
                $user_company = UserCompany::where('id', $request->options[$i])->first();
                $user_company->delete();
            }
        }

        return $request;
    }

    public function show_phone(Request $request)
    {
        $user_company = UserCompany::where('id', $request->id)->first();
        $user_company->show_phone = 1;
        $user_company->save();
        return 'success';
    }

}
