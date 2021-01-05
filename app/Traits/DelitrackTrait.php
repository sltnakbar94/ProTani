<?php

namespace App\Traits;
use Image;
use Storage;
use Str;
trait DelitrackTrait {

    public function uploadBanner($value, $attribute_name, $disk, $destination_path, $attribute_name_thumbnail = FALSE, $re_size = 364)
    {
        $request = \Request::instance();

        // if a new file is uploaded, delete the file from the disk
        if ($request->hasFile($attribute_name) &&
            $this->{$attribute_name} &&
            $this->{$attribute_name} != null) {
            \Storage::disk($disk)->delete($this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }

        // if the file input is empty, delete the file from the disk
        if (is_null($value) && $this->{$attribute_name} != null) {
            \Storage::disk($disk)->delete($this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }

        // if a new file is uploaded, store it on disk and its filename in the database
        if ($request->hasFile($attribute_name) && $request->file($attribute_name)->isValid()) {
            // 1. Generate a new file name
            $file = $request->file($attribute_name);

            $orig_name = md5($file->getClientOriginalName().time());

            $new_file_name = $orig_name . '.' . $file->getClientOriginalExtension();
            $new_file_name_thumbnail = $orig_name . '_original' . '.' . $file->getClientOriginalExtension();

            // 2. Move the new file to the correct path
            $file_path = $file->storeAs($destination_path, $new_file_name, $disk);

            // 3. Save the complete path to the database
            $this->attributes[$attribute_name] = $file_path;

            if($attribute_name_thumbnail != FALSE) {
                $file_path_thumbnail = $file->storeAs($destination_path, $new_file_name_thumbnail, $disk);
                // dd($file_path_thumbnail);
                // $this->attributes[$attribute_name_thumbnail] = $file_path_thumbnail;

                //! This is your homework lihar you change this to disk banner properly
                $thumbnailpath = public_path('storage/banner/' . $file_path_thumbnail);
                

                $img_medium = Image::make($thumbnailpath)->resize(800, 600);
                $img_medium->save($thumbnailpath);

                $img_small = Image::make($thumbnailpath)->resize(400, 300);
                $img_small->save($thumbnailpath);
            }
        }
    }

    public function setActiveAttribute($value)
    {
        $this->attributes['active'] = (bool)filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    function getUniqueCode($total_string = 8)
    {
        while(true) {
            $randomString = strtoupper(Str::random($total_string));
            $is_exist = self::whereCode($randomString)->count();

            if (! $is_exist) {
                return $randomString;
            }
        }
    }

    public function uploadFileToDiskResponsive($value, $attribute_name, $disk, $destination_path)
    {
        // if a new file is uploaded, delete the file from the disk
        if (request()->hasFile($attribute_name) &&
            $this->{$attribute_name} &&
            $this->{$attribute_name} != null) {
            \Storage::disk($disk)->delete($this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }

        // if the file input is empty, delete the file from the disk
        if (is_null($value) && $this->{$attribute_name} != null) {
            \Storage::disk($disk)->delete($this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }

        // if a new file is uploaded, store it on disk and its filename in the database
        if (request()->hasFile($attribute_name) && request()->file($attribute_name)->isValid()) {
            // 1. Generate a new file name
            $file = request()->file($attribute_name);
            $extension = '.' . $file->getClientOriginalExtension();
            $filename = md5($file->getClientOriginalName().random_int(1, 9999).time()) . '_original' . $extension;
            $image_path = $destination_path.'/'.$filename;

            $original = \Image::make($file);
            $original->save();
            \Storage::disk($disk)->put($image_path, $original);

            // 3. Save the complete path to the database
            $this->attributes[$attribute_name] = $image_path;

            $this->imageResponsives($image_path, $extension, $disk);
        }
    }

    public function imageResponsives($image_path, $extension, $disk)
    {
        $file = \Storage::disk($disk)->get($image_path);
        $canvas = \Image::canvas(480, 480);

        // save to large
        $image = \Image::make($file)->resize(480, 480, function ($constraint) {
            $constraint->aspectRatio();
        });
        $canvas->insert($image, 'center');
        $large_path = str_replace('_original' . $extension, '_large'. $extension, $image_path);
        $canvas->save(\Storage::disk($disk)->path($large_path));

        // save to medium
        $large = \Storage::disk($disk)->get($large_path);
        $medium = \Image::make($large)->resize(240, 240);
        $medium_path = str_replace('_original' . $extension, '_medium'. $extension, $image_path);
        $medium->save(\Storage::disk($disk)->path($medium_path));

        // save to small
        $large = \Storage::disk($disk)->get($large_path);
        $small = \Image::make($large)->resize(72, 72);
        $small_path = str_replace('_original' . $extension, '_small'. $extension, $image_path);
        $small->save(\Storage::disk($disk)->path($small_path));
    }

    public function getResponsiveImage($size, $image)
    {
        if(!isset(pathinfo($image)['extension'])) {
            return '#';
        }
        return str_replace('_original.'.pathinfo($image)['extension'], '_' . $size . '.' . pathinfo($image)['extension'], $image);
    }
}