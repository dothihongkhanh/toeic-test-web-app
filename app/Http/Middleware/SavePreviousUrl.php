<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SavePreviousUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentUrl = $request->fullUrl();
        
        // Lấy lịch sử URL từ session
        $history = Session::get('url_history', []);
        
        // Lưu URL hiện tại vào lịch sử nếu không trùng lặp với URL cuối cùng
        if (empty($history) || end($history) !== $currentUrl) {
            $history[] = $currentUrl;
        }

        // Giới hạn lịch sử URL ở mức 10 để tránh session quá lớn
        if (count($history) > 5) {
            array_shift($history); // Xóa URL đầu tiên
        }

        // Lưu lại lịch sử URL vào session
        Session::put('url_history', $history);
        
        return $next($request);
    }
}
