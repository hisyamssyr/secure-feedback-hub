<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Valid feedback categories.
     */
    private const CATEGORIES = [
        'Akademik',
        'Sarana Prasarana',
        'Kegiatan Mahasiswa',
    ];

    /**
     * Display the feedback form.
     * Generates a dynamic math captcha and stores the answer in session.
     */
    public function showFeedbackForm(): View
    {
        $numberA = random_int(1, 20);
        $numberB = random_int(1, 20);
        $captchaAnswer = $numberA + $numberB;

        session(['captcha_answer' => $captchaAnswer]);

        return view('feedback.form', [
            'numberA' => $numberA,
            'numberB' => $numberB,
            'categories' => self::CATEGORIES,
        ]);
    }

    /**
     * Process the submitted feedback form.
     */
    public function submitFeedback(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email', 'regex:/^\d{10}@student\.its\.ac\.id$/'],
            'category' => ['required', Rule::in(self::CATEGORIES)],
            'message' => ['required', 'string', 'min:15'],
            'captcha' => ['required', 'numeric'],
        ], [
            'name.required' => 'Nama mahasiswa wajib diisi.',
            'name.min' => 'Nama mahasiswa minimal 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus menggunakan alamat @student.its.ac.id.',
            'email.regex' => 'Email harus menggunakan format NRP (10 digit angka)@student.its.ac.id.',
            'category.required' => 'Kategori masukan wajib dipilih.',
            'category.in' => 'Kategori masukan wajib dipilih.',
            'message.required' => 'Isi pesan wajib diisi.',
            'message.min' => 'Isi pesan minimal 15 karakter.',
            'captcha.required' => 'Jawaban captcha wajib diisi.',
            'captcha.numeric' => 'Jawaban captcha harus berupa angka.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('feedback.form')
                ->withErrors($validator)
                ->withInput();
        }

        $captchaAnswer = session('captcha_answer');

        if ((int) $request->input('captcha') !== (int) $captchaAnswer) {
            return redirect()->route('feedback.form')
                ->withErrors(['captcha' => 'Jawaban captcha salah.'])
                ->withInput();
        }

        Feedback::create($request->only(['name', 'email', 'category', 'message']));

        session()->forget('captcha_answer');

        return redirect()->route('feedback.success');
    }

    /**
     * Display the success page after a valid feedback submission.
     */
    public function feedbackSuccess(): View
    {
        return view('feedback.success');
    }
}
