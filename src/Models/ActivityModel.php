<?php
declare(strict_types=1);
namespace Models;

use Traits\AuthInputs;

class ActivityModel
{
    private int $id;
    private int $views;
    private string $summary;
    private string $metaTitle;
    private string $title;
    private string $metaDescription;
    private string $description;
    private string $cover;
    private string $content;
    private string $date;

    use AuthInputs;

    public function getDataCreateFromPost() : array {
        if(isset($_POST["submit"])){
            $this->summary = $_POST["summary"];
            $this->metaTitle = filter_input(INPUT_POST, "meta-title", FILTER_SANITIZE_STRING);
            $this->title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
            $this->metaDescription = filter_input(INPUT_POST, "meta-description", FILTER_SANITIZE_STRING);
            $this->description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
            $this->cover = filter_input(INPUT_POST, "cover-image", FILTER_SANITIZE_STRING);
            $this->content = $_POST["content"];

            $data = [
                "meta-title" => $this->metaTitle,
                "title" => $this->title,
                "meta-description" => $this->metaDescription,
                "description" => $this->description,
                "cover-image" => $this->cover
            ];

            foreach($data as $key => $value){
                $data[$key] = htmlspecialchars($value);
            }

            $data["summary"] = $this->summary;
            $data["content"] = $this->content;

            return $data;
        }
        return [];
    }

    public function getDataUpdateFromPost() : array{
        if(isset($_POST["submit"])){
            $this->summary = $_POST["summary"];
            $this->metaTitle = filter_input(INPUT_POST, "meta-title", FILTER_SANITIZE_STRING);
            $this->title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
            $this->metaDescription = filter_input(INPUT_POST, "meta-description", FILTER_SANITIZE_STRING);
            $this->description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
            $this->cover = filter_input(INPUT_POST, "cover-image", FILTER_SANITIZE_STRING);
            $this->content = $_POST["content"];

            $data = [
                "meta-title" => $this->metaTitle,
                "title" => $this->title,
                "meta-description" => $this->metaDescription,
                "description" => $this->description,
                "cover-image" => $this->cover
            ];

            foreach($data as $key => $value){
                $data[$key] = htmlspecialchars($value);
            }

            $data["summary"] = $this->summary;
            $data["content"] = $this->content;

            return $data;
        }
        return [];
    }

    public function calculateReadingTime(string $content) : float {
        $noTagsContent = (strip_tags($content));
        $totalWords = str_word_count($noTagsContent);
        $readingTime = ceil($totalWords / 225);

        return $readingTime;
    }

    public function returnDifferentRandomIds(array $allActivitiesIds, int $currentActivityId) : array {
        $randomIds = [];

        if(count($allActivitiesIds) <= 2){
            do{
                $randomIds[0] = $allActivitiesIds[array_rand($allActivitiesIds)]['id'];
            }
            while($randomIds[0] === $currentActivityId);


        }

        if(count($allActivitiesIds) >= 3){
            do{
                $randomIds[0] = $allActivitiesIds[array_rand($allActivitiesIds)]['id'];
            }
            while($randomIds[0] === $currentActivityId);

            do{
                $randomIds[1] = $allActivitiesIds[array_rand($allActivitiesIds)]['id'];
            }
            while($randomIds[1] === $currentActivityId || $randomIds[1] === $randomIds[0]);
        }

        return $randomIds;
    }
}