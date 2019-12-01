<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;

class ChatController extends Controller
{
  public function chat_list(){

     $this->checkuserRole(['admin','super-admin','branch-manager'],'');
     return view ('backend.chat.chat_view');
  }
}
