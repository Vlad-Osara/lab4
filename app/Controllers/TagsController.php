<?php

namespace App\Controllers;

use App\Models\Tag;

class TagsController extends Controller {

    private Tag $tag;
    protected $db;

    public function __construct()
    {
        if (!AUTHGUARD()->isUserLoggedIn()) {
            redirect('/login');
        }

        parent::__construct();
        $this->db = PDO();
        $this->tag = new Tag($this->db);
    }

    public function update() {
        $id = $_POST['id'] ?? 0;
        $data = [
            'name' =>$_POST['name'] ?? ''
        ];

        //Find the Tag directly by ID and ensure it belongs to the current user
        $targetTag = $this->tag->findById($id, AUTHGUARD()->user()->id);
        if (!$targetTag) {
            redirect('/', [
                'flash_data' => ['errors' => 'Update tag unsuccessfully']
        ]);
        }

        $errors = $targetTag->validate($data, AUTHGUARD()->user()->id);

        if(empty($errors)) {
            $targetTag->update($data['name']);
            redirect('/', [
                'flash_data' => ['success' => 'Update Tag successfully']
            ]);
        } else {
            redirect('/', [
                'flash_data' => ['errors' => $errors, 'old' => $data]
            ]);
        }
    }

    public function delete() {
        $id = $_POST['id'] ?? 0;

        //Find the Tag directly by ID and ensure it belongs to the current user
        $targetTag = $this->tag->findById($id, AUTHGUARD()->user()->id);
        if (!$targetTag) {
            redirect('/', [
                'flash_data' => ['errors' => 'Delete tag unsuccessfully']
        ]);
        }

        $targetTag->delete();
        redirect('/', [
                'flash_data' => ['success' => 'Delete tag successfully']
        ]);
    }
}