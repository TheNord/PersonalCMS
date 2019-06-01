<?php

namespace App\Http\Controllers\Admin;

use App\ReadModel\PageMetaRepository;
use App\ReadModel\SettingsRepository;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class SettingsController 
{
    public function index()
    {
        return view('app/settings/index');
    }

    public function robots()
    {
        $robots = filesystem(true)->read("robots.txt");
        return view('app/settings/robots', ['robots' => $robots]);
    }

    public function robotsUpdate(RequestInterface $request, ResponseInterface $response)
    {
        $content = $request->getParsedBody()['content'];

        filesystem(true)->put("robots.txt", $content);

        return redirect($response)->with('success', 'Настройки robots.txt успешно обновлены')->route('admin.settings');
    }

    public function project()
    {
        $mailAdmin = getenv('MAIL_ADMIN');
        $projectName = getenv('PROJECT_NAME');
        
        return view('app/settings/project', ['mailAdmin' => $mailAdmin, 'projectName' => $projectName]);
    }

    public function projectUpdate(RequestInterface $request, ResponseInterface $response)
    {
        $data = $request->getParsedBody();

        $mailAdmin = $data['mailAdmin'];
        $projectName = $data['projectName'];

        $env = filesystem()->read(".env");
        
        $replaceName = preg_replace('/PROJECT_NAME=.+/', "PROJECT_NAME='{$projectName}'", $env);
        $replaceMail = preg_replace('/MAIL_ADMIN=.+/', "MAIL_ADMIN={$mailAdmin}", $replaceName);
        
        filesystem()->put(".env", $replaceMail);

        return redirect($response)->with('success', 'Настройки проекта успешно обновлены')->route('admin.settings');
    }

    public function counters()
    {
        $repository = new SettingsRepository();

        $counters = $repository->find('counters');

        return view('app/settings/counters', compact('counters'));
    }

    public function countersUpdate(RequestInterface $request, ResponseInterface $response)
    {
        $value = $request->getParsedBody()['value'];

        $repository = new SettingsRepository();

        $repository->changeValue('counters', $value);

        return redirect($response)->with('success', 'Настройки счётчиков успешно обновлены')->route('admin.settings');
    }

    public function meta()
    {
        $repository = new PageMetaRepository();

        $meta = $repository->find('home');

        return view('app/settings/meta', compact('meta'));
    }

    public function metaUpdate(RequestInterface $request, ResponseInterface $response)
    {
        $data = $request->getParsedBody();

        $title = $data['title'];
        $description = $data['description'];
        $keywords = $data['keywords'];

        $repository = new PageMetaRepository();

        $repository->changeMetaDate('home', $title, $description, $keywords);

        return redirect($response)->with('success', 'Настройки мета информации успешно обновлены')->route('admin.settings');
    }
}