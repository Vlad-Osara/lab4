<?php

namespace App\Controllers;

use App\Models\Tag;
use App\Models\Url;
use PDO;

class HomeController extends Controller
{
    protected $db;

    public function __construct()
    {
        if (!AUTHGUARD()->isUserLoggedIn()) {
            redirect('/login');
        }

        parent::__construct();
        $this->db = PDO();
    }

    public function index()
    {
        $shortUrl = new Url($this->db);
        $tag = new Tag($this->db);
        $userId = AUTHGUARD()->user()->id;

        $userUrls = $shortUrl->findByUser($userId);
        $userTags = $tag->findByUser($userId);

        //handle tag filtering
        $selectedTags = [];
        if (isset($_GET['tags'])) {
            if (is_array($_GET['tags'])) {
                //handle multiple tags parameters: tag[]s=tag1&tags[]=tag2
                $selectedTags = $_GET['tags'];
            } else {
                $selectedTags = [$_GET['tags']];
            }
        }

        //filter URLs based on selected tags
        if(!empty($selectedTags)) {
            $userUrls = array_filter($userUrls, function($url) use ($selectedTags) {
                $currentTagnames = $url->getTagnames();
                return empty($selectedTags) || !empty(array_intersect($currentTagnames, $selectedTags));
            });
        }

        $flashData = session_get_once('flash_data', []);
        $success = $flashData['success'] ?? '';
        $errors = $flashData['errors'] ?? [];
        $old = $flashData['old'] ?? [];

        $this->sendPage('index', [
            'urls' => $userUrls,
            'tags' => $userTags,
            'selectedTags' => $selectedTags,
            'success' => $success,
            'errors' => $errors,
            'old' => $old
        ]);
    }
}
