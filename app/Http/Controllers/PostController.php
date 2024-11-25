<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\Interfaces\PostRepositoryInterface;

class PostController extends Controller
{

    public function __construct(PostRepositoryInterface $postRepositoryInterface)
    {
        $this->postRepositoryInterface = $postRepositoryInterface;
    }

    public function post_select(Request $request)
    {
        $data = $this->postRepositoryInterface->getServerSideDataForSelectOption($request->search, ['is_active' => 1], ['name','date'], 'id', 'name', '10');
        return response()->json($data);
    }
}
