<?php

namespace App\Http\Controllers;

use App\DataTables\TestimonialsDataTable;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index(TestimonialsDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-testimonial')) {
            return $dataTable->render('testimonials.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('create-testimonial')) {
            return view('testimonials.create');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create-testimonial')) {
            request()->validate([
                'name'          => 'required|max:191',
                'title'         => 'required|max:191',
                'desc'          => 'required',
                'designation'   => 'required|max:100',
                'image'         => 'required|mimes:jpg, jpeg, png',
                'rating'        => 'required',

            ]);

			if ($request->file('image')) {
                $allowed_file_Extension = ['jpeg', 'jpg', 'png'];
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $imageName =$file->getClientOriginalName();
                $check = in_array($extension, $allowed_file_Extension);
                if ($check) {
                    $file_name  =  $file->store('testimonials');
                } else {
                    return redirect()->route('testimonial.index')->with('failed', __('File type not valid.'));
                }
            }
            else{
                return redirect()->back()->with('failed', __('Image Field is Required'));
            }

            $testimonial = Testimonial::create([
                'name'          => $request->name,
                'title'         => $request->title,
                'desc'          => $request->desc,
                'designation'   => $request->designation,
                'image'         => $file_name,
                'rating'        => $request->rating,
            ]);

            return redirect()->route('testimonial.index')->with('success', 'Testimonial created succesfully..!');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
    public function edit($id)
    {
        if (\Auth::user()->can('edit-testimonial')) {
            $testimonial = Testimonial::find($id);
            return view('testimonials.edit', compact('testimonial'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit-testimonial')) {
            $updateTestimonial = Testimonial::find($id);
              if ($request->hasfile('image')) {
                $allowedFileExtension = ['jpeg', 'jpg', 'png'];
                $file                   = $request->file('image');
                $extension              = $file->getClientOriginalExtension();
                $imageName             = $file->getClientOriginalName();
                $check                  = in_array($extension, $allowedFileExtension);
                if ($check) {
                    $fileName  =  $file->store('testimonials');
                } else {
                    return redirect()->route('testimonial.index')->with('failed', __('File type not valid.'));
                }
                $updateTestimonial->image = $fileName;
            }
            $updateTestimonial->name          = $request->name;
            $updateTestimonial->title         = $request->title;
            $updateTestimonial->desc          = $request->desc;
            $updateTestimonial->rating        = $request->rating;
            $updateTestimonial->designation   = $request->designation;
            $updateTestimonial->save();

            return redirect()->route('testimonial.index')->with('success', __('Testimonial updated successfully'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if(\Auth::user()->can('delete-testimonial')){
            $deleteTestimonial = Testimonial::find($id);
            $deleteTestimonial->delete();
            return back()->with('success', 'Tetimonials Deleted succesfully');
        }
        else{
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function status(Request $request, $id)
    {
        $testimonial = Testimonial::find($id);
        $input       = ($request->value == "true") ? 1 : 0;
        if ($testimonial) {
            $testimonial->status = $input;
            $testimonial->save();
        }
        return response()->json(['is_success' => true, 'message' => __('Testimonial status changed successfully.')]);
    }
}
