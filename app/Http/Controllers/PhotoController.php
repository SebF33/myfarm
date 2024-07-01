<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{

  public function store(Request $request, Animal $animal)
  {
    $request->validate([
      'newPhotos.*' => 'nullable|file|image',
    ]);

    if ($request->hasFile('newPhotos')) {
      foreach ($request->file('newPhotos') as $file) {
        $path = $file->store('public/photos');
        $animal->photos()->create(['file_path' => $path]);
      }
    }

    return redirect()->route('animals.show', $animal);
  }


  public function destroy(Photo $photo)
  {
    $photo->delete();

    return redirect()->back();
  }
}
