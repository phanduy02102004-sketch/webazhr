<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InternAuthMiddleware
{
    /**
     * Handle an incoming request.
     * Kiểm tra xác thực tài khoản Thực tập sinh (intern_user)
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('intern_user')) {
            $message = 'Vui lòng đăng nhập tài khoản Thực tập sinh để thực hiện Chuẩn đầu vào / Chuẩn đầu ra!';

            if ($request->is('*candidate/test*')) {
                $message = 'Theo quy trình của AZ Media: Chuẩn đầu vào yêu cầu Đăng nhập tài khoản Thực tập sinh (dành cho ứng viên đã được xác nhận thực tập).';
            } elseif ($request->is('*chuan-dau-ra*')) {
                $message = 'Vui lòng đăng nhập tài khoản Thực tập sinh để truy cập Cổng Chuẩn đầu ra & nộp báo cáo!';
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'redirect' => route('azmedia.intern.login', ['redirect' => $request->fullUrl()])
                ], 401);
            }

            return redirect()->route('azmedia.intern.login', ['redirect' => $request->fullUrl()])
                ->with('warning', $message);
        }

        return $next($request);
    }
}
