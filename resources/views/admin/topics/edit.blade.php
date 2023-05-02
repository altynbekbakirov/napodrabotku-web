@extends('admin.layouts.app')

@section('content')

    @subheader
    Успешные кейсы. Бизнес темы.
    @endsubheader

    @content
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Редактировать
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                <div class="m-portlet__body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {!! Form::model($row,
                        [	'id' => 'editForm',
                            'route' => ['topics.update', $row],
                            'method' => 'PUT',
                            'enctype' => 'multipart/form-data'
                        ]) !!}
                        @include('admin.topics.form', $row)
                    {!! Form::close() !!}
                </div>
            <!--end::Form-->
            </div>
            <!--end::Portlet-->
        </div>
    </div>
    @endcontent

@endsection

@section('scripts')
<script>

	$('#post_loader').hide();
    $("#editForm").on("submit", function(){
        $("#post_loader").show();
    });

    moment.locale('ru');

    var uploadedGalleryMap = {}
    Dropzone.options.galleryDropzone = {
        url: "{{route('topics.mediaStore')}}",
        maxFilesize: 10,
        addRemoveLinks: true,
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        dictCancelUpload: 'Айнуу',
        dictCancelUploadConfirmation: 'Өчүрүү',
        dictRemoveFile : 'Файлды өчүрүү',
        dictDefaultMessage: 'Файл тандаңыз',
        dictFileTooBig: 'Файлдын көлөмү 6 мб көп',
        headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function (file, response) {
            $('form').append('<input type="hidden" name="gallery[]" value="' + response.name + '">')
            uploadedGalleryMap[file.name] = response.name
        },
        removedfile: function (file) {
            file.previewElement.remove();
            $.post({
                url: "{{route('topics.mediaDelete')}}",
                data: {
                    id: file.id,
                    post_id: file.model_id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'json',
            });
        },
        init: function () {
            @if(isset($row) && $row->getMedia('topic_gallery'))
                var files =
                {!! json_encode($row->getMedia('topic_gallery')) !!}
                for (var i in files) {

                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, '/storage/topic/gallery/'+ file.model_id +'/' + file.file_name)
                    this.options.complete.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="gallery[]" value="' + file.file_name + '">')
                }
            @endif
        }
    }

    $("#thumbremove").click(function (e) {
        event.preventDefault();
        var post = "{{$row->id}}";
        var url = "{{ route('topics.removethumb') }}";
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            cache: false,
            type: 'POST',
            url: url,
            data: {
                'post':post,
            },
            success: function (data) {
                if (data.status) {
                    console.log('Success')
                }
            }

        });
    });
</script>
@endsection
