<?php
declare(strict_types=1);
namespace Models;

class ActivityViewModel
{
    private int $viewId;
    private int $activityId;
    private string $userAgent;
    private string $userIp;
    private string $viewDate;

    public function getDataCreateView() : array{
        $this->activityId = (int)filter_var($_GET['id'], FILTER_SANITIZE_STRING);
        $this->userAgent = filter_var($_SERVER['HTTP_USER_AGENT'], FILTER_SANITIZE_STRING);
        $this->userIp = $_SERVER['REMOTE_ADDR'];

        return [
            'activityId' => $this->activityId,
            'userAgent' => $this->userAgent,
            'userIp' => $this->userIp,
        ];
    }
}