<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Breed;
use App\Models\Mammal;
use App\Models\Photo;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;


class AnimalController extends Controller
{
    /**
     *
     * @return Response
     */
    public function index()
    {
        $animals = Animal::with('breed', 'mammal', 'photos', 'status')->get();

        return Inertia::render('Animals/Index', ['animals' => $animals]);
    }


    /**
     *
     * @return response()
     */
    public function create()
    {
        $breeds = Breed::all();
        $mammals = Mammal::all();
        $statuses = Status::all();

        return Inertia::render('Animals/Create', [
            'breeds' => $breeds,
            'mammals' => $mammals,
            'statuses' => $statuses,
        ]);
    }


    /**
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'age' => ['required', 'numeric', 'max:99'],
            'mammal_id' => ['required'],
            'breed_id' => ['required'],
            'description' => ['required', 'string'],
            'status_id' => ['required'],
            'htprice' => ['required', 'numeric'],
            'photo' => ['nullable', 'image'],
        ])->validate();

        $animal = Animal::create($request->all());

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('public/photos');
            $animal->photos()->create(['file_path' => $path]);
        }

        return redirect()->route('animals.index');
    }


    /**
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function edit(Animal $animal)
    {
        $breeds = Breed::all();
        $mammals = Mammal::all();
        $photos = Photo::where('animal_id', $animal->id)->get();
        $statuses = Status::all();

        return Inertia::render('Animals/Edit', [
            'animal' => $animal,
            'breeds' => $breeds,
            'mammals' => $mammals,
            'photos' => $photos,
            'statuses' => $statuses,
        ]);
    }


    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'age' => ['required', 'numeric', 'max:99'],
            'mammal_id' => ['required'],
            'breed_id' => ['required'],
            'description' => ['required', 'string'],
            'status_id' => ['required'],
            'htprice' => ['required', 'numeric'],
            'newPhotos.*' => ['nullable', 'file', 'image'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $animal = Animal::findOrFail($id);
        $animal->update($request->except('newPhotos'));

        if ($request->hasFile('newPhotos')) {
            foreach ($request->file('newPhotos') as $file) {
                $path = $file->store('public/photos');
                $animal->photos()->create(['file_path' => $path]);
            }
        }

        return redirect()->route('animals.index');
    }


    /**
     *
     * @return Response
     */
    public function destroy($id)
    {
        Animal::find($id)->delete();

        return redirect()->route('animals.index');
    }


    /**
     *
     * @param  int  $photoId
     * @return \Illuminate\Http\JsonResponse
     */
    public function removePhoto($photoId)
    {
        $photo = Photo::find($photoId);

        if ($photo) {
            $photo->delete();
            return response()->json(['message' => 'Photo supprimée avec succès.'], 200);
        }

        return response()->json(['message' => 'Photo introuvable.'], 404);
    }
}
