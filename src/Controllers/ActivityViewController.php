<?php
declare(strict_types=1);
namespace Controllers;

use Database\ActivityViewDAO;
use Models\ActivityViewModel;

class ActivityViewController
{
    private ActivityViewDAO $activityViewDAO;
    private ActivityViewModel $activityViewModel;

    public function Create(ActivityViewModel $activityViewModel, ActivityViewDAO $activityViewDAO) : void {
        $this->activityViewModel = $activityViewModel;
        $this->activityViewDAO = $activityViewDAO;

        $activityViewData = $this->activityViewModel->getDataCreateView();
        if(!$this->activityViewDAO->existsActivityView($activityViewData['activityId'])) {
            $this->activityViewDAO->Create($this->activityViewModel->getDataCreateView());
        }
    }

    public function getActivityViews(int $activityId, ActivityViewDAO $activityViewDAO) : int{
        $this->activityViewDAO = $activityViewDAO;

        return $this->activityViewDAO->getTotalActivityViews($activityId);
    }
}