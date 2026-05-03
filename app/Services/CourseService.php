<?php

namespace App\Services;

use App\Repositories\CourseRepository;
use App\Repositories\EnrollmentRepository;

class CourseService
{
    protected $courseRepo;
    protected $enrollRepo;

    public function __construct(
        CourseRepository $courseRepo,
        EnrollmentRepository $enrollRepo
    ) {
        $this->courseRepo = $courseRepo;
        $this->enrollRepo = $enrollRepo;
    }

    public function enrollUser($userId, $courseId)
    {
        if ($this->courseRepo->isUserEnrolled($userId, $courseId)) {
            throw new \Exception("Sudah terdaftar");
        }

        return $this->enrollRepo->enroll($userId, $courseId);
    }
}