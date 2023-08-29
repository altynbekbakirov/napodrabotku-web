<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Busyness;
use App\Models\JobType;
use App\Models\Region;
use App\Models\Schedule;
use App\Models\User;
use App\Models\UserCourse;
use App\Models\UserCV;
use App\Models\UserEducation;
use App\Models\UserExperience;
use App\Models\UserVacancy;
use App\Models\Vacancy;
use App\Models\VacancyType;
use App\Models\Country;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use DateTime;

class UserCvController extends Controller
{
    public function index()
    {

        $vacancies = Vacancy::where('company_id', auth()->user()->id)->pluck('name', 'id')->toArray();
        $region_ids = Vacancy::where('company_id', auth()->user()->id)->pluck('region')->toArray();
        $regions = Region::whereIn('id', $region_ids)->pluck('nameRu', 'id')->toArray();
        $regions_countries = Region::whereIn('id', $region_ids)->pluck('country')->toArray();
        $countries = Country::whereIn('id', $regions_countries)->pluck('nameRu', 'id')->toArray();
        $statuses = UserVacancy::whereIn('vacancy_id', array_keys($vacancies))->whereIn("type", ['SUBMITTED'])->pluck('status')->toArray();
        $statuses_count = array_count_values($statuses);
        $user_ids = UserVacancy::whereIn('vacancy_id', array_keys($vacancies))->pluck('user_id')->toArray();
        $sexes = User::whereIn('id', $user_ids)->pluck('gender')->toArray();

        foreach ($sexes as $key => $value) {
            if ($value === 'male') {
                $sexes[$value] = 'Мужской';
                unset($sexes[$key]);
            }
            if ($value === 'female') {
                $sexes[$value] = 'Женский';
                unset($sexes[$key]);
            }
        }

        $stats = [
            'all' => '<button type="button" class="btn btn-lg btn-success" status_id="all">Всего <span class="label label-primary">' . count($statuses) . '</span></button>&nbsp;',
            'not_processed' => '<button type="button" class="btn btn-lg btn-light" status_id="not_processed">He обработан <span class="label label-primary">0</span></button>&nbsp;',
            'processing' => '<button type="button" class="btn btn-lg btn-light" status_id="processing">B обработке <span class="label label-primary">0</span></button>&nbsp;',
            'selected' => '<button type="button" class="btn btn-lg btn-light" status_id="selected">Отобран <span class="label label-primary">0</span></button>&nbsp;',
            'interview' => '<button type="button" class="btn btn-lg btn-light" status_id="interview">Собеседование <span class="label label-primary">0</span></button>&nbsp;',
            'hired' => '<button type="button" class="btn btn-lg btn-light" status_id="hired">Принят на работу <span class="label label-primary">0</span></button>&nbsp;',
            'rejected' => '<button type="button" class="btn btn-lg btn-light" status_id="rejected">Отклонен <span class="label label-primary">0</span></button>&nbsp;',
        ];

        foreach ($statuses as $key => $value) {
            if ($value === 'not_processed') {
                $stats[$value] = '<button type="button" class="btn btn-lg btn-light" status_id="not_processed">He обработан <span class="label label-primary">' . $statuses_count[$value] . '</span></button>&nbsp;';
            }
            if ($value === 'processing') {
                $stats[$value] = '<button type="button" class="btn btn-lg btn-light" status_id="processing">B обработке <span class="label label-primary">' . $statuses_count[$value] . '</span></button>&nbsp;';
            }
            if ($value === 'selected') {
                $stats[$value] = '<button type="button" class="btn btn-lg btn-light" status_id="selected">Отобран <span class="label label-primary">' . $statuses_count[$value] . '</span></button>&nbsp;';
            }
            if ($value === 'interview') {
                $stats[$value] = '<button type="button" class="btn btn-lg btn-light" status_id="interview">Собеседование <span class="label label-primary">' . $statuses_count[$value] . '</span></button>&nbsp;';
            }
            if ($value === 'hired') {
                $stats[$value] = '<button type="button" class="btn btn-lg btn-light" status_id="hired">Принят на работу <span class="label label-primary">' . $statuses_count[$value] . '</span></button>&nbsp;';
            }
            if ($value === 'rejected') {
                $stats[$value] = '<button type="button" class="btn btn-lg btn-light" status_id="rejected">Отклонен <span class="label label-primary">' . $statuses_count[$value] . '</span></button>&nbsp;';
            }
        }

        $title = 'Отклики от соискателей';

        if (request()->ajax()) {

            if (request()->country_id && request()->region_id) {
                $ids = Region::where('country', request()->country_id)->pluck('id')->toArray();
                $company_vacancies = Vacancy::whereIn('region', $ids)->where('region', request()->region_id)->where('company_id', auth()->user()->id)->pluck('id')->toArray();
            } else if (request()->country_id) {
                $ids = Region::where('country', request()->country_id)->pluck('id')->toArray();
                $company_vacancies = Vacancy::whereIn('region', $ids)->where('company_id', auth()->user()->id)->pluck('id')->toArray();
            } else if (request()->region_id) {
                $company_vacancies = Vacancy::where('region', request()->region_id)->where('company_id', auth()->user()->id)->pluck('id')->toArray();
            } else {
                $company_vacancies = Vacancy::where('company_id', auth()->user()->id)->pluck('id')->toArray();
            }

            if (request()->vacancy_id && request()->status_id && request()->status_id != 'all') {
                $data = UserVacancy::where('vacancy_id', request()->vacancy_id)->where('status', request()->status_id);
            } else if (request()->vacancy_id) {
                $data = UserVacancy::where('vacancy_id', request()->vacancy_id);
            } else if (request()->status_id && request()->status_id != 'all') {
                $data = UserVacancy::where('status', request()->status_id);
            } else {
                $data = UserVacancy::query();
            }

            $data = $data->whereIn("vacancy_id", $company_vacancies)->whereIn("user_vacancy.type", ['SUBMITTED'])->orderBy('user_vacancy.id', 'desc');

            if (request()->search) {
                $data = $data->search(request()->search);
            }

            if (request()->sex_id) {
                $data = $data->with(['usersList']);
                $user_sex = request()->sex_id;
                $data = $data->where(function ($query) use ($user_sex) {
                    $query->whereHas('usersList', function ($q) use ($user_sex) {
                        $q->where('gender', $user_sex);
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
                ->addIndexColumn()
                ->addColumn('acts', function ($row) {
                    $chat = Chat::where('user_id', $row->user->id)->where('vacancy_id', $row->vacancy->id)->first();
                    if ($chat) {
                        $msgs = Message::where('chat_id', $chat->id)->where('user_id', '<>', auth()->user()->id)->where('read', 0)->pluck('message')->toArray();
                        if (count($msgs) > 0) {
                            return '<a href="' . route('admin.chat', ) . '?id=' . $chat->id . '" class="btn btn-light-primary font-weight-bold mr-2 position-relative" title="Перейти в чат">
                                Перейти в чат <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">' . count($msgs) . '</span></a>';
                        } else {
                            return '
                            <a href="' . route('admin.chat', ) . '?id=' . $chat->id . '" class="btn btn-light-primary font-weight-bold mr-2" title="Перейти в чат">
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
                    if (strlen($row->vacancy->name) > 50) {
                        $row->vacancy->name = mb_substr($row->vacancy->name, 0, 50);
                    }

                    $actions = '<a href="' . route('vacancies.show', $row->vacancy->id) . '" class="text-link mr-2" title="Редактировать">' . $row->vacancy->name . '</a>';
                    return $actions;
                })
                ->addColumn('country', function ($row) {
                    $region = Region::where('id', $row->vacancy->region)->first()->country ?? null;
                    return $region ? Country::where('id', $region)->first()->nameRu : '';
                })
                ->addColumn('region', function ($row) {
                    return Region::where('id', $row->vacancy->region)->first()->nameRu ?? '';
                })
                ->addColumn('citizen', function ($row) {
                    return Country::where('id', $row->user->citizen)->first()->nameRu ?? '';
                })
                ->addColumn('user_name', function ($row) {
                    return $row->user->name . ' ' . $row->user->lastname . '<br /> <a href="https://wa.me/' . preg_replace("/[^0-9\-]/", "", $row->user->phone_number) . '" class="text-link mr-2" title="Редактировать">' . $row->user->phone_number . '</a>';
                })
                ->addColumn('birth_date', function ($row) {
                    $birthdate = new DateTime($row->user->birth_date);
                    $current_date = new DateTime('today');
                    $age = $birthdate->diff($current_date)->y;
                    return $age . ' лет';
                })
                ->addColumn('status', function ($row) {
                    $sts = [
                        'not_processed' => 'He обработан',
                        'processing' => 'B обработке',
                        'selected' => 'Отобран',
                        'interview' => 'Собеседование',
                        'hired' => 'Принят на работу',
                        'rejected' => 'Отклонен'
                    ];

                    $options = '';
                    foreach ($sts as $value => $label) {
                        $selected = $row->status == $value ? 'selected' : '';
                        if ($row->status == $value) {
                            $selected_value = $row->status;
                        }
                        $options .= '<option value="' . $value . '" data-vacancy-id="' . $row->id . '" ' . $selected . '>' . $label . '</option>';
                    }
                    if ($selected_value == 'not_processed') {
                        return '<select class="form-control selectpicker select_status"  data-container="body" data-style="btn-danger">' . $options . '</select>';
                    } else {
                        return '<select class="form-control selectpicker select_status"  data-container="body" >' . $options . '</select>';
                    }
                })
                ->rawColumns(['acts', 'status', 'name', 'user_name'])
                ->make(true);
        }
        return view('admin.user_cv.index', compact('title', 'vacancies', 'regions', 'sexes', 'statuses', "user_ids", "countries", "statuses_count", "stats"));
    }

    public function create()
    {
        $title = 'Добавить отклик';
        $vacancies = Vacancy::where('company_id', auth()->user()->id)->pluck('name', 'id')->toArray();
        $users = User::where('type', '=', 'USER')->pluck('name', 'id')->toArray();
        $citizenship = Country::pluck('nameRu', 'id')->toArray();
        $vacancy = new UserVacancy();
        $statuses = [
            'not_processed' => 'He обработан',
            'processing' => 'B обработке',
            'selected' => 'Отобран',
            'interview' => 'Собеседование',
            'hired' => 'Принят на работу',
            'rejected' => 'Отклонен'
        ];

        $user_cv = new UserCV();

        return view('admin.user_cv.create', compact('title', 'vacancy', 'vacancies', 'users', 'statuses', 'citizenship'));
    }

    public function store(Request $request, UserVacancy $userVacancy)
    {
        $this->validate($request, [
            'vacancy_id' => ['required'],
            'user_id' => ['required'],
            'status_id' => ['required'],
        ]);

        $user = User::where('id', $request->user_id)->first();
        if ($request->user_citizen) {
            $user->citizen = $request->user_citizen;
        }

        $current_birthdate = Carbon::now();
        $birth_date = Carbon::parse($user->birth_date);
        $diff = $birth_date->diffInYears($current_birthdate);

        if ($request->user_age && $diff != $request->user_age) {
            $user->birth_date = $current_birthdate->subYears($request->user_age);
        }
        $user->save();

        $userVacancy->user_id = $request->user_id;
        $userVacancy->vacancy_id = $request->vacancy_id;
        $userVacancy->status = $request->status_id;
        $userVacancy->type = 'SUBMITTED';
        $userVacancy->save();

        $chat = Chat::where('user_id', $request->user_id)->where('company_id', auth()->user()->id)->where('vacancy_id', $request->vacancy_id)->first();
        if (!$chat) {
            $newChat = new Chat();
            $newChat->user_id = $request->user_id;
            $newChat->company_id = auth()->user()->id;
            $newChat->vacancy_id = $request->vacancy_id;
            $newChat->save();
        }
        return redirect()->route('user_cv.index');
    }

    public function show($id)
    {
        $title = 'Поданные резюме';
        $userVacancy = UserVacancy::findOrFail($id);
        $user = User::findOrFail($userVacancy->user_id);
        $vacancy = Vacancy::findOrFail($userVacancy->vacancy_id);
        $user_cv = UserCV::where('user_id', $userVacancy->user_id)->firstOrFail();

        $user_educations = UserEducation::where('user_cv_id', $user_cv->id)->get();
        $user_experiences = UserExperience::where('user_cv_id', $user_cv->id)->get();
        $user_courses = UserCourse::where('user_cv_id', $user_cv->id)->get();

        return view('admin.user_cv.show', compact('user', 'vacancy', 'title', 'user_educations', 'user_experiences', 'user_courses'));
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

        $company_vacancies = Vacancy::where('company_id', auth()->user()->id)->pluck('id')->toArray();
        $resultPaginated = UserVacancy::whereIn("vacancy_id", $company_vacancies)->where("type", 'SUBMITTED')->orderBy('id', 'desc');

        if ($query) {
            if (array_key_exists('generalSearch', $query)) {
                $resultPaginated = $resultPaginated->search($query['generalSearch'], null, true, true);
            }
        }

        $resultPaginated = $resultPaginated->paginate($perpage);

        foreach ($resultPaginated as $key => $row) {
            $row->date = date('d/m/y H:i', strtotime($row->created_at));
            $row->order = ($page - 1) * $perpage + $key + 1;

            $row->name = $row->vacancy->name;
            $row->user_name = $row->user->name;

            $row->actions = '
                <a href="' . route('user_cv.show', $row) . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Просмотр">
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
            ';
        }

        if (array_key_exists('pages', $pagination)) {
            $pages = $pagination['pages'];
        } else {
            $pages = $resultPaginated->lastPage();
        }

        if (array_key_exists('total', $pagination)) {
            $total = $pagination['total'];
        } else {
            $total = $resultPaginated->total();
        }

        $meta = array(
            'page' => $page,
            'pages' => $pages,
            'perpage' => $perpage,
            'total' => $total
        );

        $result = array('meta' => $meta, 'data' => $resultPaginated->all());
        return json_encode($result);
    }

    public function update_status($id, $value)
    {
        $vacancy = UserVacancy::where('id', $id)->first();
        $vacancy->status = $value;
        $vacancy->save();
        return 'success';
    }

    public function get_vacancy(Request $request)
    {
        $vacancy = Vacancy::where('id', $request->id)->first();
        $region = Region::find($vacancy->region);
        $country = Country::find($region->country);
        $region->countryName = $country->nameRu;
        return json_encode($region);
    }

    public function get_user(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $citizen = $user->citizen ? Country::find($user->citizen) : new Country();

        if ($user->birth_date) {
            $birthdate = new DateTime($user->birth_date);
            $current_date = new DateTime('today');
            $age = $birthdate->diff($current_date)->y;
            $citizen->age = $age;
        } else {
            $citizen->age = 0;
        }
        return json_encode($citizen);
    }
}