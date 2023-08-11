@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Retailer')

@section('content')
    {{-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a
                href="{{ route('retailer-retailers-list') }}">Retailer</a> /</span>
        Edit Retailer</h4> --}}
    <div class="row">
        <!-- Basic -->
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Edit Retailer</h5>
                <div class="card-body">
                    @include('notification')
                    <form action="{{ route('retailer-update') }}" method="post" id="retailerForm"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="retailer_id" value="{{ $retailer->id }}">
                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ $retailer->name }}" name="name"
                                    id="html5-text-input" placeholder="Name" />
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="formFile" class="col-md-2 col-form-label">Logo </label>
                            <div class="col-md-10">
                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                    <div class="button-wrapper">
                                        <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">Upload new photo</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" id="upload" class="account-file-input" name="logo"
                                                hidden />
                                        </label>
                                        <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                            <i class="bx bx-reset d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Reset</span>
                                        </button>

                                        <p class="text-muted mb-0">Allowed JPG, JPEG, SVG or PNG. Max size of 2048K</p>
                                    </div>

                                    <?php
                                    echo $retailer->logo != '' ? '<a href="' . asset('storage/retailerLogos/' . $retailer->logo) . '" data-lightbox="image-' . $retailer->id . '" data-title="' . $retailer->name . '" id="popupImage"><img src="' . asset('storage/retailerLogos/' . $retailer->logo) . '" alt="' . $retailer->name . '" class="d-block rounded" id="uploadedAvatar" width="200" height="100"></a>' : '<a href="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png" data-lightbox="image-' . $retailer->id . '" data-title="' . $retailer->name . '" id="popupImage"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png" alt="No Image" class="d-block rounded" id="uploadedAvatar" width="200" height="100"></a>';
                                    ?>
                                </div>
                            </div>
                        </div>


                        <div class="mb-3 row">
                            <label for="html5-tel-input" class="col-md-2 col-form-label">Energy<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <div class="form-check form-check-inline mt-3">
                                    <input class="form-check-input" type="radio" name="energy" id="energy1"
                                        value="1" {{ $retailer->energy == 1 ? 'checked' : '' }} />
                                    <label class="form-check-label" for="energy1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="energy" id="energy2"
                                        value="0" {{ $retailer->energy == 0 ? 'checked' : '' }} />
                                    <label class="form-check-label" for="energy2">No</label>
                                </div>
                                @error('energy')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="html5-tel-input" class="col-md-2 col-form-label">Broadband<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <div class="form-check form-check-inline mt-3">
                                    <input class="form-check-input" type="radio" name="broadband" id="broadband1"
                                        value="1" {{ $retailer->broadband == 1 ? 'checked' : '' }} />
                                    <label class="form-check-label" for="broadband1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="broadband" id="broadband2"
                                        value="0" {{ $retailer->broadband == 0 ? 'checked' : '' }} />
                                    <label class="form-check-label" for="broadband2">No</label>
                                </div>
                                @error('broadband')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="html5-tel-input" class="col-md-2 col-form-label">Status <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10">

                                <div class="form-check form-check-inline mt-3">
                                    <input class="form-check-input" type="radio" name="retailer_status"
                                        id="retailer_status1" value="Yes"
                                        {{ $retailer->active == 'Yes' ? 'checked' : '' }} />
                                    <label class="form-check-label" for="retailer_status1">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="retailer_status"
                                        id="retailer_status2" value="No"
                                        {{ $retailer->broadband == 'No' ? 'checked' : '' }} />
                                    <label class="form-check-label" for="retailer_status2">Inactive</label>
                                </div>

                                @error('user_status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="tncText" class="col-md-2 col-form-label">T&C Text <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <textarea name="tncText" id="tncText" class="form-control" autocomplete="off">{{ $retailer->tncText }}</textarea>
                                @error('tncText')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3" style="text-align: center;">
                            <button type="button" class="btn btn-warning" id="formSubmitBtn">Update Retailer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script type="text/javascript" src='https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js'
        referrerpolicy="origin"></script>
    <script>
        $(document).ready(function() {
            $('#formSubmitBtn').on('click', function() {
                let btn = $(this)
                btn.attr("disabled", "disabled")
                btn.html(`Please wait <i class="fa fa-spinner fa-pulse fa-fw"></i>`)
                let form = $('#retailerForm')
                setTimeout(() => {
                    form.submit();
                }, 900);
            });

            $('#retailerForm').on('keypress', function(event) {
                if (event.which === 13 || event.keyCode === 13) {
                    $('#formSubmitBtn').trigger('click');
                }
            });
        });
    </script>

    <script type="text/javascript">
        tinymce.init({
            selector: '#tncText',
            // width: 800,
            // height: 300,
            plugins: [
                'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
                'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen',
                'insertdatetime',
                'media', 'table', 'emoticons', 'template', 'help'
            ],
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
                'forecolor backcolor emoticons | help',
            // menu: {
            //     favs: {
            //         title: 'My Favorites',
            //         items: 'code visualaid | searchreplace | emoticons'
            //     }
            // },
            menubar: 'favs file edit view insert format tools table help',
            // content_css: 'css/content.css'
        });

        lightbox.option({
            'resizeDuration': 700,
            'wrapAround': true,
        })


        // Image upload time preview
        document.addEventListener('DOMContentLoaded', function(e) {
            (function() {
                const deactivateAcc = document.querySelector('#formAccountDeactivation');

                // Update/reset user image of account page
                let accountUserImage = document.getElementById('uploadedAvatar');
                let popupImage = document.getElementById('popupImage');
                const fileInput = document.querySelector('.account-file-input'),
                    resetFileInput = document.querySelector('.account-image-reset');

                if (accountUserImage) {
                    const resetImage = accountUserImage.src;
                    const resetPopUPImage = popupImage.href;
                    fileInput.onchange = () => {
                        if (fileInput.files[0]) {
                            accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
                            popupImage.href = window.URL.createObjectURL(fileInput.files[0]);
                        }
                    };
                    resetFileInput.onclick = () => {
                        fileInput.value = '';
                        accountUserImage.src = resetImage;
                        popupImage.href = resetPopUPImage;
                    };
                }
            })();
        });
        // End image upload time preview
    </script>
@endpush
