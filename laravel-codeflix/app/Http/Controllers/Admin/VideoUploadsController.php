<?php

namespace CodeFlix\Http\Controllers\Admin;

use CodeFlix\Forms\VideoUploadForm;
use CodeFlix\Models\Video;
use CodeFlix\Repositories\VideoRepository;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;

class VideoUploadsController extends Controller
{
    private $repository;

    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(Video $video)
    {
        $form = \FormBuilder::create(VideoUploadForm::class, [
            'url' => route('admin.videos.uploads.store',['video' => $video->id]),
            'method' => 'POST',
            'model' => $video
        ]);

        return view('admin.videos.upload', compact('form'));
    }

    public function store(Request $request, $id)
    {
        $form = \FormBuilder::create(VideoUploadForm::class);

        if (!$form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        if($request->file('thumb')){
            $this->repository->uploadThumb($id, $request->file('thumb'));
        }

        if($request->file('file')){
            $this->repository->uploadFile($id, $request->file('file'));
        }

        $this->repository->update(['duration' => $request->get('duration')], $id);

        $request->session()->flash('message', 'Uploads realizados com sucesso!');

        return redirect()->route('admin.videos.uploads.create', ['video' => $id]);
    }
}
