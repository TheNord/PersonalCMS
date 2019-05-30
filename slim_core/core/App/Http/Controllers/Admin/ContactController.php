<?php

namespace App\Http\Controllers\Admin;

use App\ReadModel\ContactReadRepository;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ContactController 
{
    private $contactRepository;

    public function __construct()
    {
        $this->contactRepository = new ContactReadRepository();
    }

    public function index()
    {
        $contacts = $this->contactRepository->all();

        return view('app/contacts/index', ['contacts' => $contacts]);
    }

    public function destroy(RequestInterface $request, ResponseInterface $response)
    {
        $contactId = $request->getAttribute('id');

        $this->contactRepository->delete($contactId);

        return redirect($response)->with('success', 'Запись была успешно удалена!')->route('admin.contacts');
    }
}