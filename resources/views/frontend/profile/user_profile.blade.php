@extends('frontend.main_master')
@section('content')

    <div class="body-content">
        <div class="container">
            <div class="row">

                @include('frontend.common.user_sidebar')

                <div class="col-md-2">

                </div> <!-- // end col md 2 -->

                <div class="col-md-6">
                    <div class="card">
                        <h3 class="text-center"><span class="text-danger">Xin chào </span><strong>{{ Auth::user()->name }}</strong> đến chỉnh sửa thông tin</h3>

                        <div class="card-body">



                            <form method="post" action="{{ route('user.profile.store') }}" enctype="multipart/form-data">
                                @csrf


                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1">Tên của bạn <span> </span></label>
                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                                </div>

                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1">Địa chỉ Email <span> </span></label>
                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                                </div>


                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1">Số điện thoại của bạn <span> </span></label>
                                    <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                                </div>

                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1">Hình ảnh<span> </span></label>
                                    <input type="file" name="profile_photo_path" class="form-control" id="image">
                                </div>

                                <div class="form-group text-center">
                                    @php
                                        $previewPhoto = (!empty($user->profile_photo_path) && file_exists(public_path('upload/user_images/'.$user->profile_photo_path))) 
                                            ? asset('upload/user_images/'.$user->profile_photo_path) 
                                            : asset('upload/no_image.jpg');
                                    @endphp
                                    <img id="showImage" class="img-circle" style="width: 110px; height: 110px; object-fit: cover; border-radius: 50%; border: 2px solid #ddd; margin-top: 10px;" src="{{ $previewPhoto }}" alt="Xem trước ảnh">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger">Cập nhật thông tin</button>
                                </div>

                            </form>

                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $('#image').change(function(e){
                                        var reader = new FileReader();
                                        reader.onload = function(e){
                                            $('#showImage').attr('src', e.target.result);
                                        }
                                        if(e.target.files && e.target.files[0]) {
                                            reader.readAsDataURL(e.target.files[0]);
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
