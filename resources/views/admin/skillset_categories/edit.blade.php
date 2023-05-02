@extends('admin.layouts.app')

@section('content')

    @include('admin.partials.subheader')

    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Редактировать</h3>
                </div>
                <!--begin::Form-->
            {!!Form::model($skillset_category, ['route' => ['skillset_categories.update', $skillset_category], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'class' => 'form'])!!}
            @include('admin.skillset_categories.form', $skillset_category)
            {!!Form::close() !!}
            <!--end::Form-->
            </div>
        </div>
        <!--end::Container-->
    </div>

@endsection

@section('scripts')
@endsection
