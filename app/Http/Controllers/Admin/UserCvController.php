<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use DateTime;

class UserCvController extends Controller
{
    public function index()
    {

        $vacancies = Vacancy::where('company_id', auth()->user()->id)->pluck('name', 'id')->toArray();
        $vacancies_ids = Vacancy::where('company_id', auth()->user()->id)->pluck('id')->toArray();
        $region_ids = Vacancy::where('company_id', auth()->user()->id)->pluck('region_id')->toArray();
        $regions = Region::whereIn('id', $region_ids)->pluck('nameRu', 'id')->toArray();
        $statuses = UserVacancy::whereIn('vacancy_id', $vacancies_ids)->pluck('status')->toArray();
        $statuses_count = array_count_values($statuses);

        foreach ($statuses as $key => $value) {
            if ($value === 'not_processed') {
                $statuses[$value] = 'He обработан (' . $statuses_count[$value] . ')';
                unset($statuses[$key]);
            }
            if ($value === 'processing') {
                $statuses[$value] = 'B обработке (' . $statuses_count[$value] . ')';
                unset($statuses[$key]);
            }
            if ($value === 'selected') {
                $statuses[$value] = 'Отобран (' . $statuses_count[$value] . ')';
                unset($statuses[$key]);
            }
            if ($value === 'interview') {
                $statuses[$value] = 'Собеседование (' . $statuses_count[$value] . ')';
                unset($statuses[$key]);
            }
            if ($value === 'hired') {
                $statuses[$value] = 'Принят на работу (' . $statuses_count[$value] . ')';
                unset($statuses[$key]);
            }
            if ($value === 'rejected') {
                $statuses[$value] = 'Отклонен (' . $statuses_count[$value] . ')';
                unset($statuses[$key]);
            }
        }

        $sexes = User::where('id', auth()->user()->id)->pluck('gender')->toArray();
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

        $title = 'Поданные резюме';
        if (request()->ajax()) {

            if (request()->region_id && request()->period_id) {
                $company_vacancies = Vacancy::where('region_id', request()->region_id)->where('period', request()->period_id)->where('company_id', auth()->user()->id)->pluck('id')->toArray();
            } else if (request()->region_id) {
                $company_vacancies = Vacancy::where('region_id', request()->region_id)->where('company_id', auth()->user()->id)->pluck('id')->toArray();
            } else if (request()->period_id) {
                $company_vacancies = Vacancy::where('period', request()->period_id)->where('company_id', auth()->user()->id)->pluck('id')->toArray();
            } else {
                $company_vacancies = Vacancy::where('company_id', auth()->user()->id)->pluck('id')->toArray();
            }

            if (request()->vacancy_id && request()->status_id) {
                $data = UserVacancy::where('vacancy_id', request()->vacancy_id)->where('status', request()->status_id);
            } else if (request()->vacancy_id) {
                $data = UserVacancy::where('vacancy_id', request()->vacancy_id);
            } else if (request()->status_id) {
                $data = UserVacancy::where('status', request()->status_id);
            } else {
                $data = UserVacancy::query();
            }

            $data = $data->whereIn("vacancy_id", $company_vacancies)->where("type", 'SUBMITTED')->orderBy('id', 'desc');

            if (request()->name) {
                $data = $data->with(['usersList']);
                $user_name = request()->name;
                $data = $data->where(function ($query) use ($user_name) {
                    $query->whereHas('usersList', function ($q) use ($user_name) {
                        $q->where('name', 'LIKE', '%' . $user_name . '%');
                    });
                });
            }

            if (request()->sex_id) {
                $data = $data->with(['usersList']);
                $user_name = request()->sex_id;
                $data = $data->where(function ($query) use ($user_name) {
                    $query->whereHas('usersList', function ($q) use ($user_name) {
                        $q->where('gender', $user_name);
                    });
                });
            }

            $data = $data->get();

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('acts', function ($row) {
                    return '
                    <a href="' . route('user_cv.show', $row) . '" class="btn btn-light-primary font-weight-bold mr-2" title="Перейти в чат">
                        Перейти в чат
                    </a>';
                })
                ->addColumn('date', function ($row) {
                    return date('d/m/y H:i', strtotime($row->created_at));
                })
                ->addColumn('name', function ($row) {
                    return $row->vacancy->name;
                })
                ->addColumn('region', function ($row) {
                    return Region::where('id', $row->vacancy->region_id)->first()->nameRu;
                })
                ->addColumn('citizen', function ($row) {
                    return Country::where('id', $row->user->citizen)->first()->nameRu;
                })
                ->addColumn('user_name', function ($row) {
                    return $row->user->lastname . ' ' . $row->user->name . ' ' . $row->user->phone_number;
                })
                ->addColumn('birth_date', function ($row) {
                    $birthdate_str = $row->user->birth_date;
                    $birthdate = new DateTime($birthdate_str);
                    $current_date = new DateTime();
                    $age = $birthdate->diff($current_date)->y;
                    return $age . ' лет';
                })
                ->addColumn('status', function ($row) {
                    $statuses = [
                        'not_processed' => 'He обработан',
                        'processing' => 'B обработке',
                        'selected' => 'Отобран',
                        'interview' => 'Собеседование',
                        'hired' => 'Принят на работу',
                        'rejected' => 'Отклонен'
                    ];

                    $options = '';
                    foreach ($statuses as $value => $label) {
                        $selected = $row->status == $value ? 'selected' : '';
                        $options .= '<option value="' . $value . '" data-vacancy-id="' . $row->id . '" ' . $selected . '>' . $label . '</option>';
                    }
                    return '<select class="select_status form-control">' . $options . '</select>';
                })
                ->addColumn('user_name', function ($row) {
                    return $row->user->lastname . ' ' . $row->user->name . ' ' . $row->user->phone_number;
                })
                ->rawColumns(['acts', 'status'])
                ->make(true);
        }
        return view('admin.user_cv.index', compact('title', 'vacancies', 'regions', 'sexes', 'statuses'));
    }

    public function create()
    {
        $title = 'Отклики';
        $vacancy = new Vacancy();
        return view('admin.user_cv.create', compact('title', 'vacancy'));
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
        // $company_vacancies = Vacancy::where('company_id', auth()->user()->id)->pluck('id')->toArray();
        // $resultPaginated = UserVacancy::whereIn("vacancy_id", $company_vacancies)->where("type", 'SUBMITTED')->orderBy('id', 'desc');
        // // dd(UserVacancy::get());

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
        // dd($resultPaginated);

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
}
