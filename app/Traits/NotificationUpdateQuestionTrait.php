<?php

namespace App\Traits;

use App\Jobs\SendMailUpdateQuestionJob;

trait NotificationUpdateQuestionTrait
{
    public function notifyUsersAboutUpdatedQuestion($question, $child)
    {
        $exams = $question->exams()->get();
        $notifiedUsers = collect();

        foreach ($exams as $exam) {
            $users = $exam->users()->get();

            if (!$users->isEmpty()) {
                foreach ($users as $user) {
                    if (!$notifiedUsers->contains($user->id)) {
                        dispatch(new SendMailUpdateQuestionJob($user, $exam, $child));
                        $notifiedUsers->push($user->id);
                    }
                }
                toastr()->success('Gửi mail thông báo cập nhật câu hỏi thành công!');
            }
        }
    }
}
