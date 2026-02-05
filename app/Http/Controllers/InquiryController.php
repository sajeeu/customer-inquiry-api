<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use App\Models\Inquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class InquiryController extends Controller
{
    private function successResponse($data = null, string $message = null, int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    private function errorResponse(string $message, int $status): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status);
    }



    public function index(): JsonResponse
    {
        $query = Inquiry::query()
            ->orderByDesc('created_at');

        if (request()->filled('category')) {
            $query->where('category', request()->string('category'));
        }

        if (request()->filled('status')) {
            $query->where('status', request()->string('status'));
        }

        $inquiries = $query->paginate(15);

     return $this->successResponse($inquiries);
    }

    public function store(StoreInquiryRequest $request): JsonResponse
    {
        try {
            $inquiry = DB::transaction(function () use ($request) {
                return Inquiry::create([
                    'name' => $request->validated('name'),
                    'email' => $request->validated('email'),
                    'category' => $request->validated('category'),
                    'message' => $request->validated('message'),
                    'status' => 'new',
                ]);
            });

            return $this->successResponse(['id' => $inquiry->id], 'Inquiry submitted successfully.', 201);
        } catch (Throwable $e) {
            report($e);

            return $this->errorResponse('Failed to submit inquiry. Please try again.', 500);

        }
    }

    public function show($id): JsonResponse
    {
        $inquiry = Inquiry::find($id);

        if (!$inquiry) {
            return $this->errorResponse('Inquiry not found.', 404);
        }

            return $this->successResponse($inquiry);
    }
}
