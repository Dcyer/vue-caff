<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = $this->user()->notifications()->paginate(20);
        $this->user()->markAsRead();
        
        return $this->response->array($notifications);
    }
}
