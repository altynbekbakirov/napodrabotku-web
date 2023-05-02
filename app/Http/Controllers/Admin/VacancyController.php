<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Busyness;
use App\Models\Country;
use App\Models\District;
use App\Models\JobType;
use App\Models\Region;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Vacancy;
use App\Models\VacancyType;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class VacancyController extends Controller
{
    public function index()
    {
        $title = 'Вакансии';

        $regions = Region::pluck('nameRu', 'id')->toArray();
        $busynesses = Busyness::pluck('name_ru', 'id')->toArray();
        $vacancy_types = VacancyType::pluck('name_ru', 'id')->toArray();
        $job_types = JobType::pluck('name_ru', 'id')->toArray();
        $schedules = Schedule::pluck('name_ru', 'id')->toArray();
        $companies = User::where('type', 'COMPANY')->pluck('name', 'id')->toArray();

        if(request()->ajax()){
            if(auth()->user()->type == 'COMPANY'){
                $data = Vacancy::where('company_id', auth()->user()->id);
            } else {
                $data = Vacancy::query();
            }

            if (request()->region_id) {
                $data = $data->where('region_id', request()->region_id);
            }

            if (request()->busyness_id) {
                $data = $data->where('busyness_id', request()->busyness_id);
            }

            if (request()->vacancy_type_id) {
                $data = $data->where('vacancy_type_id', request()->vacancy_type_id);
            }

            if (request()->job_type_id) {
                $data = $data->where('job_type_id', request()->job_type_id);
            }

            if (request()->schedule_id) {
                $data = $data->where('schedule_id', request()->schedule_id);
            }

            if (request()->company_id) {
                $data = $data->where('company_id', request()->company_id);
            }

            $data = $data->orderBy('id', 'desc')->get();

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('acts', function ($row) {
                    return '
                    <a href="'.route('vacancies.show', $row).'" class="btn btn-sm btn-clean btn-icon mr-2" title="Просмотр">
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
                    <a href="'.route('vacancies.edit', $row).'" class="btn btn-sm btn-clean btn-icon mr-2" title="Редактировать">
                        <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                    <path d="M7.10343995,21.9419885 L6.71653855,8.03551821 C6.70507204,7.62337518 6.86375628,7.22468355 7.15529818,6.93314165 L10.2341093,3.85433055 C10.8198957,3.26854411 11.7696432,3.26854411 12.3554296,3.85433055 L15.4614112,6.9603121 C15.7369117,7.23581259 15.8944065,7.6076995 15.9005637,7.99726737 L16.1199293,21.8765672 C16.1330212,22.7048909 15.4721452,23.3869929 14.6438216,23.4000848 C14.6359205,23.4002097 14.6280187,23.4002721 14.6201167,23.4002721 L8.60285976,23.4002721 C7.79067946,23.4002721 7.12602744,22.7538546 7.10343995,21.9419885 Z" id="Path-11" fill="#000000" fill-rule="nonzero" transform="translate(11.418039, 13.407631) rotate(-135.000000) translate(-11.418039, -13.407631) "></path>
                                </g>
                            </svg>
                        </span>
                    </a>
                    <a href="'.route('vacancies.delete', $row).'" class="btn btn-sm btn-clean btn-icon" title="Удалить">
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
                ->addColumn('company_name', function ($row) { return $row->company ? $row->company->name : '-'; })
                ->addColumn('region', function ($row) { return Region::find($row->region_id) ? Region::find($row->region_id)->nameRu : '-'; })
                ->addColumn('job_type', function ($row) { return $row->jobtype ? $row->jobtype->name_ru : '-'; })
                ->rawColumns(['acts'])
                ->make(true);
        }

        return view('admin.vacancies.index', compact('title', 'regions', 'busynesses', 'vacancy_types', 'job_types', 'schedules', 'companies'));
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

        return view('admin.vacancies.create', compact('vacancy', 'title', 'companies', 'regions', 'districts', 'busynesses', 'vacancy_types', 'job_types', 'schedules', 'currencies', 'countries'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'salary' => ['required'],
            'currency' => ['required'],
            'period' => ['required'],
            'company_id' => ['required'],
            'description' => ['required'],
            'country_id' => ['required'],
            'region_id' => ['required'],
            'district_id' => ['required'],
            'busyness_id' => ['required'],
            'vacancy_type_id' => ['required'],
            'job_type_id' => ['required'],
            'schedule_id' => ['required'],
            'experience' => ['required'],
            'pay_period' => ['required'],
        ]);
        $vacancy = Vacancy::create($request->except('region_id'));
        $vacancy->region_id = $request->region_id;
        $vacancy->save();

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
        $regions = Region::pluck('nameRu', 'id')->toArray();
        $districts = District::where('region', $vacancy->region_id)->pluck('nameRu', 'id')->toArray();
        $countries = Country::pluck('nameRu', 'id')->toArray();
        $busynesses = Busyness::pluck('name_ru', 'id')->toArray();
        $vacancy_types = VacancyType::pluck('name_ru', 'id')->toArray();
        $job_types = JobType::pluck('name_ru', 'id')->toArray();
        $schedules = Schedule::pluck('name_ru', 'id')->toArray();
        $currencies = Currency::pluck('name_ru', 'id')->toArray();

        return view('admin.vacancies.edit', compact('vacancy', 'title', 'companies', 'regions', 'districts', 'busynesses', 'vacancy_types', 'job_types', 'schedules', 'currencies', 'countries'));
    }

    public function update(Request $request, Vacancy $vacancy)
    {
        $this->validate($request, [
            'name' => ['required'],
            'salary' => ['required'],
            'currency' => ['required'],
            'period' => ['required'],
            'company_id' => ['required'],
            'description' => ['required'],
            'country_id' => ['required'],
            'region_id' => ['required'],
            'district_id' => ['required'],
            'busyness_id' => ['required'],
            'vacancy_type_id' => ['required'],
            'job_type_id' => ['required'],
            'schedule_id' => ['required'],
            'experience' => ['required'],
            'pay_period' => ['required'],
        ]);
        $vacancy->update($request->all());

        return redirect()->route('vacancies.index');
    }

    public function destroy(Vacancy $vacancy)
    {
        $vacancy->delete();
        return redirect()->route('vacancies.index');
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

        if(auth()->user()->type == 'COMPANY'){
            $resultPaginated = Vacancy::where('company_id', auth()->user()->id);
        } else {
            $resultPaginated = Vacancy::whereNotNull('company_id');
        }

        if($query){
            if(array_key_exists('generalSearch', $query)){
                $resultPaginated = $resultPaginated->search($query['generalSearch'], null, true, true);
            }
            if(array_key_exists('region', $query)){
                if($query['region'] > 0){
                    $resultPaginated = $resultPaginated->where('region_id', $query['region']);
                }
            }
            if(array_key_exists('busyness', $query)){
                if($query['busyness'] > 0){
                    $resultPaginated = $resultPaginated->where('busyness_id', $query['busyness']);
                }
            }
            if(array_key_exists('vacancy_type', $query)){
                if($query['vacancy_type'] > 0){
                    $resultPaginated = $resultPaginated->where('vacancy_type_id', $query['vacancy_type']);
                }
            }
            if(array_key_exists('job_type', $query)){
                if($query['job_type'] > 0){
                    $resultPaginated = $resultPaginated->where('job_type_id', $query['job_type']);
                }
            }
            if(array_key_exists('schedule', $query)){
                if($query['schedule'] > 0){
                    $resultPaginated = $resultPaginated->where('schedule_id', $query['schedule']);
                }
            }
        }

        if($sort && $sort['field'] != 'order'){
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
                <a href="'.route('vacancies.show', $row).'" class="btn btn-sm btn-clean btn-icon mr-2" title="Просмотр">
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
                <a href="'.route('vacancies.edit', $row).'" class="btn btn-sm btn-clean btn-icon mr-2" title="Редактировать">
                    <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                <path d="M7.10343995,21.9419885 L6.71653855,8.03551821 C6.70507204,7.62337518 6.86375628,7.22468355 7.15529818,6.93314165 L10.2341093,3.85433055 C10.8198957,3.26854411 11.7696432,3.26854411 12.3554296,3.85433055 L15.4614112,6.9603121 C15.7369117,7.23581259 15.8944065,7.6076995 15.9005637,7.99726737 L16.1199293,21.8765672 C16.1330212,22.7048909 15.4721452,23.3869929 14.6438216,23.4000848 C14.6359205,23.4002097 14.6280187,23.4002721 14.6201167,23.4002721 L8.60285976,23.4002721 C7.79067946,23.4002721 7.12602744,22.7538546 7.10343995,21.9419885 Z" id="Path-11" fill="#000000" fill-rule="nonzero" transform="translate(11.418039, 13.407631) rotate(-135.000000) translate(-11.418039, -13.407631) "></path>
                            </g>
                        </svg>
                    </span>
                </a>
                <a href="'.route('vacancies.delete', $row).'" class="btn btn-sm btn-clean btn-icon" title="Удалить">
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

    public function districts(Request $request)
    {
        $result = '';
        $districts = District::where('region', $request->region)->get();
        foreach ($districts as $district){
            $result .= '<option value="'.$district->id.'">'.$district->nameRu.'</option>';
        }

        return $result;
    }
}

