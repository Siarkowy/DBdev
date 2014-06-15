<?php

// DBdev (c) 2014 by Siarkowy <siarkowy@siarkowy.net>
// Released under the terms of GNU GPL v3 license.

class Application
{
    public function __construct()
    {
        Factory::init();
        $this->dispatch($_REQUEST);
    }

    public function dispatch($request = array())
    {
        switch (@$request['page'])
        {
            case 'event':
                switch (@$request['action'])
                {
                    case 'add':
                        $e = new Event;
                        $e->id = 0;
                        $e->entryOrGUID = (int) @$request['npc'];
                        $view = 'EventEdit';
                        $title = 'Add event';
                        break;

                    case 'edit':
                        $e = Event::get(@$request['id']);
                        $view = 'EventEdit';
                        $title = 'Edit event';
                        break;

                    case 'save':
                        try
                        {
                            $e = new Event($request['e']);
                            $e->save();
                            $this->redirect("?page=scripts&id={$e->entryOrGUID}");
                        }
                        catch(PDOException $e)
                        {
                            echo $e->getMessage();
                        }
                        break;
                }
                break;

            case 'loot':
                $npc = Creature::get(@$request['id']);

                $view = 'Loot';
                $title = $npc ? $npc->name : 'Loot';
                $subtitle = $npc ? $npc->getShortUrl() : null;
                break;

            case 'scripts':
            default:
                $npc = Creature::get(@$request['id']);

                $view = 'Creature';
                $title = 'Scripts';
                $subtitle = $npc ? $npc->getShortUrl() : null;
        }

        if (isset($view))
        {
            include './view.Header.php';
            include "./view.{$view}.php";
            include './view.Footer.php';
        }
    }

    public function redirect($url)
    {
        echo 'redir';
        header("Location: {$url}");
        exit;
    }
}
