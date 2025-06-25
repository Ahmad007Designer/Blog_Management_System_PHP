<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Upload extends Controller
{
    public function image()
    {
        $file = $this->request->getFile('upload');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $newName);

            // ✅ This exact format is required by CKEditor
            return $this->response->setJSON([
                'url' => base_url('uploads/' . $newName)
            ]);
        }

        return $this->response->setJSON([
            'error' => [
                'message' => 'The file could not be uploaded.'
            ]
        ]);
    }
}
