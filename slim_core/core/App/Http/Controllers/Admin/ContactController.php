<?php

namespace App\Http\Controllers\Admin;

use App\ReadModel\ContactReadRepository;

class ContactController 
{
    public function index()
    {
        $contactRepository = new ContactReadRepository();

        dd($contactRepository->all()[0]->getComment());
    }
}