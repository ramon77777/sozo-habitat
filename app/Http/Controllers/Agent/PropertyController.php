<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyVideo;
use Illuminate\Http\Request;

class PropertyController extends Controller
{


    public function index()
    {

        $properties = Property::where(
            'user_id',
            auth()->id()
        )
        ->latest()
        ->paginate(10);


        return view(
            'agent.properties.index',
            compact('properties')
        );

    }





    public function create()
    {

        return view(
            'agent.properties.create'
        );

    }







    public function store(Request $request)
    {


        $validated = $request->validate([


            'title'=>'required|string|max:255',

            'price'=>'required|numeric',

            'city'=>'required|string',

            'district'=>'nullable|string',

            'address'=>'nullable|string',


            'latitude'=>'nullable',

            'longitude'=>'nullable',


            'surface'=>'nullable|numeric',


            'type'=>'required',

            'transaction'=>'required',


            'description'=>'nullable',


            'main_image'=>'nullable|image',

            'gallery_images.*'=>'nullable|image',

            'property_videos.*'=>'nullable|mimes:mp4,mov,webm',


        ]);





        $validated['user_id'] = auth()->id();





        /*
        |--------------------------------------------------------------------------
        | IMAGE PRINCIPALE
        |--------------------------------------------------------------------------
        */


        if($request->hasFile('main_image')){


            $image = $request->file('main_image');


            $filename = time().'_'.$image->getClientOriginalName();


            $image->move(
                public_path('images/properties'),
                $filename
            );


            $validated['main_image'] = $filename;

        }







        $property = Property::create($validated);







        /*
        |--------------------------------------------------------------------------
        | GALERIE
        |--------------------------------------------------------------------------
        */


        if($request->hasFile('gallery_images')){


            foreach($request->file('gallery_images') as $image){


                $filename =
                time().'_'.$image->getClientOriginalName();



                $image->move(
                    public_path('images/properties/gallery'),
                    $filename
                );



                PropertyImage::create([

                    'property_id'=>$property->id,

                    'image_path'=>$filename

                ]);


            }


        }







        /*
        |--------------------------------------------------------------------------
        | VIDEOS
        |--------------------------------------------------------------------------
        */


        if($request->hasFile('property_videos')){


            foreach($request->file('property_videos') as $video){


                $filename =
                time().'_'.$video->getClientOriginalName();



                $video->move(
                    public_path('videos/properties'),
                    $filename
                );



                PropertyVideo::create([

                    'property_id'=>$property->id,

                    'video_path'=>$filename

                ]);


            }

        }






        return redirect()

        ->route('agent.properties.index')

        ->with(
            'success',
            'Bien ajouté avec succès'
        );


    }









    public function edit(Property $property)
    {


        abort_if(

            $property->user_id !== auth()->id(),

            403

        );



        return view(

            'agent.properties.edit',

            compact('property')

        );

    }









    public function update(
        Request $request,
        Property $property
    )
    {


        abort_if(

            $property->user_id !== auth()->id(),

            403

        );






        $validated = $request->validate([


            'title'=>'required|string|max:255',

            'price'=>'required|numeric',

            'city'=>'required|string',

            'district'=>'nullable',

            'address'=>'nullable',


            'latitude'=>'nullable',

            'longitude'=>'nullable',


            'surface'=>'nullable',


            'type'=>'required',

            'transaction'=>'required',


            'description'=>'nullable',


            'main_image'=>'nullable|image',

            'gallery_images.*'=>'nullable|image',

            'property_videos.*'=>'nullable|mimes:mp4,mov,webm',

        ]);







        /*
        |--------------------------------------------------------------------------
        | Nouvelle image principale
        |--------------------------------------------------------------------------
        */


        if($request->hasFile('main_image')){


            $image=$request->file('main_image');


            $filename=time().'_'.$image->getClientOriginalName();



            $image->move(

                public_path('images/properties'),

                $filename

            );



            $validated['main_image']=$filename;


        }







        $property->update($validated);








        /*
        |--------------------------------------------------------------------------
        | Galerie supplémentaire
        |--------------------------------------------------------------------------
        */


        if($request->hasFile('gallery_images')){


            foreach($request->file('gallery_images') as $image){


                $filename=time().'_'.$image->getClientOriginalName();



                $image->move(

                    public_path('images/properties/gallery'),

                    $filename

                );



                PropertyImage::create([

                    'property_id'=>$property->id,

                    'image_path'=>$filename

                ]);


            }


        }








        /*
        |--------------------------------------------------------------------------
        | Vidéos supplémentaires
        |--------------------------------------------------------------------------
        */


        if($request->hasFile('property_videos')){


            foreach($request->file('property_videos') as $video){


                $filename=time().'_'.$video->getClientOriginalName();



                $video->move(

                    public_path('videos/properties'),

                    $filename

                );



                PropertyVideo::create([

                    'property_id'=>$property->id,

                    'video_path'=>$filename

                ]);


            }


        }







        return redirect()

        ->route('agent.properties.index')

        ->with(

            'success',

            'Bien modifié avec succès'

        );


    }










    public function destroy(Property $property)
    {


        abort_if(

            $property->user_id !== auth()->id(),

            403

        );



        $property->delete();



        return back()

        ->with(

            'success',

            'Bien supprimé'

        );


    }



}