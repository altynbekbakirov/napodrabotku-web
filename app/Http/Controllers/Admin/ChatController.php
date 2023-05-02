<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Busyness;
use App\Models\Chat;
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
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class ChatController extends Controller
{
    public function index()
    {
        $title = 'Чаты';
        return view('admin.chats.index', compact('title'));
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

        $resultPaginated = Chat::whereNotNull('company_id');

        if($query){
            if(array_key_exists('generalSearch', $query)){
                $resultPaginated = $resultPaginated->search($query['generalSearch'], null, true, true);
            }
        }

        if($sort && $sort['field'] != 'order'){
            $resultPaginated = $resultPaginated->orderBy($sort['field'], $sort['sort']);
        } else {
            $resultPaginated = $resultPaginated->orderBy('id', 'desc');
        }

        $resultPaginated = $resultPaginated->paginate($perpage);

        foreach ($resultPaginated as $key => $row) {
            $row->date = date('d/m/y H:i', strtotime($row->created_at));
            $row->order = ($page - 1) * $perpage + $key + 1;

            $row->company_name = $row->company->name;
            $row->user_name = $row->user->name;
        }

        if(array_key_exists('pages', $pagination)) { $pages = $pagination['pages']; }
        else { $pages = $resultPaginated->lastPage(); }

        if(array_key_exists('total', $pagination)) { $total = $pagination['total']; }
        else { $total = $resultPaginated->total(); }

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
