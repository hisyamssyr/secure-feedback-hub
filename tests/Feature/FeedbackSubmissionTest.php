<?php

namespace Tests\Feature;

use App\Models\Feedback;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedbackSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_feedback_is_stored_in_database(): void
    {
        $this->withSession(['captcha_answer' => 10]);

        $response = $this->post(route('feedback.submit'), [
            'name' => 'John Doe',
            'email' => '1234567890@student.its.ac.id',
            'category' => 'Akademik',
            'message' => 'Ini adalah pesan feedback yang panjang dan valid.',
            'captcha' => '10',
        ]);

        $response->assertRedirect(route('feedback.success'));

        $this->assertDatabaseHas('feedbacks', [
            'email' => '1234567890@student.its.ac.id',
        ]);
    }

    public function test_invalid_feedback_is_not_stored(): void
    {
        $this->withSession(['captcha_answer' => 10]);

        $response = $this->post(route('feedback.submit'), [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'category' => 'Akademik',
            'message' => 'Pesan',
            'captcha' => '10',
        ]);

        $response->assertInvalid(['email', 'message']);
        $this->assertDatabaseCount('feedbacks', 0);
    }

    public function test_captcha_answer_is_not_stored(): void
    {
        $this->withSession(['captcha_answer' => 10]);

        $this->post(route('feedback.submit'), [
            'name' => 'John Doe',
            'email' => '1234567890@student.its.ac.id',
            'category' => 'Akademik',
            'message' => 'Ini adalah pesan feedback yang panjang dan valid.',
            'captcha' => '10',
        ]);

        $feedback = Feedback::first();
        $this->assertNull($feedback->captcha ?? null);
        $this->assertDatabaseMissing('feedbacks', ['name' => '10']);
    }
}
