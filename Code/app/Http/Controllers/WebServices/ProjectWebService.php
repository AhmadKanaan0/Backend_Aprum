<?php

namespace App\Http\Controllers\WebServices;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UsedConstants\ConstantsAndVariables;
use App\Models\APProject;
use App\Models\APProjectAuthor;
use App\Models\APProjectMeta;
use App\Models\ARArticleServices;
use App\Models\APAuthor;
use App\Models\APBlogHeadline;
use App\Models\APCategory;
use App\Models\APImage;
use App\Models\ARService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectWebService extends Controller
{
    private $commonFunction;

    public function __construct(){
        $this->commonFunction = new CommonFunction();
    }

    protected function getProjectById_API($projectId)
    {
        if($projectId == 0){
            $art = APBlogHeadline::all()->first();
            $projectUID = $art->PROJECT;

        }else {
            $projectUID = $projectId;
        }
        $project = APProject::find($projectUID);
        $data = array();
        array_push($data,$project);

        $authorId = APProjectAuthor::where("PROJECT","=",$projectUID)->first();
        $author = APAuthor::find($authorId->AUTHOR);
        array_push($data,$author);

        $armeta = APProjectMeta::where("PROJECT","=",$projectUID)->first();
        array_push($data,$armeta);

        $image = APImage::where("PROJECT","=",$projectUID)->first();
        array_push($data,$image->LINK);

        return $data;
    }

    protected function getProjectByCategory_API($category){
        $data = array();
        if($category === "All"){
            $projects = APProject::all();
            foreach ($projects as $project){
                array_push($data,$project);
                $image = APImage::where("PROJECT","=",$project->UID)->first();
                if($image) {
                    array_push($data, $image->LINK);
                }else{
                    array_push($data, "");

                }
                $viewer = APProjectMeta::where("PROJECT","=",$project->UID)->first();
                array_push($data,$viewer->READING);

                $author = APProjectAuthor::where("PROJECT","=",$project->UID)->first();
                $auth = APAuthor::find($author->AUTHOR);
                array_push($data,$auth->FIRST_NAME ." ".$auth->LAST_NAME);
            }
            return $data;

        }else {
            $categ = APCategory::where("NAME", "=", $category)->first();

            $projects = APProject::where("CATEGORY", "=", $categ->UID)->get();
            foreach ($projects as $project) {
                array_push($data, $project);
                $image = APImage::where("PROJECT", "=", $project->UID)->first();
                array_push($data, $image->LINK);
                $viewer = APProjectMeta::where("PROJECT", "=", $project->UID)->first();
                array_push($data, $viewer->READING);

                $author = APProjectAuthor::where("PROJECT", "=", $project->UID)->first();
                $auth = APAuthor::find($author->AUTHOR);
                array_push($data, $auth->FIRST_NAME . " " . $auth->LAST_NAME);
            }
            return $data;
        }
    }



    protected function addProject_API(Request $request){
        $project = new APProject();

        $project->TITLE = $request->TITLE;
        $project->ABSTRACT = $request->ABSTRACT;
        $project->HTML = $request->HTML;
        $project->CSS = $request->CSS;
        $project->JS = $request->JS;
        $project->ADATE = Carbon::now();
        $category = APCategory::where("NAME","=",$request->CATEGORY)->first();
        $project->CATEGORY = $category->UID;
        $project->save();

        $projAuth = new APProjectAuthor();
        $projAuth->AUTHOR = $request->AUTHOR;
        $projAuth->ARTICLE = $project->UID;
        $projAuth->save();

        $projMeta = new APProjectMeta();
        $projMeta->ARTICLE = $project->UID;
        $projMeta->save();


//        $services = $request->SERVICES;
//        $data = explode(",",$services);
//
//        foreach ($data as $service){
//
//            $artServices = new ARArticleServices();
//            $artServices->ARTICLE = $project->UID;
//            $serv = ARService::where("NAME","=",$service)->first();
//            $artServices->SERVICE = $serv->UID;
//            $artServices->save();
//        }

        $photo = $request->IMAGES;

            $image = new APImage();
            $image->PROJECT = $project->UID;
            $image->LINK = $this->commonFunction->savePhoto($photo, ConstantsAndVariables::PhotoArticleSrc);
            $image->save();


        return ConstantsAndVariables::Success;

    }

    protected function getCategoryContent_API($categeryId){
        $data = array();
        if(is_numeric($categeryId)) {

            $categories = APCategory::where("ROOT", "=", $categeryId)->get();

            foreach ($categories as $category) {
                array_push($data, $category);
            }
            array_push($data, "End");

            $projects = APProject::where("CATEGORY", "=", $categeryId)->get();

            foreach ($projects as $project) {
                array_push($data, $project);
                $authorId = APProjectAuthor::where("PROJECT","=",$project->UID)->first();
                $author = APAuthor::find($authorId->AUTHOR);
                array_push($data,$author);

                $armeta = APProjectMeta::where("PROJECT","=",$project->UID)->first();
                array_push($data,$armeta);

                $image = APImage::where("PROJECT","=",$project->UID)->first();
                array_push($data,$image->LINK);
            }

            return $data;
        }else{
            $maincat = APCategory::where("NAME","=",$categeryId)->first();
            $categories = APCategory::where("ROOT", "=", $maincat->UID)->get();

            foreach ($categories as $category) {
                array_push($data, $category);
            }
            array_push($data, "End");

           $projects = APProject::where("CATEGORY", "=", $maincat->UID)->get();

            foreach ($projects as $project) {
                array_push($data, $project);
                $authorId = APProjectAuthor::where("ARTICLE","=",$project->UID)->first();
                $author = APAuthor::find($authorId->AUTHOR);
                array_push($data,$author);

                $armeta = APProjectMeta::where("ARTICLE","=",$project->UID)->first();
                array_push($data,$armeta);

                $image = APImage::where("ARTICLE","=",$project->UID)->first();
                array_push($data,$image->LINK);
            }

            return $data;
        }
    }

    protected function getRootCategories_API(){
        $data = array();

        $categories = APCategory::where("ROOT","=",null)->get();
        foreach ($categories as $category){
            array_push($data,$category);
        }
        return $data;
    }

    protected function getBlogHeadline_API(){
        $projects = APBlogHeadline::all();
        $data = array();
        foreach ($projects as $artId){
            $project = APProject::find($artId->ARTICLE);
            array_push($data,$project);
           $image = APImage::where("ARTICLE","=",$project->UID)->first();
            array_push($data,$image->LINK);
           $viewer = APProjectMeta::where("ARTICLE","=",$project->UID)->first();
            array_push($data,$viewer->READING);
        }
        return $data;
    }

    protected function getAllCategories_API(){
       $categories = APCategory::all();
       $data = array();
       foreach ($categories as $category){
           array_push($data , $category->NAME);
        }
       return $data;

    }



    protected function getCategoryName_API($catId){
        $data = array();
        $cat = APCategory::find($catId);
        array_push($data,$cat->NAME);
        return $data;
    }
}
