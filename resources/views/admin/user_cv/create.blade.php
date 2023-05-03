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
        $('[name=region_id]').on('change', function() {
            var url = "{{ route('districts.region') }}";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                cache: false,
                type: 'POST',
                url: url,
                data: {
                    'region': $(this).val(),
                },
                success: function (data) {
                    if(data) {
                        $('[name=district_id]').html(data);
                        $('[name=district_id]').selectpicker('refresh');
                    }
                }

            });
        });

        jQuery.fn.ForceNumericOnly =
            function()
                {
                return this.each(function()
                {
                    $(this).keydown(function(e)
                    {
                        var key = e.charCode || e.keyCode || 0;
                        // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
                        // home, end, period, and numpad decimal
                        return (
                            key == 8 ||
                            key == 9 ||
                            key == 13 ||
                            key == 46 ||
                            key == 110 ||
                            key == 190 ||
                            (key >= 35 && key <= 40) ||
                            (key >= 48 && key <= 57) ||
                            (key >= 96 && key <= 105));
                    });
                });
            };

            $('.salary-input').ForceNumericOnly();
    </script>
@endsection

