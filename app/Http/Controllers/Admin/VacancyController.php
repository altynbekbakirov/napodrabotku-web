<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewMessageSent;
use App\Http\Controllers\Controller;
use App\Models\Busyness;
use App\Models\Country;
use App\Models\District;
use App\Models\JobType;
use App\Models\Region;
use App\Models\Schedule;
use App\Models\Chat;
use App\Models\User;
use App\Models\Vacancy;
use App\Models\VacancyType;
use App\Models\Currency;
use App\Models\Word;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use MoveMoveIo\DaData\Enums\Language;
use MoveMoveIo\DaData\Facades\DaDataAddress;
use Illuminate\Support\Arr;

class VacancyController extends Controller
{
    public function index()
    {
        $title = 'Вакансии';

        $districts = District::pluck('nameRu', 'id', 'region')->toArray();
        $regions = Region::pluck('nameRu', 'id')->toArray();
        $busynesses = Busyness::pluck('name_ru', 'id')->toArray();
        $vacancy_types = VacancyType::pluck('name_ru', 'id')->toArray();
        $job_types = JobType::pluck('name_ru', 'id')->toArray();
        $schedules = Schedule::pluck('name_ru', 'id')->toArray();
        $companies = User::where('type', 'COMPANY')->pluck('name', 'id')->toArray();

        if (auth()->user()->type == 'COMPANY') {
            $statuses = Vacancy::where('company_id', auth()->user()->id)->pluck('status')->toArray();
        } else {
            $statuses = Vacancy::pluck('status')->toArray();
        }
        $statuses_count = array_count_values($statuses);

        $stats = [
            'all' => '<button type="button" class="btn btn-lg btn-success" status_id="all">Всего <span class="label label-primary">' . count($statuses) . '</span></button>&nbsp;',
            'not_published' => '<button type="button" class="btn btn-lg btn-light" status_id="not_published">He опубликовано <span class="label label-primary">0</span></button>&nbsp;',
            'denied' => '<button type="button" class="btn btn-lg btn-light" status_id="not_published">Отклонено <span class="label label-primary">0</span></button>&nbsp;',
            'active' => '<button type="button" class="btn btn-lg btn-light" status_id="active">Активно <span class="label label-primary">0</span></button>&nbsp;',
            'archived' => '<button type="button" class="btn btn-lg btn-light" status_id="archived">В архиве <span class="label label-primary">0</span></button>&nbsp;',
            'deleted' => '<button type="button" class="btn btn-lg btn-light" status_id="deleted">Удалено <span class="label label-primary">0</span></button>&nbsp;',
        ];

        foreach ($statuses as $key => $value) {
            if ($value === 'not_published') {
                $stats[$value] = '<button type="button" class="btn btn-lg btn-light" status_id="not_published">He опубликовано <span class="label label-primary">' . $statuses_count[$value] . '</span></button>&nbsp;';
            }
            if ($value === 'denied') {
                $stats[$value] = '<button type="button" class="btn btn-lg btn-light" status_id="denied">Отклонено <span class="label label-primary">' . $statuses_count[$value] . '</span></button>&nbsp;';
            }
            if ($value === 'active') {
                $stats[$value] = '<button type="button" class="btn btn-lg btn-light" status_id="active">Активно <span class="label label-primary">' . $statuses_count[$value] . '</span></button>&nbsp;';
            }
            if ($value === 'archived') {
                $stats[$value] = '<button type="button" class="btn btn-lg btn-light" status_id="archived">В архиве <span class="label label-primary">' . $statuses_count[$value] . '</span></button>&nbsp;';
            }
            if ($value === 'deleted') {
                $stats[$value] = '<button type="button" class="btn btn-lg btn-light" status_id="deleted">Удалено <span class="label label-primary">' . $statuses_count[$value] . '</span></button>&nbsp;';
            }
        }

        if (auth()->user()->type == 'COMPANY') {
            $data = Vacancy::where('company_id', auth()->user()->id);
        } else {
            $data = Vacancy::query();
        }


        if (request()->ajax()) {

            if (request()->status_id && request()->status_id != 'all') {
                $data = $data->where('status', request()->status_id);
            }

            if (request()->district_id) {
                $data = $data->whereIn('district', request()->district_id);
            }

            if (request()->region_id) {
                $data = $data->whereIn('region', request()->region_id);
            }

            if (request()->busyness_id) {
                $data = $data->whereIn('busyness_id', request()->busyness_id);
            }

            if (request()->vacancy_type_id) {
                $data = $data->whereIn('vacancy_type_id', request()->vacancy_type_id);
            }

            if (request()->job_type_id) {
                $data = $data->whereIn('job_type_id', request()->job_type_id);
            }

            if (request()->schedule_id) {
                $data = $data->whereIn('schedule_id', request()->schedule_id);
            }

            if (request()->company_id) {
                $data = $data->whereIn('company_id', request()->company_id);
            }

            $data = $data->orderBy('id', 'desc')->get();

            return datatables()->of($data)
                ->addColumn('check_box', function ($row) {
                    if (auth()->user()->type == 'ADMIN') {
                        return '<input type="checkbox" name="checkbox-product" product_data_id="' . $row->id . '" />';
                    } else {
                        if ($row->status == 'not_published' || $row->status == 'denied') {
                            return '<input type="checkbox" name="checkbox-product" disabled="disabled" product_data_id="' . $row->id . '" />';
                        } else {
                            return '<input type="checkbox" name="checkbox-product" product_data_id="' . $row->id . '" />';
                        }
                    }
                })
                ->addIndexColumn()
                ->addColumn('acts', function ($row) {
                    return '
                    <a href="' . route('vacancies.show', $row) . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Просмотр">
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
                    <a href="' . route('vacancies.edit', $row) . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Редактировать">
                        <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                    <path d="M7.10343995,21.9419885 L6.71653855,8.03551821 C6.70507204,7.62337518 6.86375628,7.22468355 7.15529818,6.93314165 L10.2341093,3.85433055 C10.8198957,3.26854411 11.7696432,3.26854411 12.3554296,3.85433055 L15.4614112,6.9603121 C15.7369117,7.23581259 15.8944065,7.6076995 15.9005637,7.99726737 L16.1199293,21.8765672 C16.1330212,22.7048909 15.4721452,23.3869929 14.6438216,23.4000848 C14.6359205,23.4002097 14.6280187,23.4002721 14.6201167,23.4002721 L8.60285976,23.4002721 C7.79067946,23.4002721 7.12602744,22.7538546 7.10343995,21.9419885 Z" id="Path-11" fill="#000000" fill-rule="nonzero" transform="translate(11.418039, 13.407631) rotate(-135.000000) translate(-11.418039, -13.407631) "></path>
                                </g>
                            </svg>
                        </span>
                    </a>
                    <a href="' . route('vacancies.delete', $row) . '" class="btn btn-sm btn-clean btn-icon" title="Удалить">
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
                ->addColumn('name', function ($row) {
                    if (strlen($row->name) > 50) {
                        return '<a href="' . route('vacancies.show', $row) . '" title="Просмотр">' . mb_substr($row->name, 0, 50) . '</a>';
                    } else {
                        return '<a href="' . route('vacancies.show', $row) . '" title="Просмотр">' . $row->name . '</a>';
                    }
                })
                ->addColumn('company_name', function ($row) {
                    return $row->company ? $row->company->name : '-';
                })
                ->addColumn('region', function ($row) {
                    return District::find($row->district) ? District::find($row->district)->nameRu : '-';
                })
                ->addColumn('job_type', function ($row) {
                    return $row->jobtype ? $row->jobtype->name_ru : '-';
                })
                ->addColumn('created_at', function ($row) {
                    return date('d.m.Y H:i', strtotime($row->created_at));
                })
                ->addColumn('status', function ($row) {
                    switch ($row->status) {
                        case 'active':
                            if (auth()->user()->type == 'ADMIN') {
                                $status = '<span class="label label-primary label-inline label-lg"><strong>Опубликовано</strong> </span><br/><span style="color:grey; font-size:12px;">с ' . date('d.m.Y', strtotime($row->status_update_at)) . '</span>';
                            } else {
                                $status = '<span class="label label-primary label-inline label-lg"><strong>Активно</strong> </span><br/><span style="color:grey; font-size:12px;">с ' . date('d.m.Y', strtotime($row->status_update_at)) . '</span>';
                            }
                            break;
                        case 'archived':
                            $status = '<span class="label label-inline label-lg"><strong>В архиве</strong></span><br/><span style="color:grey; font-size:12px;">с ' . date('d.m.Y', strtotime($row->status_update_at)) . '</span>';
                            break;
                        case 'deleted':
                            $status = '<span class="label label-danger label-inline label-lg">Удалено</span><br/><span style="color:grey; font-size:12px;">с ' . date('d.m.Y', strtotime($row->status_update_at)) . '</span>';
                            break;
                        case 'denied':
                            $status = '<span class="label label-warning label-inline label-lg"><strong>Отклонено</strong></span>';
                            break;
                        case 'not_published':
                            if (auth()->user()->type == 'ADMIN') {
                                $status = '
                                <p class="label label-info label-inline label-lg"><strong>Требуется проверка</strong></p><br/><br/>
                                <button type="button" class="btn btn-light-success btn-sm btn-publish" data-product-id=" ' . $row->id . '">Опубликовать</button>&nbsp;&nbsp;
                                <button type="button" class="btn btn-light-danger btn-sm btn-denied" data-product-id=" ' . $row->id . '">Отклонить</button>
                                </p>';
                            } else {
                                $status = '<span class="label label-info label-inline label-lg"><strong>На модерации</strong></span>';
                            }
                            break;
                        default:
                            $status = '<span class="label label-info label-inline label-lg"><strong>На модерации</strong></span>';
                    }
                    return $status;
                })
                ->rawColumns(['check_box', 'name', 'acts', 'status'])
                ->make(true);
        }

        return view('admin.vacancies.index', compact('title', 'districts', 'regions', 'busynesses', 'vacancy_types', 'job_types', 'schedules', 'companies', 'stats'));
    }

    public function create()
    {
        $vacancy = new Vacancy();
        $title = 'Вакансии';
        $companies = User::where('type', 'COMPANY')->pluck('name', 'id')->toArray();
        $regions = Region::pluck('nameRu', 'id')->toArray();
        $districts = District::pluck('nameRu', 'id')->toArray();
        $countries = Country::pluck('nameRu', 'id')->toArray();
        $busynesses = Busyness::pluck('name_ru', 'id')->toArray();
        $vacancy_types = VacancyType::pluck('name_ru', 'id')->toArray();
        $job_types = JobType::pluck('name_ru', 'id')->toArray();
        $schedules = Schedule::pluck('name_ru', 'id')->toArray();
        $currencies = Currency::pluck('name_ru', 'id')->toArray();
        $badwords = Word::pluck('name')->toArray();
        $metros = [];

        if (app()->getLocale() == 'ru') {
            $vacancy->currency = 3;
        }

        return view('admin.vacancies.create', compact('vacancy', 'title', 'companies', 'regions', 'districts', 'busynesses', 'vacancy_types', 'job_types', 'schedules', 'currencies', 'countries', 'metros', 'badwords'));
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

        $html = 'Новая вакансия <br /><a href="http://188.246.185.182/admin/vacancies"> ' . $vacancy->name . '</a>';

        Mail::send([], [], function ($message) use ($html) {
            $message->to('admin@napodrabotku.com')
                ->subject('Вакансия для обработки')
                ->from('service@napodrabotku.com')
                ->setBody($html, 'text/html');
        });

        return redirect()->route('vacancies.index');
    }

    public function show(Vacancy $vacancy)
    {
        $title = 'Вакансии';
        return view('admin.vacancies.show', compact('vacancy', 'title'));
    }

    public function edit(Vacancy $vacancy)
    {
        $title = 'Вакансии';
        $companies = User::where('type', 'COMPANY')->pluck('name', 'id')->toArray();
        $busynesses = Busyness::pluck('name_ru', 'id')->toArray();
        $vacancy_types = VacancyType::pluck('name_ru', 'id')->toArray();
        $job_types = JobType::pluck('name_ru', 'id')->toArray();
        $schedules = Schedule::pluck('name_ru', 'id')->toArray();
        $currencies = Currency::pluck('name_ru', 'id')->toArray();
        $vacancy->region = Region::find($vacancy->region) ? Region::find($vacancy->region)->nameRu : '';
        $vacancy->district = District::find($vacancy->district) ? District::find($vacancy->district)->nameRu : '';
        $badwords = Word::pluck('name')->toArray();
        $metros = [];

        if ($vacancy->address && $vacancy->metro) {
            $dadata = DaDataAddress::prompt($vacancy->address, 1, Language::RU, ["country_iso_code" => "*"]);
            if ($dadata['suggestions'][0]['data']['metro']) {
                foreach ($dadata['suggestions'][0]['data']['metro'] as $item) {
                    $token = "d06b572efe686359a407652e5f66ef079ea649dc";
                    $dadataMetro = new \Dadata\DadataClient($token, null);
                    $result = $dadataMetro->suggest("metro", $item['name']);
                    foreach ($result as $row) {
                        $selected = in_array($row['data']['name'] . '-' . $row['data']['line_name'], $vacancy->metro) ? 'selected' : '';
                        if ($row['data']['line_name'] == $item['line']) {
                            $metros[] = '<option ' . $selected . ' data-content="<span class=\'badge\' style=\'color: #ffffff; background-color: #' . $row['data']['color'] . '\'>' . $row['data']['name'] . ' (' . $row['data']['line_name'] . ')</span>" value="' . $row['data']['name'] . '-' . $row['data']['line_name'] . '">
                            ' . $row['data']['name'] . ' (' . $row['data']['line_name'] . ')
                            </option>';
                        }
                    }
                }
            }
        }

        return view('admin.vacancies.edit', compact('vacancy', 'title', 'companies', 'busynesses', 'vacancy_types', 'job_types', 'schedules', 'currencies', 'metros', 'badwords'));
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

        // Mail::raw('This is the content of mail body', function ($message) {
        //     $message->from('service@napodrabotku.com', 'napodrabotku.ru');
        //     $message->to('admin@napodrabotku.com');
        //     $message->subject('Вакансия для обработки');
        // });

        $html = 'Вакансия отредактирована <br /><a href="http://188.246.185.182/admin/vacancies"> ' . $vacancy->name . '</a>';

        Mail::send([], [], function ($message) use ($html) {
            $message->to('admin@napodrabotku.com')
                ->subject('Вакансия для обработки')
                ->from('service@napodrabotku.com')
                ->setBody($html, 'text/html');
        });

        return redirect()->route('vacancies.index');
    }

    public function destroy(Vacancy $vacancy)
    {
        $chats = Chat::where('vacancy_id', $vacancy->id)->get();
        foreach ($chats as $chat) {
            $chat->delete();
        }
        $vacancy->delete();
        return redirect()->route('vacancies.index');
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
                <a href="' . route('vacancies.show', $row) . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Просмотр">
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
                <a href="' . route('vacancies.edit', $row) . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Редактировать">
                    <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                <path d="M7.10343995,21.9419885 L6.71653855,8.03551821 C6.70507204,7.62337518 6.86375628,7.22468355 7.15529818,6.93314165 L10.2341093,3.85433055 C10.8198957,3.26854411 11.7696432,3.26854411 12.3554296,3.85433055 L15.4614112,6.9603121 C15.7369117,7.23581259 15.8944065,7.6076995 15.9005637,7.99726737 L16.1199293,21.8765672 C16.1330212,22.7048909 15.4721452,23.3869929 14.6438216,23.4000848 C14.6359205,23.4002097 14.6280187,23.4002721 14.6201167,23.4002721 L8.60285976,23.4002721 C7.79067946,23.4002721 7.12602744,22.7538546 7.10343995,21.9419885 Z" id="Path-11" fill="#000000" fill-rule="nonzero" transform="translate(11.418039, 13.407631) rotate(-135.000000) translate(-11.418039, -13.407631) "></path>
                            </g>
                        </svg>
                    </span>
                </a>
                <a href="' . route('vacancies.delete', $row) . '" class="btn btn-sm btn-clean btn-icon" title="Удалить">
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

    public function get_regions($id)
    {
        if ($id == 0) {
            $regions = Region::pluck('nameRu', 'id')->toArray();
        } else {
            $array = array();
            $items = explode(",", $id);
            foreach ($items as $value) {
                $array[] = intval($value);
            }
            $region_ids = District::whereIn('id', $array)->pluck('region')->toArray();
            $regions = Region::whereIn('id', $region_ids)->pluck('nameRu', 'id')->toArray();
        }
        return json_encode($regions);
    }

    public function update_status(Request $request)
    {
        foreach ($request->vacancies as $value) {
            $vacancy = Vacancy::where('id', $value)->first();
            $vacancy->status = $request->status_type;
            $vacancy->status_update_at = date("Y-m-d H:i:s");
            $vacancy->save();
        }
        return 'success';
    }

    public function get_vacancy(Request $request)
    {
        $vacancy = Vacancy::where('id', $request->id)->first();
        $vacancy->created_at = date('d.m.Y', strtotime($vacancy->created_at));
        $vacancy->company_name = User::where('id', $vacancy->company_id)->first() ? User::where('id', $vacancy->company_id)->first()->name : null;
        $vacancy->type_name = JobType::where('id', $vacancy->job_type_id)->first() ? JobType::where('id', $vacancy->job_type_id)->first()->name_ru : null;
        $vacancy->vacancy_type_name = VacancyType::where('id', $vacancy->vacancy_type_id)->first() ? VacancyType::where('id', $vacancy->vacancy_type_id)->first()->name_ru : null;
        $vacancy->busyness_name = Busyness::where('id', $vacancy->busyness_id)->first() ? Busyness::where('id', $vacancy->busyness_id)->first()->name_ru : null;
        $vacancy->schedule_name = Schedule::where('id', $vacancy->schedule_id)->first() ? Schedule::where('id', $vacancy->schedule_id)->first()->name_ru : null;
        return $vacancy;
    }
}
