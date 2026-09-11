@php
    $id = Auth::user()->id;
    $user = App\Models\User::find($id);
    $userPhoto = (!empty($user->profile_photo_path) && file_exists(public_path('upload/user_images/'.$user->profile_photo_path))) 
        ? asset('upload/user_images/'.$user->profile_photo_path) 
        : asset('upload/no_image.jpg');
@endphp


<div class="col-md-2 text-center"><br>
    <img class="img-circle" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #337ab7; border-radius: 50%; box-shadow: 0 2px 6px rgba(0,0,0,0.15); margin: 0 auto 20px auto; display: block;" src="{{ $userPhoto }}" alt="{{ $user->name ?? 'Avatar' }}">

    <ul class="list-group list-group-flush">
        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm btn-block">Trang chủ</a>
        <a href="{{ route('user.profile') }}" class="btn btn-primary btn-sm btn-block">Cập nhật thông tin</a>
        <a href="{{ route('change.password') }}" class="btn btn-primary btn-sm btn-block">Thay đổi mật khẩu</a>
        <a href="{{ route('my.orders') }}" class="btn btn-primary btn-sm btn-block">Đơn hàng của bạn</a>
        <a href="{{ route('return.order.list') }}" class="btn btn-primary btn-sm btn-block">Đơn hàng hoàn trả</a>
        <a href="{{ route('cancel.orders') }}" class="btn btn-primary btn-sm btn-block">Đơn hàng hủy bỏ</a>
        <a href="{{ route('user.logout') }}" class="btn btn-danger btn-sm btn-block">Đăng xuất</a>

    </ul>

</div>
