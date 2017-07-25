<?php

namespace CodeFlix\Http\Controllers\Admin;

use CodeFlix\Models\Video;
use CodeFlix\Repositories\VideoRepository;
use CodeFlix\Forms\VideoForm;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\Form;

class VideoController extends Controller
{
    private $repository;

    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $videos = $this->repository->paginate();
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        $form = \FormBuilder::create(VideoForm::class, [
            'url' => route('admin.videos.store'),
            'method' => 'POST'
        ]);

        return view('admin.videos.create', compact('form'));
    }

    public function store(Request $request)
    {
        $form = \FormBuilder::create(VideoForm::class);

        if (!$form->isValid()) {

            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = $form->getFieldValues();

        $this->repository->create($data);

        $request->session()->flash('message', 'Video cadastrado com sucesso!');

        return redirect()->route('admin.videos.index');
    }

    public function show(Video $video)
    {
        return view('admin.videos.show', compact('video'));
    }

    public function edit(Video $video)
    {
        $form = \FormBuilder::create(VideoForm::class, [
            'url' => route('admin.videos.update', ['video' => $video->id]),
            'method' => 'PUT',
            'model' => $video
        ]);

        return view('admin.videos.edit', compact('form'));
    }

    public function update(Request $request, $id)
    {
        $form = \FormBuilder::create(VideoForm::class);

        if (!$form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = $form->getFieldValues();
        $this->repository->update($data, $id);

        $request->session()->flash('message', 'Video alterada com sucesso!');

        return redirect()->back();
    }


    public function destroy($id)
    {
        $this->repository->delete($id);
        return redirect()->route('admin.videos.index');
    }

    public function fileAsset(Video $video)
    {
        return response()->download($video->file_path);
    }

    public function thumbAsset(Video $video)
    {
        return response()->download($video->thumb_path);
    }

    public function thumbSmallAsset(Video $video)
    {
        return response()->download($video->thumb_small_path);
    }
}
