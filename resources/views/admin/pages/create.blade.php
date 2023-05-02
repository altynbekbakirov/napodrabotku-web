@extends('admin.layouts.app')

@section('content')

    @include('admin.subheaders.pages')

    @content
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Создать
                                </h3>
                            </div>
                        </div>
                    </div>
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
                        {!! Form::model(
                            $page,['id' => 'createForm',
                            'route' => 'pages.store',
                            'enctype' => 'multipart/form-data',
                            'class' => 'm-form']) !!}
                            @include('admin.pages.form', $page)
                        {!! Form::close() !!}
                        <!--end::Form-->
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    @endcontent

@endsection

@section('scripts')
<script>

        $('#post_loader').hide();
        $("#createForm").on("submit", function(){
            $("#post_loader").show();
        });
    
        var uploadedGalleryMap = {}
            Dropzone.options.galleryDropzone = {
                url: "{{ route('pages.mediaStore') }}",
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
                    file.previewElement.remove()
                    var name = ''
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name
                    } else {
                        name = uploadedGalleryMap[file.name]
                    }
                    $('form').find('input[name="gallery[]"][value="' + name + '"]').remove()
                },
                init: function () {
                    @if(isset($page) && $page->getMedia('gallery'))
                        var files =
                        {!! json_encode($page->getMedia('gallery')) !!}
                        for (var i in files) {
                            var file = files[i]
                            this.options.addedfile.call(this, file)
                            file.previewElement.classList.add('dz-complete')
                            $('form').append('<input type="hidden" name="gallery[]" value="' + file.file_name + '">')
                        }
                    @endif
                }
            }
    </script>
@endsection

