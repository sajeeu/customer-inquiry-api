<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use App\Models\Inquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class InquiryController extends Controller
{

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

        return response()->json([
            'success' => true,
            'data' => $inquiries,
        ]);
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

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $inquiry->id,
                ],
                'message' => 'Inquiry submitted successfully.',
            ], 201);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Failed to submit inquiry. Please try again.',
            ], 500);
        }
    }

    public function show($id)
    {
        //
    }
}
