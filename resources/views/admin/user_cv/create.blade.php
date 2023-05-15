@extends('admin.layouts.app')

@section('content')
    @include('admin.partials.subheader')

    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Добавить</h3>
                </div>
                <!--begin::Form-->
                {!! Form::model($vacancy, ['route' => 'user_cv.store', 'enctype' => 'multipart/form-data', 'class' => 'form']) !!}
                @include('admin.user_cv.form', $vacancy)
                {!! Form::close() !!}
                <!--end::Form-->
            </div>
        </div>
        <!--end::Container-->
    </div>
@endsection

@section('scripts')
    <script>
        $('[name=vacancy_id]').on('change', function() {
            var id = $(this).val();
            var url = "{{ route('user_cv.get_vacancy') }}";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                cache: false,
                type: 'post',
                data: {
                    id: id
                },
                dataType: "json",
                url: url,
                success: function(data) {
                    if (data) {
                        $('input[name=vacancy_region]').val(data.nameRu);
                        $('input[name=vacancy_country]').val(data.countryName);
                    }
                }

            });
        });

        $('[name=user_id]').on('change', function() {
            var id = $(this).val();
            var url = "{{ route('user_cv.get_user') }}";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                cache: false,
                type: 'post',
                data: {
                    id: id
                },
                dataType: "json",
                url: url,
                success: function(data) {
                    if (data) {
                        console.log(data);
                        $('input[name=user_citizen]').val(data.nameRu);
                        $('input[name=user_age]').val(data.age);
                    }
                }

            });
        });

    </script>
@endsection
