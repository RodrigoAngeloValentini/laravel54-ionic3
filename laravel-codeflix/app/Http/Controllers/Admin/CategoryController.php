<?php

namespace CodeFlix\Http\Controllers\Admin;

use CodeFlix\Forms\CategoryForm;
use CodeFlix\Models\Category;
use CodeFlix\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\Facades\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class CategoryController extends Controller
{
    use FormBuilderTrait;

    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $categories = $this->repository->paginate();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $form = $this->form('CodeFlix\Forms\CategoryForm', [
            'method' => 'POST',
            'url' => route('admin.categories.store'),
        ]);

        return view('admin.categories.create', compact('form'));
    }

    public function store(Request $request)
    {
        $form = $this->form(CategoryForm::class);

        if (!$form->isValid()) {

            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = $form->getFieldValues();
        $this->repository->create($data);

        $request->session()->flash('message', 'Categoria criada com sucesso!');

        return redirect()->route('admin.categories.index');
    }

    public function show($id)
    {
        $category = $this->repository->find($id);

        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $form = FormBuilder::create(CategoryForm::class, [
            'url' => route('admin.categories.update', ['category' => $category->id]),
            'method' => 'PUT',
            'model' => $category
        ]);

        return view('admin.categories.edit', compact('form'));
    }

    public function update(Request $request, $id)
    {
        $form = FormBuilder::create(CategoryForm::class, [
            'data' => ['id' => $id]
        ]);

        if (!$form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $this->repository->update($form->getFieldValues(), $id);

        $request->session()->flash('message', 'Categoria alterada com sucesso!');

        return redirect()->route('admin.categories.index');
    }


    public function destroy(Request $request, $id)
    {
        $this->repository->delete($id);
        $request->session()->flash('message', "Categoria ID: <strong>{$id}</strong> excluída com sucesso!");
        return redirect()->route('admin.categories.index');
    }
}