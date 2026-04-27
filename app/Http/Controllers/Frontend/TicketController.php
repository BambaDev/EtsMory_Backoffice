<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\SupportTicketManager;

class TicketController extends Controller
{
    use SupportTicketManager;

    public function __construct()
    {
        $this->layout = 'master';
        $this->redirectLink = 'ticket.view';
        $this->userType     = 'user';
        $this->column       = 'user_id';
        $this->user = auth()->user();
        
        if ($this->user) {
            $this->layout = 'user';
        }
    }
}
